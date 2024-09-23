<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostProductRequest;
use App\Models\PostProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Features\SupportRedirects\Redirector;

class PostProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('index', [
            'title' => __('admin.post_products'),
            'table' => livewire_table_name('post-products-table'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return $this->form(new PostProduct, 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostProductRequest $request): RedirectResponse
    {
        return $this->apply(new PostProduct, $request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostProduct $postProduct): View
    {
        return $this->form($postProduct, 'edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostProductRequest $request, PostProduct $postProduct): RedirectResponse
    {
        return $this->apply($postProduct, $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostProduct $postProduct): RedirectResponse|Redirector
    {
        try {
            $postProduct->delete();
            return redirect()->route(auth_user_type().'.post-products.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.deleted')]);
        } catch (\Exception $e) {
            return redirect()->route(auth_user_type().'.post-products.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }

    /**
     * Display create/edit resource form
     * @param PostProduct $postProduct
     * @param string $action
     * @return View
     */
    protected function form(PostProduct $postProduct, string $action): View
    {
        $route = match($action) {
            'edit' => route(auth_user_type() . '.post-products.update', ['post_product' => $postProduct]),
            'create' => route(auth_user_type() . '.post-products.store'),
            default => ''
        };

        return view('admin.post-products.form', [
            'product' => $postProduct,
            'action_name' => $action,
            'action' => $route,
            'quit' => route(auth_user_type() . '.post-products.index'),
        ]);
    }

    /**
     * Apply changes on resource
     * @param PostProduct $postProduct
     * @param PostProductRequest $request
     * @return RedirectResponse
     */
    protected function apply(PostProduct $postProduct, PostProductRequest $request): RedirectResponse
    {
        $postProduct->title = $request->input('title');
        $postProduct->price = $request->input('price');

        try{
            $postProduct->save();
            return redirect()->route(auth_user_type() . '.post-products.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        }catch (\Exception $e) {
            return redirect()
                ->route(auth_user_type() . '.post-products.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
