@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <h1 class="text-2xl font-bold text-white">My Application Tracker</h1>

    <div class="space-y-4">
        @forelse($applications as $application)
            <div class="bg-slate-950 border border-slate-800 rounded-2xl p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-white">{{ $application->job->title }}</h3>
                    <p class="text-xs text-slate-400">{{ $application->job->company_name }} &bull; Submitted {{ $application->created_at->format('M d, Y') }}</p>
                    <div class="mt-3">
                        <a href="{{ route('applications.resume', $application) }}" class="text-xs text-indigo-400 hover:underline">View Submitted Resume PDF</a>
                    </div>
                </div>

                <div class="text-right">
                    <span class="text-xs font-bold uppercase px-3 py-1 rounded-full inline-block
                        @if($application->status === 'hired') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                        @elseif($application->status === 'shortlisted') bg-indigo-500/20 text-indigo-400 border border-indigo-500/30
                        @elseif($application->status === 'rejected') bg-rose-500/20 text-rose-400 border border-rose-500/30
                        @else bg-amber-500/20 text-amber-400 border border-amber-500/30 @endif">
                        {{ $application->status }}
                    </span>
                    <a href="{{ route('jobs.show', $application->job) }}" class="block text-xs text-slate-500 hover:text-slate-300 mt-2">View Job Posting &rarr;</a>
                </div>
            </div>
        @empty
            <div class="bg-slate-950 border border-slate-800 rounded-2xl p-12 text-center text-slate-400 text-sm">
                You haven't submitted any job applications yet. <a href="{{ route('jobs.index') }}" class="text-indigo-400 underline">Explore open roles</a>.
            </div>
        @endforelse
    </div>
</div>
@endsection