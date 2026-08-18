@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-slate-950 border border-slate-800 p-8 rounded-2xl shadow-xl mt-6">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Edit Profile</h1>
            <p class="text-xs text-slate-400 mt-1">Update your candidate information, skills, avatar, and resume CV.</p>
        </div>
        
        <!-- Current Avatar Preview -->
        <div class="flex-shrink-0">
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500 shadow-lg">
            @else
                <div class="w-16 h-16 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-indigo-400 font-bold text-xl">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-950/80 border border-emerald-800 text-emerald-300 rounded-xl text-xs">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Full Name -->
            <div>
                <label class="block text-xs text-slate-400 mb-1">Full Name *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-slate-900 border border-slate-800 text-xs p-3 rounded-lg text-white focus:outline-none focus:border-indigo-500" required>
                @error('name') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email (Read Only) -->
            <div>
                <label class="block text-xs text-slate-400 mb-1">Email Address (Unique)</label>
                <input type="email" value="{{ $user->email }}" class="w-full bg-slate-900/50 border border-slate-800 text-xs p-3 rounded-lg text-slate-500 cursor-not-allowed" disabled>
            </div>

            <!-- Job Title -->
            <div>
                <label class="block text-xs text-slate-400 mb-1">Current Job Title</label>
                <input type="text" name="job_title" value="{{ old('job_title', $user->job_title) }}" placeholder="e.g. Full-Stack Developer" class="w-full bg-slate-900 border border-slate-800 text-xs p-3 rounded-lg text-white focus:outline-none focus:border-indigo-500">
                @error('job_title') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Phone Number -->
            <div>
                <label class="block text-xs text-slate-400 mb-1">Phone Number</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="+1234567890" class="w-full bg-slate-900 border border-slate-800 text-xs p-3 rounded-lg text-white focus:outline-none focus:border-indigo-500">
                @error('phone_number') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Age -->
            <div>
                <label class="block text-xs text-slate-400 mb-1">Age</label>
                <input type="number" name="age" value="{{ old('age', $user->age) }}" placeholder="22" class="w-full bg-slate-900 border border-slate-800 text-xs p-3 rounded-lg text-white focus:outline-none focus:border-indigo-500">
                @error('age') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Skills -->
            <div>
                <label class="block text-xs text-slate-400 mb-1">Skills (Comma-Separated for AI Matching)</label>
                <input type="text" name="skills" value="{{ old('skills', $user->skills) }}" placeholder="PHP, Laravel, JavaScript, MySQL" class="w-full bg-slate-900 border border-slate-800 text-xs p-3 rounded-lg text-white focus:outline-none focus:border-indigo-500">
                @error('skills') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Profile Description -->
        <div>
            <label class="block text-xs text-slate-400 mb-1">Profile Description / Bio</label>
            <textarea name="profile_description" rows="3" placeholder="Brief overview of your experience and career goals..." class="w-full bg-slate-900 border border-slate-800 text-xs p-3 rounded-lg text-white focus:outline-none focus:border-indigo-500">{{ old('profile_description', $user->profile_description) }}</textarea>
            @error('profile_description') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- File Upload Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-800">
            <!-- Profile Image Upload -->
            <div>
                <label class="block text-xs text-slate-400 mb-1">Upload Profile Picture (JPEG, PNG, WEBP)</label>
                <input type="file" name="profile_image" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded-lg text-slate-300 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
                @error('profile_image') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Resume CV Upload -->
            <div>
                <label class="block text-xs text-slate-400 mb-1">Upload Resume CV (PDF, DOC, DOCX)</label>
                <input type="file" name="resume" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded-lg text-slate-300 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-500 cursor-pointer">
                @error('resume') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror

                @if($user->resume)
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-[11px] text-slate-400">Current Resume:</span>
                        <a href="{{ asset('storage/' . $user->resume) }}" target="_blank" class="text-xs text-emerald-400 hover:underline inline-flex items-center gap-1 font-semibold">
                            View / Download CV
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs py-3 rounded-lg transition-colors">Save Profile Changes</button>
    </form>
</div>
@endsection