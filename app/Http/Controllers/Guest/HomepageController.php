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
        // First loading, only show posts from 2 latest dates inserted
        $latestDates = DB::table('posts')
            ->select('starts_at')
            ->distinct()
            ->orderBy('starts_at', 'desc')
            ->limit(2)
            ->pluck('starts_at')
            ->toArray();

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
