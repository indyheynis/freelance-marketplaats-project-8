<x-base-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ __('Admin Dashboard') }}</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">{{ __('Platform overview and management links.') }}</p>
        </div>

        {{-- KPIs --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-5">
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">{{ __('Total users') }}</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $stats['totalUsers'] }}</p>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ $stats['totalFreelancers'] }} {{ __('freelancers') }} · {{ $stats['totalClients'] }} {{ __('clients') }}</p>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-5">
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">{{ __('Open commissions') }}</p>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $stats['openCommissions'] }}</p>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ $stats['closedCommissions'] }} {{ __('closed') }}</p>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-5">
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">{{ __('Total applications') }}</p>
                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['totalApplications'] }}</p>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ __('Across all commissions') }}</p>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-5">
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">{{ __('Avg. budget') }}</p>
                <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">€{{ number_format($stats['avgBudget'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ __('Per commission') }}</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2 mb-8">
            {{-- Chart: open commissions per category --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
                <h2 class="text-base font-semibold text-slate-800 dark:text-slate-100 mb-4">{{ __('Open commissions per category') }}</h2>
                @if($commissionsByCategory->isEmpty())
                    <p class="text-slate-400 dark:text-slate-500 text-sm">{{ __('No data yet.') }}</p>
                @else
                    <div class="relative" style="height:260px">
                        <canvas id="categoryChart"></canvas>
                    </div>
                @endif
            </div>

            {{-- User breakdown --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
                <h2 class="text-base font-semibold text-slate-800 dark:text-slate-100 mb-4">{{ __('User breakdown') }}</h2>
                @if($stats['totalUsers'] === 0)
                    <p class="text-slate-400 dark:text-slate-500 text-sm">{{ __('No users yet.') }}</p>
                @else
                    <div class="relative" style="height:260px">
                        <canvas id="userChart"></canvas>
                    </div>
                @endif
            </div>
        </div>

        {{-- Management links --}}
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <a href="{{ route('users.index') }}" class="block bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">{{ __('Users') }}</span>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">U</span>
                </div>
                <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-2">{{ __('Manage users') }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Edit, delete, and inspect all registered users.') }}</p>
            </a>

            <a href="{{ route('commissions.index') }}" class="block bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">{{ __('Commissions') }}</span>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">C</span>
                </div>
                <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-2">{{ __('Browse commissions') }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('View all commissions and navigate to details.') }}</p>
            </a>

            <a href="{{ route('admin.reviews.index') }}" class="block bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">{{ __('Reviews') }}</span>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">R</span>
                </div>
                <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-2">{{ __('View reviews') }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Access review summaries and linked commissions.') }}</p>
            </a>

            <a href="{{ route('categories.index') }}" class="block bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">{{ __('Categories') }}</span>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300">K</span>
                </div>
                <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-2">{{ __('Manage categories') }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Create and update category options for commissions.') }}</p>
            </a>
        </div>
    </div>

    @if($commissionsByCategory->isNotEmpty() || $stats['totalUsers'] > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#94a3b8' : '#64748b';
        const gridColor = isDark ? '#1e293b' : '#f1f5f9';

        @if($commissionsByCategory->isNotEmpty())
        new Chart(document.getElementById('categoryChart'), {
            type: 'bar',
            data: {
                labels: {!! $commissionsByCategory->pluck('name')->toJson() !!},
                datasets: [{
                    label: '{{ __('Open commissions') }}',
                    data: {!! $commissionsByCategory->pluck('commissions_count')->toJson() !!},
                    backgroundColor: 'rgba(99,102,241,0.75)',
                    borderColor: 'rgba(99,102,241,1)',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0, color: textColor }, grid: { color: gridColor } },
                    x: { ticks: { color: textColor }, grid: { display: false } }
                }
            }
        });
        @endif

        @if($stats['totalUsers'] > 0)
        new Chart(document.getElementById('userChart'), {
            type: 'doughnut',
            data: {
                labels: ['{{ __('Freelancers') }}', '{{ __('Clients') }}', '{{ __('Admins') }}'],
                datasets: [{
                    data: [
                        {{ $stats['totalFreelancers'] }},
                        {{ $stats['totalClients'] }},
                        {{ $stats['totalUsers'] - $stats['totalFreelancers'] - $stats['totalClients'] }}
                    ],
                    backgroundColor: ['rgba(139,92,246,0.8)', 'rgba(99,102,241,0.8)', 'rgba(16,185,129,0.8)'],
                    borderWidth: 2,
                    borderColor: isDark ? '#1e293b' : '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: textColor, padding: 16, boxWidth: 12 }
                    }
                }
            }
        });
        @endif
    </script>
    @endif
</x-base-layout>
