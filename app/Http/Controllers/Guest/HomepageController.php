<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomepageController extends Controller
{
    /**
     * Load homepage
     * @return View
     */
    public function home(): View
    {
        // Take last 3 dates
        // Use latest 2 dates for first posts query
        // Use third latest date (if exists) for loadMoreBtn
        $latestDates = $this->getLatestDates(3);

        if (count($latestDates) === 0) {
            return view('homepage',[
                'posts' => collect([]),
                'nextDateToLoad' => null,
            ]);
        }

        $nextDateToLoad = (count($latestDates) === 3) ? array_pop($latestDates) : null;

        // First loading, only show posts from 2 latest dates inserted
        $posts = Post::query()
            ->forDisplay()
            ->todayOrOlder()
            ->whereIn('starts_at', $latestDates)
            ->orderByDesc('starts_at')
            ->inRandomOrder()
            ->get()
            ->groupBy(function($item, $key) {
                return $item->starts_at->format('d.m.Y.');
            });

        return view('homepage',[
            'posts' => $posts,
            'nextDateToLoad' => $nextDateToLoad,
        ]);
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

        $dateFormatted = Carbon::parse($date)->format('d.m.Y');

        $posts = Post::query()
            ->forDisplay()
            ->where('starts_at', $request->date)
            ->inRandomOrder()
            ->get();

        $html = view('partials/posts-masonry-block',['date' => $dateFormatted, 'collection' => $posts])->render();

        // Calculate next date to be loaded
        $nextDate = Post::query()
            ->forDisplay()
            ->where('starts_at', '<', $date)
            ->max('starts_at');

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

        $posts = Post::query()
            ->forDisplay()
            ->todayOrOlder()
            ->when($name, function ($query, $name) {
                $search = strtolower(trim($name));
                $query->where('deceased_full_name_lg', 'like', '%'.$search.'%');
            })
            ->when($date, function ($query, $date) {
                $dateFormatted = Carbon::parse($date)->format('Y-m-d');
                $query->whereDate('starts_at',  $dateFormatted);
            })
            ->when(!$name && !$date, function($query) {
                $latestDates = $this->getLatestDates();
                $query->whereIn('starts_at', $latestDates);
            })
            ->orderByDesc('starts_at')
            ->inRandomOrder()
            ->get()
            ->groupBy(function($item, $key) {
                return $item->starts_at->format('d.m.Y.');
            });

        return view('guest.search', ['posts' => $posts, 'name' => $name, 'date' => $date]);
    }

    /**
     * Return latest X starts_at dates from posts table
     * @param int $days
     * @return array
     */
    private function getLatestDates(int $days = 1): array
    {
        return DB::table('posts')
            ->select('starts_at')
            ->distinct()
            ->where('starts_at', '<=', now()->toDateString())
            ->orderBy('starts_at', 'desc')
            ->limit($days)
            ->pluck('starts_at')
            ->toArray();
    }
}
