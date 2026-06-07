<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show profile page
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update profile information + photo
     */
//     public function update(ProfileUpdateRequest $request): RedirectResponse
// {   
    
//     $user = $request->user();

//     // update basic info
//     $user->fill($request->validated());

//     // handle profile photo upload
//     if ($request->hasFile('profile_photo')) {

//         // delete old image if exists
//         if ($user->profile_photo) {
//             Storage::disk('public')->delete($user->profile_photo);
//         }

//         // store new image
//         $path = $request->file('profile_photo')
//             ->store('profile_photos', 'public');

//         $user->profile_photo = $path;
//     }

//     $user->save();

//     return redirect()->route('profile.edit')
//         ->with('status', 'profile-updated');
// }
public function update(Request $request): RedirectResponse
{
    $user = $request->user();

    $user->fill($request->only(['name', 'email', 'department']));

    if ($request->hasFile('profile_photo')) {

        $path = $request->file('profile_photo')
            ->store('profile_photos', 'public');

        $user->profile_photo = $path;
    }

    $user->save();

    return redirect()->route('profile.edit')
        ->with('status', 'profile-updated');
}

    /**
     * Delete account
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // DELETE PROFILE PHOTO TOO
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}