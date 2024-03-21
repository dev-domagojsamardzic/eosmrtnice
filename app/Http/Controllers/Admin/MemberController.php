<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MemberRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MemberController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Member::class);
    }
    /**
     * Display all members
     */
    public function index(): View
    {
        return view('admin.members.index');
    }

    /**
     * Show members edit form
     * @param Member $member
     * @return View
     */
    public function edit(Member $member): View
    {
        return $this->form($member, 'edit');
    }

    /**
     * Update resource
     * @param MemberRequest $memberRequest
     * @param Member $member
     * @return RedirectResponse
     */
    public function update(MemberRequest $memberRequest, Member $member): RedirectResponse
    {
        return $this->apply($member, $memberRequest);
    }

    /**
     * Display resource's form
     * @param Member $member
     * @param string $action
     * @return View
     */
    private function form(Member $member, string $action): View
    {
        $route = match($action) {
            'edit' => route(auth_user_type() . '.members.update', ['member' => $member]),
            'create' => route(auth_user_type() . '.members.store'),
            default => ''
        };

        return view(
            'admin.members.form', [
                'user' => $member,
                'action_name' => $action,
                'action' => $route,
                'quit' => route(auth_user_type() . '.members.index'),
            ]
        );
    }

    /**
     * Apply changes on resource
     * @param Member $member
     * @param MemberRequest $request
     * @return RedirectResponse
     */
    private function apply(Member $member, MemberRequest $request): RedirectResponse
    {
        $member->first_name = $request->input('first_name');
        $member->last_name = $request->input('last_name');
        $member->sex = $request->input('sex');
        $member->email = $request->input('email');
        $member->active = $request->boolean('active');

        try{
            $member->save();
            return redirect()->route('admin.members.index')
                ->with('alert', ['class' => 'success', 'message' => __('common.saved')]);
        }catch (\Exception $e) {
            return redirect()
                ->route('admin.members.index')
                ->with('alert', ['class' => 'danger', 'message' => __('common.something_went_wrong')]);
        }
    }
}
