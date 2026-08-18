@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('jobs.show', $job) }}" class="text-xs text-indigo-400 hover:underline">&larr; Back to Job Details</a>
            <h1 class="text-2xl font-bold text-white mt-1">Applicants for "{{ $job->title }}"</h1>
        </div>
        <span class="text-xs bg-slate-800 text-slate-300 font-semibold px-3 py-1.5 rounded-lg border border-slate-700">Total Received: {{ $applications->count() }}</span>
    </div>

    <div class="space-y-4">
        @forelse($applications as $application)
            <div class="bg-slate-950 border border-slate-800 rounded-2xl p-6 flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div class="space-y-2 flex-1">
                    <div class="flex items-center gap-3">
                        <h3 class="text-lg font-bold text-white">{{ $application->user->name }}</h3>
                        <span class="text-xs px-2.5 py-0.5 rounded-full font-bold uppercase
                            @if($application->status === 'hired') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                            @elseif($application->status === 'shortlisted') bg-indigo-500/20 text-indigo-400 border border-indigo-500/30
                            @elseif($application->status === 'rejected') bg-rose-500/20 text-rose-400 border border-rose-500/30
                            @else bg-amber-500/20 text-amber-400 border border-amber-500/30 @endif">
                            {{ $application->status }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-400">Email: {{ $application->user->email }} &bull; Applied: {{ $application->created_at->format('M d, Y') }}</p>

                    <div class="bg-slate-900 border border-slate-800/80 rounded-xl p-4 text-xs text-slate-300 leading-relaxed mt-2">
                        <strong class="text-slate-400 block mb-1">Cover Letter:</strong>
                        {{ $application->cover_letter }}
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('applications.resume', $application) }}" class="inline-flex items-center gap-1.5 text-xs bg-slate-800 hover:bg-slate-700 text-slate-200 px-3 py-1.5 rounded-lg transition font-medium border border-slate-700">
                            📄 Download PDF Resume
                        </a>
                    </div>
                </div>

                <!-- Status Controls -->
                <div class="bg-slate-900 border border-slate-800 p-4 rounded-xl shrink-0 w-full md:w-56">
                    <label class="block text-xs font-semibold text-slate-400 mb-2">Update Application Status</label>
                    <form action="{{ route('applications.updateStatus', $application) }}" method="POST" class="space-y-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-2.5 py-1.5 text-slate-200 text-xs focus:outline-none focus:border-indigo-500">
                            <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                            <option value="hired" {{ $application->status === 'hired' ? 'selected' : '' }}>Hired</option>
                            <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs py-1.5 rounded-lg transition">Save Status</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-slate-950 border border-slate-800 rounded-2xl p-12 text-center text-slate-400 text-sm">
                No candidate applications submitted yet.
            </div>
        @endforelse
    </div>
</div>
@endsection