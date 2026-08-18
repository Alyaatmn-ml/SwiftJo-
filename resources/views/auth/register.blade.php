@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-slate-950 border border-slate-800 p-8 rounded-2xl shadow-xl mt-10">
    <h1 class="text-2xl font-bold text-white mb-2 text-center">Create Account</h1>
    <p class="text-xs text-slate-400 mb-6 text-center">Register as a Candidate on AI JobBoard</p>

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs text-slate-400 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-slate-900 border border-slate-800 text-xs p-3 rounded-lg text-white focus:outline-none focus:border-indigo-500" required autofocus>
            @error('name')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs text-slate-400 mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-slate-900 border border-slate-800 text-xs p-3 rounded-lg text-white focus:outline-none focus:border-indigo-500" required>
            @error('email')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs text-slate-400 mb-1">Password</label>
            <input type="password" name="password" class="w-full bg-slate-900 border border-slate-800 text-xs p-3 rounded-lg text-white focus:outline-none focus:border-indigo-500" required>
            @error('password')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs text-slate-400 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full bg-slate-900 border border-slate-800 text-xs p-3 rounded-lg text-white focus:outline-none focus:border-indigo-500" required>
        </div>

        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs py-3 rounded-lg transition-colors">Create Candidate Account</button>
    </form>

    <div class="mt-6 text-center text-xs text-slate-400">
        Already have an account? <a href="{{ route('login') }}" class="text-indigo-400 underline font-semibold">Log in here</a>
    </div>
</div>
@endsection