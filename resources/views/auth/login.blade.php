@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-slate-950 border border-slate-800 p-8 rounded-2xl shadow-xl mt-10">
    <h1 class="text-2xl font-bold text-white mb-2 text-center">Welcome Back</h1>
    <p class="text-xs text-slate-400 mb-6 text-center">Sign in to your AI JobBoard account</p>

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs text-slate-400 mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-slate-900 border border-slate-800 text-xs p-3 rounded-lg text-white focus:outline-none focus:border-indigo-500" required autofocus>
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

        <div class="flex items-center justify-between text-xs text-slate-400">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded bg-slate-900 border-slate-800 text-indigo-600">
                <span>Remember me</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs py-3 rounded-lg transition-colors">Log In</button>
    </form>

    <div class="mt-6 text-center text-xs text-slate-400">
        Don't have an account? <a href="{{ route('register') }}" class="text-indigo-400 underline font-semibold">Register here</a>
    </div>
</div>
@endsection