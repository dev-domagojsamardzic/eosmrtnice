<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class PostController extends Controller
{
    private function query(): Builder
    {
        return Post::query();
    }

    public function deathNotices(): View
    {
        return view('guest.posts', [
            'title' => __('models/posts.death_notices'),
        ]);
    }
}
