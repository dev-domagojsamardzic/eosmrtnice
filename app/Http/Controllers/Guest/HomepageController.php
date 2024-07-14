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
        // TODO: datumi ne smiju biti stariji od danas
        $latestDates = DB::table('posts')
            ->select('starts_at')
            ->distinct()
            ->orderBy('starts_at', 'desc')
            ->limit(3)
            ->pluck('starts_at')
            ->toArray();

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

        return response()->json(['content' => $html, 'date' => '2024-07-14']);
    }
}
