<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'age'                 => 'nullable|integer|min:16|max:100',
            'job_title'           => 'nullable|string|max:255',
            'phone_number'        => 'nullable|string|max:50',
            'skills'              => 'nullable|string',
            'profile_description' => 'nullable|string',
            'profile_image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'resume'              => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        // Handle Profile Image Upload
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Handle Resume / CV Upload
        if ($request->hasFile('resume')) {
            if ($user->resume) {
                Storage::disk('public')->delete($user->resume);
            }
            $validated['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}