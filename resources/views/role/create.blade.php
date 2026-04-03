@extends('layouts.app')

@section('title', 'Create Role')

@section('content')

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                    Create Role
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Assign permissions without selecting tables manually
                </p>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-2xl  shadow-sm p-6 sm:p-8">

                <form action="{{ route('role.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Role Info --}}
                    <div class="flex flex-col gap-3">

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Role Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="border rounded-md  px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('name') ? 'border-red-500' : '' }}">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Description</label>
                            <textarea name="description" rows="4"
                                class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('description') ? 'border-red-500' : '' }}"
                                placeholder="Enter description...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- 🔥 PERMISSIONS TABLE --}}
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-4">
                            Assign Permissions for Each Table
                        </h2>

                        <div class="bg-gray-50 border border-gray-200 rounded-2xl overflow-x-auto">
                            @php
                                $permissionMap = $permissions->keyBy('slug');
                                $actions = [
                                    'View' => 'read',
                                    'Create' => 'create',
                                    'Edit' => 'update',
                                    'Delete' => 'delete',
                                ];
                            @endphp

                            <table class="w-full text-sm">
                                <thead class="bg-gray-900 text-gray-400 uppercase text-xs">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Module</th>
                                        @foreach ($actions as $label => $slug)
                                            <th class="px-4 py-3 text-center">{{ $label }}</th>
                                        @endforeach
                                        <th class="px-4 py-3 text-center">Full Access</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y">
                                    @foreach ($tableNames as $table)
                                        @php
                                            $selected = old('permissions.' . $table, []);
                                        @endphp
                                        <tr class="hover:bg-indigo-50/40 transition">
                                            <td class="px-4 py-3 font-semibold text-gray-900">
                                                {{ ucfirst($table) }}
                                            </td>

                                            @foreach ($actions as $slug)
                                                <td class="px-4 py-3 text-center">
                                                    @if (isset($permissionMap[$slug]))
                                                        <input type="checkbox" name="permissions[{{ $table }}][]"
                                                            value="{{ $permissionMap[$slug]->id }}"
                                                            class="perm-checkbox w-4 h-4 text-indigo-600 rounded"
                                                            {{ in_array($permissionMap[$slug]->id, $selected) ? 'checked' : '' }}
                                                            onchange="syncRow(this)">
                                                    @else
                                                        <span class="text-gray-300">—</span>
                                                    @endif
                                                </td>
                                            @endforeach

                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox" class="row-checkbox w-4 h-4 text-indigo-600"
                                                    onclick="toggleRow(this)">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @error('permissions')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 text-white py-2.5 rounded-xl font-semibold hover:bg-indigo-700">
                            Create Role
                        </button>

                        <a href="{{ route('role.index') }}"
                            class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-center hover:bg-gray-50">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>

    {{-- JS --}}

    <script>
        // Full row select
        function toggleRow(el) {
            let row = el.closest('tr');
            let checkboxes = row.querySelectorAll('.perm-checkbox');

            checkboxes.forEach(cb => cb.checked = el.checked);
        }

        // Individual → sync row checkbox
        function syncRow(el) {
            let row = el.closest('tr');
            let all = row.querySelectorAll('.perm-checkbox');
            let checked = row.querySelectorAll('.perm-checkbox:checked');
            let rowCheckbox = row.querySelector('.row-checkbox');

            rowCheckbox.checked = (all.length === checked.length);
        }
    </script>

@endsection
