@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-white">Admin: Submitted Job Applications</h1>

    <div class="bg-slate-950 border border-slate-800 rounded-xl overflow-hidden">
        <table class="w-full text-left text-xs text-slate-300">
            <thead class="bg-slate-900 text-slate-400 uppercase font-bold border-b border-slate-800">
                <tr>
                    <th class="p-4">Candidate</th>
                    <th class="p-4">Job Title</th>
                    <th class="p-4">Applied Date</th>
                    <th class="p-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-900">
                @forelse($applications as $app)
                    <tr>
                        <td class="p-4 font-bold text-white">{{ $app->user->name }} ({{ $app->user->email }})</td>
                        <td class="p-4 text-indigo-400">{{ $app->job->title }}</td>
                        <td class="p-4">{{ $app->created_at->format('M d, Y') }}</td>
                        <td class="p-4 uppercase font-bold text-xs {{ $app->status === 'applied' ? 'text-emerald-400' : 'text-rose-400' }}">{{ $app->status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-4 text-slate-500">No applications submitted yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection