@extends('layouts.app')

@section('content')
<!-- Bonus Feature: AI Job Recommendations -->
@if(auth()->check() && auth()->user()->isCandidate() && $recommendedJobs->count() > 0)
    <div class="mb-8 p-6 bg-gradient-to-r from-indigo-950/60 to-slate-950 border border-indigo-800/40 rounded-2xl">
        <h2 class="text-lg font-bold text-indigo-400 mb-1">Recommended Jobs For You</h2>
        <p class="text-xs text-slate-400 mb-4">Matched based on your profile skills: <strong>{{ auth()->user()->skills }}</strong></p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($recommendedJobs as $rec)
                <div class="bg-slate-900 p-4 rounded-xl border border-indigo-500/20">
                    <h3 class="font-bold text-white text-sm">{{ $rec->title }}</h3>
                    <p class="text-xs text-slate-400 mt-1">{{ $rec->category }} &bull; ${{ number_format($rec->salary) }}</p>
                    <a href="{{ route('jobs.show', $rec) }}" class="inline-block mt-3 text-xs bg-indigo-600 text-white px-3 py-1 rounded">View Position</a>
                </div>
            @endforeach
        </div>
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-white">Available Job Openings</h1>
    <form action="{{ route('jobs.index') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs/skills..." class="bg-slate-950 border border-slate-800 text-xs px-3 py-2 rounded-lg text-white">
        <button type="submit" class="bg-indigo-600 text-xs font-semibold px-4 py-2 rounded-lg text-white">Search</button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($jobs as $job)
        <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex flex-col justify-between">
            <div>
                <div class="flex justify-between text-xs text-indigo-400 font-semibold mb-2">
                    <span>{{ $job->category }}</span>
                    <span>{{ $job->work_type }}</span>
                </div>
                <h2 class="text-lg font-bold text-white mb-2">{{ $job->title }}</h2>
                <h3>Location: {{ $job->location }}</h3>
            </div>
            
            <div class="border-t border-slate-900 pt-4 flex justify-between items-center">
                <span class="text-sm font-bold text-emerald-400">{{ number_format($job->salary) }} EGP</span>
                <a href="{{ route('jobs.show', $job) }}" class="text-xs bg-slate-800 hover:bg-slate-700 px-3 py-1.5 rounded text-white font-medium">Details &rarr;</a>
            </div>
        </div>
    @empty
        <p class="text-slate-500 text-sm">No available jobs found.</p>
    @endforelse
</div>

<div class="mt-6">{{ $jobs->links() }}</div>
@endsection