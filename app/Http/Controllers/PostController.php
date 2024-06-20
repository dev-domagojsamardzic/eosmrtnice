<?php

namespace App\Http\Controllers;

use App\Enums\PostSize;
use App\Enums\PostSymbol;
use App\Enums\PostType;
use App\Http\Requests\PostRequest;
use App\Models\Deceased;
use App\Models\Post;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
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
     * Show the form for editing resource.
     */
    public function edit(Deceased $deceased, Post $post): View
    {
        return $this->form($deceased, $post, 'edit');
    }

    /**
     * Store new resource
     *
     * @param Deceased $deceased
     * @param PostRequest $request
     * @return RedirectResponse
     */
    public function store(Deceased $deceased, PostRequest $request): RedirectResponse
    {
        return $this->apply($deceased, new Post, $request);
    }

    /**
     * Update given resource
     *
     * @param Deceased $deceased
     * @param Post $post
     * @param PostRequest $request
     * @return RedirectResponse
     */
    public function update(Deceased $deceased, Post $post, PostRequest $request): RedirectResponse
    {
        return $this->apply($deceased, $post, $request);
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
            'edit' => route('user.posts.update', ['deceased' => $deceased->id, 'post' => $post->id]),
            default => '',
        };

        $postTypes = PostType::options();
        $postSizes = PostSize::options();
        $postSymbols = PostSymbol::options();

        return view('user.posts.form', [
            'post' => $post,
            'deceased' => $deceased,
            'types' => $postTypes,
            'sizes' => $postSizes,
            'symbols' => $postSymbols,
            'action' => $route,
        ]);
    }

    /**
     * Apply changes to the resource
     * @param Deceased $deceased
     * @param Post $post
     * @param PostRequest $request
     * @return RedirectResponse
     */
    private function apply(Deceased $deceased, Post $post, PostRequest $request): RedirectResponse
    {
        $post->user()->associate(auth()->user());
        $post->deceased()->associate($deceased);
        $post->type = $request->input('type');
        $post->size = $request->input('size');
        $post->starts_at = Carbon::parse($request->input('starts_at'))->format('Y-m-d');
        // TODO: post lasts for 2 weeks, change that
        $post->ends_at = Carbon::parse($request->input('ends_at'))->addWeeks(2)->format('Y-m-d');
        $post->is_framed = $request->boolean('is_framed');
        $post->image = $deceased->image;
        $post->symbol = $request->input('symbol') ?? '';
        $post->deceased_full_name_lg = $request->input('deceased_full_name_lg') ?? $deceased->full_name;
        $post->deceased_full_name_sm = $request->input('deceased_full_name_sm');
        $post->lifespan = $request->input('lifespan');
        $post->intro_message = trim($request->input('intro_message'), " \r\n\t");
        $post->main_message = trim($request->input('main_message'), " \r\n\t");
        $post->signature = trim($request->input('signature'), " \r\n\t");

        try {
            $post->save();
            return redirect()->route('user.posts.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        } catch(Exception $e) {
            return redirect()->route('user.posts.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
