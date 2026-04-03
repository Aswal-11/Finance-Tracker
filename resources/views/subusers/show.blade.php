@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900">Subuser Details</h1>
                <p class="mt-2 text-sm text-slate-500">Review the selected subuser profile.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('subusers.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Back</a>
                <a href="{{ route('subusers.edit', $subuser->id) }}" class="inline-flex items-center justify-center rounded-2xl bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">Edit</a>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="space-y-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">{{ $subuser->name }}</h2>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-sm font-medium text-slate-500">Email</p>
                        <p class="mt-2 text-sm text-slate-800">{{ $subuser->email }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-sm font-medium text-slate-500">Role</p>
                        <p class="mt-2 text-sm text-slate-800">{{ $subuser->role?->name ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection