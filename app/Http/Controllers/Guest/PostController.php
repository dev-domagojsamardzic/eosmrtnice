<?php

namespace App\Http\Controllers\Guest;

use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Models\County;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Kudashevs\ShareButtons\ShareButtons;

class PostController extends Controller
{
    /**
     * Return post type
     *
     * @return PostType|null
     */
    protected function getPostType(): ?PostType
    {
        return null;
    }

    /**
     * Return latest X starts_at dates from posts table
     * @param int $days
     * @param string|null $before
     * @return array
     */
    protected function getLatestDates(int $days = 1, string $before = null): array
    {
        $postType = $this->getPostType();

        return DB::table('posts')
            ->select('starts_at')
            ->distinct()
            ->where('starts_at', '<=', now()->toDateString())
            ->where('is_active', 1)
            ->where('is_approved', 1)
            ->when($postType, function($query) use ($postType) {
                return $query->where('type', $postType);
            })
            ->orderBy('starts_at', 'desc')
            ->limit($days)
            ->pluck('starts_at')
            ->toArray();
    }

    /**
     * Return next date before date
     * @param string $date
     * @return string|null
     */
    protected function getDateBefore(string $date): string|null
    {
        $postType = $this->getPostType();
        return Post::query()
            ->where('starts_at', '<', $date)
            ->where('is_active', true)
            ->where('is_approved', true)
            ->when($postType, function($query) use ($postType) {
                return $query->where('type', $postType);
            })
            ->max('starts_at');
    }

    /**
     * Return
     * @param array $dates
     * @return Builder
     */
    protected function query(array $dates): Builder
    {
        $postType = $this->getPostType();

        return Post::query()
            ->whereIn('starts_at', $dates)
            ->where('is_active', true)
            ->where('is_approved', true)
            ->when($postType, function($query) use ($postType) {
                return $query->where('type', $postType);
            })
            ->orderByDesc('starts_at');
    }

    /**
     * Show a post
     * @param Post $post
     * @return View
     */
    public function show(Post $post): View
    {
        $social = (new ShareButtons)->page($post->url, $post->deceased_full_name_lg, [
            'title' => config('app.name'),
            'rel' => 'nofollow noopener noreferrer',
        ])->facebook()->whatsapp()->getRawLinks();

        $isCandleLit = request()?->cookie(config('app.name').'_candles_'.$post->id);

        return view('guest.post',[
            'post' => $post,
            'isCandleLit' => $isCandleLit,
            'social' => $social,
        ]);
    }

    /**
     * Handles "light a candle" action
     * @param Request $request
     * @return JsonResponse
     */
    public function candle(Request $request): JsonResponse
    {
        $post = $request->input('post');

        if (!$post) {
            return response()
                ->json(['success' => false, 'message' => 'Podatci nepotpuni.'], 400);
        }

        if ($request->cookie(config('app.name') . '_candles_'.$post)) {
            return response()
                ->json(['id' => $post, 'success' => true, 'increment' => 0, 'message' => __('guest.candle_lit')]);
        }

        // returns int
        Post::query()
            ->where('id', $post)
            ->increment('candles');

        $cookie = cookie(
            config('app.name') . '_candles_'.$post,
            now()->timestamp,
            60 * 24 * 90,
            '/',
            secure: false, // TODO: set to true
            httpOnly: false, // TODO: remove this
            sameSite: 'Lax',
        );

        return response()
            ->json(['id' => $post, 'success' => true, 'increment' => 1,'message' => __('guest.candle_lit_successfuly')])
            ->withCookie($cookie);
    }

    /**
     * Return mixed items when "load more"
     * @param Request $request
     * @return JsonResponse
     */
    public function items(Request $request): JsonResponse
    {
        $date = $request->input('date');

        if($date === null) {
            return response()->json([],204);
        }

        // Formatted date for -- title --
        $dateFormatted = Carbon::parse($date)->format('d.m.Y');

        $posts = $this->query([$date])->get();

        $html = view('partials/posts-masonry-block',['date' => $dateFormatted, 'collection' => $posts])->render();

        // Calculate next date to be loaded
        $nextDate = $this->getDateBefore($date);

        return response()->json([
            'content' => $html,
            'date' => $nextDate
        ]);
    }

    /**
     * Search posts
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request): View
    {
        $name = $request->input('name');
        $date = $request->input('date');
        $county = $request->input('county_id', 0);

        $county = County::query()->where('id', $county)->first();
        $search_county = $county?->title;

        $posts = Post::query()
            ->where('is_active', true)
            ->where('is_approved', true)
            ->when($name, function ($query, $name) {
                $search = strtolower(trim($name));
                $query->where('deceased_full_name_lg', 'like', '%'.$search.'%');
            })
            ->when($date, function ($query, $date) {
                $dateFormatted = Carbon::parse($date)->format('Y-m-d');
                $query->whereDate('starts_at',  $dateFormatted);
            })
            ->when($county, function ($query, $county) {
                $query->where('funeral_county_id', $county);
            })
            ->when(!$name && !$date && !$county, function($query) {
                $latestDates = $this->getLatestDates();
                $query->whereIn('starts_at', $latestDates);
            })
            ->orderByDesc('starts_at')
            ->get()
            ->groupBy(function($item, $key) {
                return $item->starts_at->format('d.m.Y.');
            });

        return view('guest.search', compact('posts', 'name', 'date', 'county','search_county'));
    }
}
