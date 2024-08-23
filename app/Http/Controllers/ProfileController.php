<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->all());
//TODO: remove comments and also make the logical part in seperate service class
        // Handle the image upload if a new image is provided
        if ($request->hasFile('image')) {

            // Store the new image and get the file name
            $path = $request->file('image')->store('profile_images', 'public');
            $filename = basename($path);

            // Delete the old image if it exists
            if ($user->image) {
                Storage::disk('public')->delete('profile_images/' . $user->image);
            }

            // Update the user's image with just the filename
            $user->image = $filename;
        }
        // Fill the user's other fields with validated data





        // Check if the email was updated; if so, reset email verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }



        // Save the user with the updated data
        $user->save();

        // Redirect back to the profile edit page with a success message
        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully!');
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
