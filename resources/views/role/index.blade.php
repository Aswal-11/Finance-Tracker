@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Roles</h1>
            <p class="mt-1 text-sm text-slate-500">Manage roles, permissions, and table access.</p>
        </div>
        <a href="{{ route('role.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Create New Role</a>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Description</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @foreach($roles as $role)
                <tr class="hover:bg-slate-50">
                    <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $role->id }}</td>
                    <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $role->name }}</td>
                    <td class="px-4 py-3 text-sm text-slate-600">{{ $role->description }}</td>
                    <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-600">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('role.show', $role->id) }}" class="rounded-md bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">View</a>
                            <a href="{{ route('role.edit', $role->id) }}" class="rounded-md bg-amber-100 px-3 py-2 text-sm font-medium text-amber-700 hover:bg-amber-200">Edit</a>
                            <form action="{{ route('role.destroy', $role->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-md bg-rose-500 px-3 py-2 text-sm font-medium text-white hover:bg-rose-600" onclick="return confirm('Are you sure?')">Delete</button>
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
