<?php

namespace App\Http\Controllers;

use App\Models\Deceased;
use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view(auth_user_type() . '.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Deceased $deceased): View
    {
        return $this->form($deceased, new Post, 'create');
    }

    /**
     * Show resource form
     *
     * @param Deceased $deceased
     * @param Post $post
     * @param string $action
     * @return View
     */
    private function form(Deceased $deceased, Post $post, string $action): View
    {
        $route = match($action) {
            'create' => route('user.posts.store',['deceased' => $deceased->id]),
            'edit' => route('user.posts.update', ['id' => $post->id]),
            default => '',
        };

        return view('user.posts.form', [
            'post' => $post,
            'action' => $route,
        ]);
    }
}
