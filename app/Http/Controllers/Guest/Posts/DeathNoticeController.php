<?php

namespace App\Http\Controllers\Guest\Posts;

use App\Enums\PostType;
use App\Http\Controllers\Guest\PostController;
use Illuminate\View\View;

class DeathNoticeController extends PostController
{
    /**
     * Return index view
     * @return View
     */
    public function index(): View
    {
        $latestDates = $this->getLatestDates(3);
        $loadMoreItemsRoute = route('guest.death-notices.items');

        if (count($latestDates) === 0) {
            return view('guest.posts',[
                'pageTitle' => __('guest.death_notices'),
                'canSearchByCounty' => true,
                'posts' => collect([]),
                'nextDateToLoad' => null,
                'loadMoreItemsRoute' => $loadMoreItemsRoute,
            ]);
        }

        $nextDateToLoad = (count($latestDates) === 3) ? array_pop($latestDates) : null;

        $posts = $this->query($latestDates)
            ->get()
            ->groupBy(function($item, $key) {
                return $item->starts_at->format('d.m.Y.');
            });

        return view('guest.posts', [
            'pageTitle' => __('guest.death_notices'),
            'canSearchByCounty' => true,
            'posts' => $posts,
            'nextDateToLoad' => $nextDateToLoad,
            'loadMoreItemsRoute' => route('guest.death-notices.items'),
        ]);
    }

    protected function getPostType(): ?PostType
    {
        return PostType::DEATH_NOTICE;
    }
}
