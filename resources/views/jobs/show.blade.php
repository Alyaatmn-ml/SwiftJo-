@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-slate-950 border border-slate-800 p-8 rounded-2xl shadow-xl mt-6">
    
    <!-- Top Action Nav -->
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800">
        <a href="{{ route('jobs.index') }}" class="text-xs text-slate-400 hover:text-white transition-colors">
            ← Back to Job Listings
        </a>

        @if(auth()->check() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin())
            <div class="flex items-center gap-2">
                <a href="{{ route('jobs.edit', $job) }}" class="bg-slate-800 hover:bg-slate-700 text-white text-xs px-3 py-1.5 rounded-lg border border-slate-700 transition-colors">
                    Edit
                </a>
                <form action="{{ route('jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-rose-950 hover:bg-rose-900 text-rose-300 text-xs px-3 py-1.5 rounded-lg border border-rose-800 transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Job Title & Basic Info -->
    <div class="space-y-2 mb-6">
        <h1 class="text-2xl font-bold text-white">{{ $job->title }}</h1>
        <div class="text-xs text-slate-400 space-y-1">
            <p><span class="text-slate-500">Location:</span> {{ $job->location }}</p>
            <p><span class="text-slate-500">Salary:</span> {{ number_format($job->salary) }} EGP</p>
        </div>
    </div>

    <!-- Job Details List (Stacked Vertically) -->
    <div class="space-y-4 p-5 bg-slate-900/60 border border-slate-800 rounded-xl mb-6 text-xs">
        <div class="pb-3 border-b border-slate-800/80">
            <span class="text-slate-500 block text-[11px] font-semibold uppercase tracking-wider mb-1">Category</span>
            <span class="text-slate-200 font-medium text-sm">{{ $job->category }}</span>
        </div>

        <div class="pb-3 border-b border-slate-800/80">
            <span class="text-slate-500 block text-[11px] font-semibold uppercase tracking-wider mb-1">Work Type</span>
            <span class="text-slate-200 font-medium text-sm">{{ $job->work_type }}</span>
        </div>

        <div class="pb-3 border-b border-slate-800/80">
            <span class="text-slate-500 block text-[11px] font-semibold uppercase tracking-wider mb-1">Required Skills</span>
            <span class="text-slate-200 font-medium text-sm leading-relaxed block">{{ $job->required_skills }}</span>
        </div>

        <div>
            <span class="text-slate-500 block text-[11px] font-semibold uppercase tracking-wider mb-1">Application Deadline</span>
            <span class="text-slate-200 font-medium text-sm">{{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</span>
        </div>
    </div>

    <!-- Description (Supports Newlines and Bullet Points) -->
    <div class="space-y-2 mb-8">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Job Description</h3>
        <div class="text-xs text-slate-300 bg-slate-900/40 p-5 rounded-xl border border-slate-800/80 leading-relaxed whitespace-pre-line font-normal">
            {{ $job->description }}
        </div>
    </div>

    <!-- Application Button Handler -->
    <div class="pt-4 border-t border-slate-800">
        @if(auth()->check() && method_exists(auth()->user(), 'isCandidate') && auth()->user()->isCandidate())
            @php
                $hasApplied = auth()->user()->applications()->where('job_id', $job->id)->exists();
            @endphp

            @if($hasApplied)
                <div class="flex items-center justify-between bg-slate-900 p-3 rounded-xl border border-slate-800">
                    <span class="text-xs text-emerald-400 font-semibold">Application Submitted</span>
                    <form action="{{ route('applications.destroy', $job) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-rose-950 hover:bg-rose-900 text-rose-300 text-xs px-4 py-2 rounded-lg border border-rose-800 transition-colors font-medium">
                            Cancel Application
                        </button>
                    </form>
                </div>
            @else
                <form action="{{ route('applications.store', $job) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs py-3 rounded-xl transition-colors">
                        Submit Application
                    </button>
                </form>
            @endif
        @elseif(!auth()->check())
            <a href="{{ route('login') }}" class="block text-center w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs py-3 rounded-xl transition-colors">
                Log In to Apply
            </a>
        @endif
    </div>

</div>
@endsection