@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-slate-950 border border-slate-800 p-8 rounded-2xl">
    <h1 class="text-xl font-bold text-white mb-6">Admin: Create New Job Opening</h1>

    <form action="{{ route('jobs.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs text-slate-400 mb-1">Job Title</label>
            <input type="text" name="title" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded text-white" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs text-slate-400 mb-1">Category</label>
                <input type="text" name="category" placeholder="Programming, Marketing..." class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded text-white" required>
            </div>
            <div>
                <label class="block text-xs text-slate-400 mb-1">Work Type</label>
                <select name="work_type" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded text-white">
                    <option value="Remote">Remote</option>
                    <option value="On-site">On-site</option>
                    <option value="Hybrid">Hybrid</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs text-slate-400 mb-1">Location</label>
                <input type="text" name="location" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded text-white" required>
            </div>
            <div>
                <label class="block text-xs text-slate-400 mb-1">Salary (EGP)</label>
                <input type="number" name="salary" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded text-white" required>
            </div>
        </div>

        <div>
            <label class="block text-xs text-slate-400 mb-1">Required Skills</label>
            <input type="text" name="required_skills" placeholder="PHP, Laravel, MySQL" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded text-white" required>
        </div>

        <div>
            <label class="block text-xs text-slate-400 mb-1">Application Deadline</label>
            <input type="date" name="deadline" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded text-white" required>
        </div>

        <div>
            <label class="block text-xs text-slate-400 mb-1">Job Description</label>
            <textarea name="description" rows="4" class="w-full bg-slate-900 border border-slate-800 text-xs p-2.5 rounded text-white" required></textarea>
        </div>

        <button type="submit" class="bg-emerald-600 text-white text-xs font-bold px-6 py-2.5 rounded-lg">Publish Listing</button>
    </form>
</div>
@endsection