<?php

namespace App\Http\Controllers\User;

use App\Enums\PostSize;
use App\Enums\PostSymbol;
use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Member;
use App\Models\Post;
use App\Models\User;
use App\Services\ImageService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class PostController extends Controller
{

    public function __construct(protected ImageService $imageService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('index', [
            'title' => __('models/post.post'),
            'table' => livewire_table_name('posts-table')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return $this->form(new Post, 'create');
    }

    /**
     * Show the form for editing resource.
     */
    public function edit(Post $post): View
    {
        return $this->form($post, 'edit');
    }

    /**
     * Store new resource
     *
     * @param PostRequest $request
     * @return RedirectResponse
     */
    public function store(PostRequest $request): RedirectResponse
    {
        return $this->apply(new Post, $request);
    }

    /**
     * Update given resource
     *
     * @param Post $post
     * @param PostRequest $request
     * @return RedirectResponse
     */
    public function update(Post $post, PostRequest $request): RedirectResponse
    {
        return $this->apply($post, $request);
    }

    /**
     * Show resource form
     *
     * @param Post $post
     * @param string $action
     * @return View
     */
    private function form(Post $post, string $action): View
    {
        $route = match($action) {
            'create' => route(auth_user_type() . '.posts.store'),
            'edit' => route(auth_user_type() . '.posts.update', ['post' => $post->id]),
            default => '',
        };

        $postTypes = PostType::options();
        $postSizes = PostSize::options();
        $postSymbols = PostSymbol::options();

        $me = admin();
        $me->data = "$me->last_name $me->first_name ($me->email)";

        $postOwners = Member::query()
            ->where('active', true)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->select(['id', 'first_name', 'last_name', 'email'])
            ->get()
            ->each(function($item) {
                return $item->data = "$item->last_name $item->first_name ($item->email)";
            })
            ->prepend($me)
            ->pluck('data', 'id')->toArray();

        return view('user.posts.form', [
            'post' => $post,
            'types' => $postTypes,
            'sizes' => $postSizes,
            'symbols' => $postSymbols,
            'postOwners' => $postOwners,
            'action' => $route,
        ]);
    }

    /**
     * Apply changes to the resource
     * @param Post $post
     * @param PostRequest $request
     * @return RedirectResponse
     */
    private function apply(Post $post, PostRequest $request): RedirectResponse
    {
        $deceasedImage = $this->imageService->storePostImage($request, $post);
        $post->image = $deceasedImage;

        $post->user()->associate(auth()->user());

        if (is_admin()) {
            $post->user()->associate($request->input('user_id'));
        }

        $post->type = $request->input('type');
        $post->size = $request->input('size');

        $startDate = Carbon::parse($request->input('starts_at'));
        $postDurationInDays = (int)config('eosmrtnice.post_duration_days');
        $endDate = $startDate->clone()->addDays($postDurationInDays);
        $post->starts_at = $startDate->format('Y-m-d');
        $post->ends_at = $endDate->format('Y-m-d');

        $post->is_framed = $request->boolean('is_framed');
        $post->symbol = $request->input('symbol') ?? PostSymbol::NONE;
        $post->deceased_full_name_lg = $request->input('deceased_full_name_lg');
        $post->deceased_full_name_sm = $request->input('deceased_full_name_sm');
        $post->lifespan = $request->input('lifespan');
        $post->intro_message = trim($request->input('intro_message'), " \r\n\t");
        $post->main_message = trim($request->input('main_message'), " \r\n\t");
        $post->signature = trim($request->input('signature'), " \r\n\t");

        try {
            $post->save();
            return redirect()->route(auth_user_type() . '.posts.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        } catch(Exception $e) {
            return redirect()->route(auth_user_type() . '.posts.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
