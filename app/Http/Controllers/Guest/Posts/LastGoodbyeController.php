<?php

namespace App\Http\Controllers\Guest\Posts;

use App\Enums\PostType;
use App\Http\Controllers\Guest\PostController;
use Illuminate\View\View;

class LastGoodbyeController extends PostController
{
    /**
     * Return index view
     * @return View
     */
    public function index(): View
    {
        $latestDates = $this->getLatestDates(3);

        if (count($latestDates) === 0) {
            return view('guest.posts',[
                'posts' => collect([]),
                'nextDateToLoad' => null,
            ]);
        }

        $nextDateToLoad = (count($latestDates) === 3) ? array_pop($latestDates) : null;

        $posts = $this->query($latestDates)
            ->get()
            ->groupBy(function($item, $key) {
                return $item->starts_at->format('d.m.Y.');
            });

        return view('guest.posts', [
            'posts' => $posts,
            'nextDateToLoad' => $nextDateToLoad,
            'loadMoreItemsRoute' => route('guest.last-goodbyes.items'),
        ]);
    }

    protected function getPostType(): ?PostType
    {
        return PostType::LAST_GOODBYE;
    }
}
