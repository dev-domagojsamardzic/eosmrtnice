<?php

namespace App\Http\Controllers\Guest\Posts;

use App\Enums\PostType;
use App\Http\Controllers\Guest\PostController;
use Illuminate\View\View;

class ThankYouController extends PostController
{
    /**
     * Return index view
     * @return View
     */
    public function index(): View
    {
        $latestDates = $this->getLatestDates(3);
        $loadMoreItemsRoute = route('guest.thank-yous.items');

        if (count($latestDates) === 0) {
            return view('guest.posts',[
                'pageTitle' => __('guest.thank_yous'),
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
            'pageTitle' => __('guest.thank_yous'),
            'posts' => $posts,
            'nextDateToLoad' => $nextDateToLoad,
            'loadMoreItemsRoute' => $loadMoreItemsRoute,
        ]);
    }

    protected function getPostType(): ?PostType
    {
        return PostType::THANK_YOU;
    }
}
