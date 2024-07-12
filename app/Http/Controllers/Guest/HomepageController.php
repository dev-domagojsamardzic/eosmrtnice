<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class HomepageController extends Controller
{
    public function home(): View
    {
        $posts = Post::query()
            ->orderBy('starts_at')
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($item, $key) {
                return $item->starts_at->format('d.m.Y.');
            });

        return view('homepage',[
            'posts' => $posts
        ]);
    }
}
