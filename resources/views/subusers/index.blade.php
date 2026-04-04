@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900">Subusers</h1>
                <p class="mt-2 text-sm text-slate-500">Create and manage application subusers.</p>
            </div>
            <a href="{{ route('subusers.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">Create New Subuser</a>
        </div>


        <div class="mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">ID</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Name</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Email</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Role</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach($subusers as $subuser)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 text-sm text-slate-600">{{ $subuser->id }}</td>
                            <td class="px-4 py-4 text-sm text-slate-900">{{ $subuser->name }}</td>
                            <td class="px-4 py-4 text-sm text-slate-600">{{ $subuser->email }}</td>
                            <td class="px-4 py-4 text-sm text-slate-600">{{ $subuser->role?->name ?? '—' }}</td>
                            <td class="px-4 py-4 text-sm">
                                @if($subuser->status)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <span class="w-2 h-2 bg-emerald-600 rounded-full mr-2"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-800">
                                        <span class="w-2 h-2 bg-slate-600 rounded-full mr-2"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-600">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('subusers.show', $subuser->id) }}" class="rounded-2xl bg-sky-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-sky-400">View</a>
                                    <a href="{{ route('subusers.edit', $subuser->id) }}" class="rounded-2xl bg-amber-500 px-3 py-2 text-xs font-semibold text-slate-900 transition hover:bg-amber-400">Edit</a>
                                    <form action="{{ route('subusers.destroy', $subuser->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-2xl bg-rose-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-rose-400" onclick="return confirm('Delete this subuser?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection