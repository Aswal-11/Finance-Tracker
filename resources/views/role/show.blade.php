@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl space-y-6 rounded-3xl bg-white p-8 shadow-sm">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Role Details</h1>
        <p class="mt-1 text-sm text-slate-500">Review the role definition and assigned permissions.</p>
    </div>

    <div class="space-y-4 rounded-3xl border border-slate-200 bg-slate-50 p-6">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">{{ $role->name }}</h2>
            <p class="mt-2 text-sm text-slate-600">{{ $role->description }}</p>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Permissions</h3>
            @php
                $permissionGroups = $role->permissions->groupBy(function ($permission) {
                    return $permission->pivot->table_name ?? 'General';
                });
            @endphp

            @if($permissionGroups->isEmpty())
                <p class="mt-2 text-sm text-slate-700">None</p>
            @else
                <div class="mt-4 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Table</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Permissions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($permissionGroups as $tableName => $permissions)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-4 align-top text-sm font-medium text-slate-900">{{ $tableName }}</td>
                                    <td class="px-4 py-4 text-sm text-slate-600">
                                        {{ $permissions->pluck('name')->join(', ') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('role.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Back</a>
        <a href="{{ route('role.edit', $role->id) }}" class="inline-flex items-center justify-center rounded-2xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white hover:bg-amber-600">Edit</a>
    </div>
</div>
@endsection
