<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => auth()->user(),
            'genders' => Gender::options(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->gender = $request->input('gender');
        $user->email = $request->input('email');

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $user->sendEmailVerificationNotification();

        $message = ($user->isDirty('email')) ? __('auth.new_verification_link_sent') : __('common.updated');

        return redirect()->route(auth_user_type() . '.profile.edit')
            ->with('alert', ['class' => 'success', 'message' => $message]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
