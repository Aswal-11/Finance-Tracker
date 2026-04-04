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

            <!-- Left -->
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}"
                    class="text-xl font-semibold text-slate-900">{{ config('app.name', 'Laravel') }}</a>

                @if (auth('web')->check() || auth('subusers')->check())
                    <div class="hidden sm:flex flex-wrap items-center gap-2">
                        <a href="{{ route('dashboard') }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Dashboard</a>
                        <a href="{{ route('role.index') }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Roles</a>
                        <a href="{{ route('subusers.index') }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Subusers</a>
                        <a href="{{ route('records.index') }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Financial
                            Records</a>
                    </div>
                @endif
            </div>

            <!-- Right -->
            <div class="flex items-center gap-6">

                <!-- Logout -->
                @if (auth('web')->check() || auth('subusers')->check())
                    <!-- User -->
                    <div class="hidden sm:block text-right px-3 py-1 bg-blue-700 text-white rounded-md">
                        <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-xs">{{ Auth::user()->email }}</p>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="hidden sm:inline">
                        @csrf
                        <button type="submit"
                            class="rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">
                            Logout
                        </button>
                    </form>
                @endif

                <!-- Mobile Toggle Button -->
                <div class="sm:hidden">
                    <button id="mobile-menu-button" class="p-2 rounded-md text-slate-600 hover:bg-slate-100">
                        ☰
                    </button>
                </div>

            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    @if (auth('web')->check() || auth('subusers')->check())
        <div id="mobile-menu" class="hidden sm:hidden border-t border-slate-200 bg-white">
            <div class="px-4 py-3 space-y-2">

                <a href="{{ route('dashboard') }}"
                    class="block rounded-md px-3 py-2 text-sm text-slate-600 hover:bg-slate-100">
                    Dashboard
                </a>

                <a href="{{ route('role.index') }}"
                    class="block rounded-md px-3 py-2 text-sm text-slate-600 hover:bg-slate-100">
                    Roles
                </a>

                <a href="{{ route('subusers.index') }}"
                    class="block rounded-md px-3 py-2 text-sm text-slate-600 hover:bg-slate-100">
                    Subusers
                </a>

                <a href="{{ route('records.index') }}"
                    class="block rounded-md px-3 py-2 text-sm text-slate-600 hover:bg-slate-100">
                    Financial Records
                </a>

                <!-- User Info -->
                <div class="bg-blue-700 text-white px-3 py-2 rounded-md mt-4">
                    <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-white">{{ Auth::user()->email }}</p>
                </div>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full text-left mt-3 bg-red-600 text-white px-3 py-2 rounded-md">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    @endif

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Session Messages -->
        @if(session('success'))
            <div data-alert class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div data-alert class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')

    <script>
        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[data-alert]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.3s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.style.display = 'none', 300);
                }, 3000);
            });

            // Mobile toggle
            const btn = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');

            if (btn && menu) {
                btn.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>

</html>
