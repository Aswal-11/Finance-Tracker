@extends('layouts.app')

@section('content')
    <div class="min-h-[calc(100vh-64px)] flex items-center justify-center px-4 py-16 sm:px-6">
        <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-8 shadow-xl">
            <h1 class="text-2xl font-semibold text-slate-900">Sign in</h1>
            <p class="mt-2 text-sm text-slate-500">Enter your credentials to access the dashboard.</p>

            <form method="POST" action="/login" class="mt-8 space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" id="email" required class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200" placeholder="Email" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" name="password" id="password" required class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200" placeholder="Password" />
                </div>

                <button type="submit" class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">Login</button>
            </form>
        </div>
    </div>
@endsection