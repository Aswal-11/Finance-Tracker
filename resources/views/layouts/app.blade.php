<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <nav class="border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-slate-900">{{ config('app.name', 'Laravel') }}</a>
                @if(auth('web')->check() || auth('subusers')->check())
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('dashboard') }}" class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Dashboard</a>
                        <a href="{{ route('role.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Roles</a>
                        <a href="{{ route('subusers.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Subusers</a>
                        {{-- <a href="{{ route('posts.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Posts</a> --}}
                        <a href="{{ route('records.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Financial Records</a>
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-2">
                @if(auth('web')->check() || auth('subusers')->check())
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">Logout</button>
                    </form>
                @endif
            </div>
        </div>
    </nav>
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @yield('content')
    </main>
    @yield('scripts')

    <script>
        // Auto-hide session/flash messages after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[data-alert]');
            alerts.forEach(alert => {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.3s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 300);
                }, 3000);
            });
        });
    </script>
</body>
</html>