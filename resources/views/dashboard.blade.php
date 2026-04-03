@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-semibold text-slate-900">Dashboard</h1>
            <p class="mt-2 text-sm text-slate-500">Your financial overview and system management.</p>
        </div>

        <!-- System Management Cards -->
        <div class="grid gap-6 md:grid-cols-3 mb-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900">Financial Records</h2>
                <p class="mt-3 text-sm leading-6 text-slate-500">Manage your income and expenses.</p>
                <a href="{{ route('records.index') }}"
                    class="mt-6 inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">View
                    Records</a>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900">Roles</h2>
                <p class="mt-3 text-sm leading-6 text-slate-500">Manage user roles in the system.</p>
                <a href="{{ route('role.index') }}"
                    class="mt-6 inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">View
                    Roles</a>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900">Subusers</h2>
                <p class="mt-3 text-sm leading-6 text-slate-500">Manage subusers and their assigned roles.</p>
                <a href="{{ route('subusers.index') }}"
                    class="mt-6 inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">View
                    Subusers</a>
            </div>
        </div>

        <!-- Financial Summary Cards -->
        <div class="grid gap-6 md:grid-cols-4 mb-8" id="financial-summary">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Total Income</h3>
                <p class="mt-2 text-2xl font-bold text-green-600" id="total-income">₹0.00</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Total Expenses</h3>
                <p class="mt-2 text-2xl font-bold text-red-600" id="total-expenses">₹0.00</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Net Balance</h3>
                <p class="mt-2 text-2xl font-bold text-blue-600" id="net-balance">₹0.00</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Categories</h3>
                <p class="mt-2 text-2xl font-bold text-purple-600" id="total-categories">0</p>
            </div>
        </div>

        <!-- Charts and Details -->
        <div class="grid gap-6 lg:grid-cols-2 mb-8">
            <!-- Category Breakdown -->
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-slate-900 mb-4">Category Breakdown</h3>
                <div id="category-breakdown" class="space-y-1">
                    <p class="text-slate-500">Loading...</p>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-slate-900 mb-4">Recent Activity</h3>
                <div id="recent-activity" class="space-y-3">
                    <p class="text-slate-500">Loading...</p>
                </div>
            </div>
        </div>

        <!-- Trends Section -->
        <div class="grid gap-6 lg:grid-cols-2 mb-8">
            <!-- Monthly Trends -->
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-slate-900 mb-4">Monthly Trends</h3>
                <div id="monthly-trends" class="space-y-3">
                    <p class="text-slate-500">Loading...</p>
                </div>
            </div>

            <!-- Weekly Trends -->
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-slate-900 mb-4">Weekly Trends</h3>
                <div id="weekly-trends" class="space-y-3">
                    <p class="text-slate-500">Loading...</p>
                </div>
            </div>
        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchDashboardData();
        });

        async function fetchDashboardData() {
            try {
                const response = await fetch('/api/dashboard-data');
                const data = await response.json();

                updateFinancialSummary(data);
                updateCategoryBreakdown(data.category_totals);
                updateRecentActivity(data.recent_activity);
                updateMonthlyTrends(data.monthly_trends);
                updateWeeklyTrends(data.weekly_trends);
            } catch (error) {
                console.error('Error fetching dashboard data:', error);
                showErrorState();
            }
        }

        function updateFinancialSummary(data) {
            document.getElementById('total-income').textContent = '₹' + formatCurrency(data.total_income);
            document.getElementById('total-expenses').textContent = '₹' + formatCurrency(data.total_expenses);
            document.getElementById('net-balance').textContent = '₹' + formatCurrency(data.net_balance);
            document.getElementById('total-categories').textContent = Object.keys(data.category_totals).length;
        }

        function updateCategoryBreakdown(categoryTotals) {
            const container = document.getElementById('category-breakdown');

            if (Object.keys(categoryTotals).length === 0) {
                container.innerHTML = '<p class="text-slate-500">No categories found.</p>';
                return;
            }

            let html = '';
            Object.entries(categoryTotals).forEach(([category, totals]) => {
                html += `
                    <div class="flex justify-between items-center p-1 bg-slate-50 rounded-lg">
                        <span class="font-medium text-slate-900">${category}</span>
                        <div class="text-right">
                            <div class="text-sm font-semibold ${totals.net >= 0 ? 'text-green-600' : 'text-red-600'}">
                                ₹${formatCurrency(totals.net)}
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        function updateRecentActivity(activities) {
            const container = document.getElementById('recent-activity');

            if (activities.length === 0) {
                container.innerHTML = '<p class="text-slate-500">No recent activity.</p>';
                return;
            }

            let html = '';
            activities.slice(0, 5).forEach(activity => {
                const typeClass = activity.type === 'income' ? 'text-green-600' : 'text-red-600';
                const typeIcon = activity.type === 'income' ? '+' : '-';

                html += `
                    <div class="flex justify-between items-center p-3 border border-slate-200 rounded-lg">
                        <div>
                            <div class="font-medium text-slate-900">${activity.category}</div>
                            <div class="text-sm text-slate-500">${activity.date}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold ${typeClass}">${typeIcon}₹${formatCurrency(activity.amount)}</div>
                            <div class="text-xs text-slate-500">${activity.type}</div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        function updateMonthlyTrends(trends) {
            const container = document.getElementById('monthly-trends');

            if (Object.keys(trends).length === 0) {
                container.innerHTML = '<p class="text-slate-500">No monthly data available.</p>';
                return;
            }

            let html = '';
            // Sort by date descending and take last 6 months
            const sortedMonths = Object.keys(trends)
                .sort()
                .reverse()
                .slice(0, 6);

            sortedMonths.forEach(monthKey => {
                const trend = trends[monthKey];
                const [year, month] = monthKey.split('-');
                const monthName = new Date(year, month - 1).toLocaleString('default', {
                    month: 'short',
                    year: 'numeric'
                });

                html += `
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg">
                        <span class="font-medium text-slate-900">${monthName}</span>
                        <span class="font-semibold ${trend.net >= 0 ? 'text-green-600' : 'text-red-600'}">₹${formatCurrency(trend.net)}</span>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        function updateWeeklyTrends(trends) {
            const container = document.getElementById('weekly-trends');

            if (Object.keys(trends).length === 0) {
                container.innerHTML = '<p class="text-slate-500">No weekly data available.</p>';
                return;
            }

            let html = '';
            // Sort by week descending and take last 8 weeks
            const sortedWeeks = Object.keys(trends)
                .sort()
                .reverse()
                .slice(0, 8);

            sortedWeeks.forEach(weekKey => {
                const trend = trends[weekKey];
                const [year, week] = weekKey.split('-');

                html += `
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg">
                        <span class="font-medium text-slate-900">Week ${week}, ${year}</span>
                        <span class="font-semibold ${trend.net >= 0 ? 'text-green-600' : 'text-red-600'}">₹${formatCurrency(trend.net)}</span>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount);
        }

        function showErrorState() {
            const sections = ['financial-summary', 'category-breakdown', 'recent-activity', 'monthly-trends',
                'weekly-trends'
            ];
            sections.forEach(sectionId => {
                const element = document.getElementById(sectionId);
                if (element) {
                    element.innerHTML = '<p class="text-red-600">Error loading data.</p>';
                }
            });
        }
    </script>
@endsection
