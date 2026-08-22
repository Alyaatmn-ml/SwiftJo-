@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-6">
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Registered Candidates</h1>
            <p class="text-xs text-slate-400 mt-1">Overview of all candidate profiles, skills, and uploaded resumes.</p>
        </div>
        <span class="bg-indigo-950 text-indigo-400 border border-indigo-800 text-xs px-3 py-1.5 rounded-xl font-bold">
            Total Candidates: {{ $candidates->count() }}
        </span>
    </div>

    @if($candidates->isEmpty())
        <div class="bg-slate-950 border border-slate-800 p-8 rounded-2xl text-center text-slate-400 text-xs">
            No candidates have registered on the platform yet.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($candidates as $candidate)
                <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between space-y-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                @if($candidate->profile_image)
                                    <img src="{{ asset('storage/' . $candidate->profile_image) }}" alt="{{ $candidate->name }}" class="w-14 h-14 rounded-full object-cover border-2 border-indigo-500 shadow-md">
                                @else
                                    <div class="w-14 h-14 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-indigo-400 font-bold text-lg">
                                        {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div>
                                <h3 class="font-bold text-white text-base">{{ $candidate->name }}</h3>
                                <p class="text-xs text-indigo-400 font-medium">{{ $candidate->job_title ?? 'Candidate' }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $candidate->email }} @if($candidate->phone_number) • {{ $candidate->phone_number }} @endif</p>
                            </div>
                        </div>

                        @if($candidate->age)
                            <span class="text-[11px] bg-slate-900 border border-slate-800 px-2.5 py-1 rounded-lg text-slate-400">
                                {{ $candidate->age }} yrs old
                            </span>
                        @endif
                    </div>

                    @if($candidate->profile_description)
                        <p class="text-xs text-slate-300 bg-slate-900/60 p-3 rounded-xl border border-slate-800/80 leading-relaxed">
                            {{ $candidate->profile_description }}
                        </p>
                    @endif

                    <div>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block mb-1.5 font-bold">Skills</span>
                        @if($candidate->skills)
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(explode(',', $candidate->skills) as $skill)
                                    <span class="bg-slate-900 text-indigo-300 text-[11px] px-2.5 py-1 rounded-lg border border-slate-800">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-xs text-slate-500 italic">No skills listed yet.</span>
                        @endif
                    </div>

                    <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">
                            Joined: {{ $candidate->created_at->format('M d, Y') }}
                        </span>

                        @if($candidate->resume)
                            <a href="{{ asset('storage/' . $candidate->resume) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs px-3.5 py-2 rounded-xl font-semibold transition-colors flex items-center gap-1.5">
                                <span>View CV</span>
                            </a>
                        @else
                            <span class="text-[11px] text-slate-500 italic">No CV uploaded</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection