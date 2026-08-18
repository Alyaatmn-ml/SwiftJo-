@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-slate-950 border border-slate-800 p-8 rounded-2xl shadow-xl mt-6">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-xl font-bold text-white">Admin: Edit Job Opening</h1>
            <p class="text-xs text-slate-400 mt-1">Update job listing details and requirements.</p>
        </div>
        <a href="{{ route('jobs.show', $job) }}" class="text-xs text-slate-400 hover:text-white transition-colors">
            ← Cancel
        </a>
    </div>

    <form action="{{ route('jobs.update', $job) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Job Title -->
        <div>
            <label class="block text-xs text-slate-400 mb-1">Job Title</label>
            <input type="text" name="title" value="{{ old('title', $job->title) }}" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded-lg text-white focus:outline-none focus:border-indigo-500" required>
            @error('title') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Category & Work Type -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs text-slate-400 mb-1">Category</label>
                <input type="text" name="category" value="{{ old('category', $job->category) }}" placeholder="Programming, Marketing..." class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded-lg text-white focus:outline-none focus:border-indigo-500" required>
                @error('category') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs text-slate-400 mb-1">Work Type</label>
                <select name="work_type" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded-lg text-white focus:outline-none focus:border-indigo-500">
                    <option value="Remote" {{ old('work_type', $job->work_type) == 'Remote' ? 'selected' : '' }}>Remote</option>
                    <option value="On-site" {{ old('work_type', $job->work_type) == 'On-site' ? 'selected' : '' }}>On-site</option>
                    <option value="Hybrid" {{ old('work_type', $job->work_type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                </select>
                @error('work_type') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Location & Salary -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs text-slate-400 mb-1">Location</label>
                <input type="text" name="location" value="{{ old('location', $job->location) }}" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded-lg text-white focus:outline-none focus:border-indigo-500" required>
                @error('location') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs text-slate-400 mb-1">Salary (EGP)</label>
                <input type="number" name="salary" value="{{ old('salary', $job->salary) }}" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded-lg text-white focus:outline-none focus:border-indigo-500" required>
                @error('salary') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Required Skills -->
        <div>
            <label class="block text-xs text-slate-400 mb-1">Required Skills</label>
            <input type="text" name="required_skills" value="{{ old('required_skills', $job->required_skills) }}" placeholder="PHP, Laravel, MySQL" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded-lg text-white focus:outline-none focus:border-indigo-500" required>
            @error('required_skills') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Application Deadline -->
        <div>
            <label class="block text-xs text-slate-400 mb-1">Application Deadline</label>
            <input type="date" name="deadline" value="{{ old('deadline', \Carbon\Carbon::parse($job->deadline)->format('Y-m-d')) }}" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded-lg text-white focus:outline-none focus:border-indigo-500" required>
            @error('deadline') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Job Description -->
        <div>
            <label class="block text-xs text-slate-400 mb-1">Job Description</label>
            <textarea name="description" rows="4" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded-lg text-white focus:outline-none focus:border-indigo-500" required>{{ old('description', $job->description) }}</textarea>
            @error('description') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold px-6 py-2.5 rounded-lg transition-colors">
                Update Job Listing
            </button>
            <a href="{{ route('jobs.show', $job) }}" class="bg-slate-900 hover:bg-slate-800 text-slate-300 text-xs font-semibold px-5 py-2.5 rounded-lg transition-colors border border-slate-800">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection