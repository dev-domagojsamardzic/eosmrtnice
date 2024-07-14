<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomepageController extends Controller
{
    public function home(): View
    {
        // Take last 3 dates
        // Use latest 2 dates for first posts query
        // Use third latest date (if exists) for loadMoreBtn
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

        $nextDateToLoad = Carbon::parse(end($latestDates))->subDay()->format('Y-m-d');

        return view('homepage',[
            'posts' => $posts,
            'nextDateToLoad' => $nextDateToLoad,
        ]);
    }
}
