<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BasicUserRequest;
use App\Models\BasicUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(BasicUser::class);
    }
    /**
     * Display all users
     */
    public function index(): View
    {
        return view('admin.users.index');
    }

    /**
     * Show users edit form
     * @param BasicUser $user
     * @return View
     */
    public function edit(BasicUser $user): View
    {
        return $this->form($user, 'edit');
    }

    /**
     * Update resource
     * @param BasicUser $user
     * @param BasicUserRequest $request
     * @return RedirectResponse
     */
    public function update(BasicUser $user, BasicUserRequest $request): RedirectResponse
    {
        return $this->apply($user, $request);
    }

    /**
     * Display resource's form
     * @param BasicUser $user
     * @param string $action
     * @return View
     */
    private function form(BasicUser $user, string $action): View
    {
        $route = match($action) {
            'edit' => route(auth_user_type() . '.users.update', ['user' => $user]),
            'create' => route(auth_user_type() . '.users.store'),
            default => ''
        };

        return view(
            'admin.users.form', [
                'user' => $user,
                'action_name' => $action,
                'action' => $route,
                'quit' => route(auth_user_type() . '.users.index'),
            ]
        );
    }

    /**
     * Apply changes on resource
     * @param BasicUser $user
     * @param BasicUserRequest $request
     * @return RedirectResponse
     */
    private function apply(BasicUser $user, BasicUserRequest $request): RedirectResponse
    {
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->sex = $request->input('sex');
        $user->email = $request->input('email');
        $user->active = $request->boolean('active');
        $user->save();

        return redirect()->route('admin.users.index');
    }
}
