<x-base-layout>
    <!-- Hero Section -->
    <section class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-4">
                Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-600">{{ Auth::user()->firstname }}</span>!
            </h1>
            <p class="text-xl text-slate-500 dark:text-slate-400 mb-8 max-w-2xl mx-auto">
                Manage your commissions and find the perfect freelancers for your projects.
            </p>
            <div class="flex items-center justify-center gap-4">
                <a href="{{ route('commissions.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-md">
                    Post New Commission
                </a>
                <a href="{{ route('commissions.index') }}" class="bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-600 px-8 py-3 rounded-lg font-semibold transition-colors">
                    View All Commissions
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold mb-1">{{ Auth::user()->commissions()->count() }}</div>
                    <div class="text-indigo-200 text-sm">Your Commissions</div>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-1">{{ Auth::user()->commissions()->where('status', 'open')->count() }}</div>
                    <div class="text-indigo-200 text-sm">Active Projects</div>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-1">€{{ number_format(Auth::user()->commissions()->sum('budget'), 0, ',', '.') }}</div>
                    <div class="text-indigo-200 text-sm">Total Budget</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Commissions -->
    <section class="py-16 bg-slate-50 dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-3">Your Recent Commissions</h2>
                <p class="text-slate-500 dark:text-slate-400 text-lg">Manage your active projects and track progress</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse(Auth::user()->commissions()->latest()->take(6)->get() as $commission)
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow p-6">
                    @if($commission->image)
                    <div class="mb-4 overflow-hidden rounded-3xl border border-slate-200 dark:border-slate-700">
                        <img src="{{ asset('storage/' . $commission->image) }}" alt="Commission image" class="w-full h-40 object-cover">
                    </div>
                    @endif
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white line-clamp-1">{{ $commission->title }}</h3>
                        @php
                        $hasAccepted = $commission->applications->where('status', 'accepted')->count() > 0;
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
    @if($hasAccepted) bg-blue-100 text-blue-800
    @elseif($commission->status === 'open') bg-green-100 text-green-800
    @elseif($commission->status === 'closed') bg-red-100 text-red-800
    @else bg-gray-100 text-gray-800 @endif">
                            @if($hasAccepted) 🎯 Taken
                            @else {{ ucfirst($commission->status) }}
                            @endif
                        </span>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-2">{{ $commission->description }}</p>
                    <div class="flex gap-2">
                        <a href="{{ route('commissions.show', $commission) }}" class="flex-1 text-center bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            View
                        </a>
                        @if($commission->status === 'open')
                        <a href="{{ route('commissions.edit', $commission) }}" class="flex-1 text-center bg-amber-100 hover:bg-amber-200 text-amber-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            Edit
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-700 dark:text-slate-300 mb-2">No commissions yet</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-6">Create your first commission to get started with freelancers.</p>
                    <a href="{{ route('commissions.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Commission
                    </a>
                </div>
                @endforelse
            </div>

            @if(Auth::user()->commissions()->count() > 6)
            <div class="text-center mt-8">
                <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-600 px-6 py-3 rounded-lg font-semibold transition-colors">
                    View All Commissions
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </section>
</x-base-layout>