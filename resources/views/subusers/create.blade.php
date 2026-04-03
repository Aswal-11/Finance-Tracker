@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-slate-900">Create Subuser</h1>
            <p class="mt-2 text-sm text-slate-500">Add a new subuser and assign a role.</p>
        </div>

        <form action="{{ route('subusers.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200" />
                @error('name')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200" />
                @error('email')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <input type="password" id="password" name="password" required
                    class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200" />
                @error('password')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role_id" class="block text-sm font-medium text-slate-700">Role</label>
                <select id="role_id" name="role_id"
                    class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    <option value="">-- None --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Status</label>

                <div class="mt-2 flex items-center gap-3">

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="statusCheckbox" name="status" value="1" class="sr-only"
                            {{ old('status', 1) ? 'checked' : '' }}>

                        <div id="statusTrack"
                            class="w-11 h-6 bg-slate-200 rounded-full relative transition-colors duration-300">

                            <div id="statusThumb"
                                class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform duration-300">
                            </div>
                        </div>
                    </label>

                    <span id="statusText" class="text-sm text-slate-600">Active</span>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">Create
                    Subuser</button>
                <a href="{{ route('subusers.index') }}"
                    class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Cancel</a>
            </div>
        </form>
    </div>

    <span id="statusText" class="text-sm text-slate-600 mt-2 block"></span>

<script>
const statusCheckbox = document.getElementById('statusCheckbox');
const statusText = document.getElementById('statusText');
const statusTrack = document.getElementById('statusTrack');
const statusThumb = document.getElementById('statusThumb');

function updateStatusToggle() {
    const active = statusCheckbox.checked;
    statusText.innerText = active ? 'Active' : 'Inactive';

    statusTrack.classList.toggle('bg-green-500', active);
    statusTrack.classList.toggle('bg-slate-200', !active);

    statusThumb.classList.toggle('translate-x-5', active);
}

statusCheckbox.addEventListener('change', updateStatusToggle);

// Initialize on page load
updateStatusToggle();
</script>
@endsection
