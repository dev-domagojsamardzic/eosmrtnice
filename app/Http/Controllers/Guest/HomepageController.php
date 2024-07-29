<?php

namespace App\Http\Controllers\Guest;

use Illuminate\View\View;

class HomepageController extends PostController
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

        $loadMoreItemsRoute = route('homepage.items');

        if (count($latestDates) === 0) {
            return view('guest.posts',[
                'posts' => collect([]),
                'nextDateToLoad' => null,
                'loadMoreItemsRoute' => $loadMoreItemsRoute,
            ]);
        }

        $nextDateToLoad = (count($latestDates) === 3) ? array_pop($latestDates) : null;

        // First loading, only show posts from 2 latest dates inserted
        $posts = $this->query($latestDates)
            ->get()
            ->groupBy(function($item, $key) {
                return $item->starts_at->format('d.m.Y.');
            });

        return view('guest.posts',[
            'posts' => $posts,
            'nextDateToLoad' => $nextDateToLoad,
            'loadMoreItemsRoute' => $loadMoreItemsRoute,
        ]);
    }
}
