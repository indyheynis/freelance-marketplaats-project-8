<x-base-layout>
    <!-- Hero Section -->
    <section class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                    Welkom terug, <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-indigo-600">{{ Auth::user()->firstname }}</span>!
                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Ontdek nieuwe opdrachten en beheer je freelance carrière.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('commissions.index') }}" class="group flex items-center gap-3 bg-purple-50 dark:bg-purple-900 hover:bg-purple-100 dark:hover:bg-purple-800 border border-purple-200 dark:border-purple-700 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-purple-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-purple-800 dark:text-purple-200">Opdrachten</span>
                </a>
                <a href="{{ route('applications.index') }}" class="group flex items-center gap-3 bg-indigo-50 dark:bg-indigo-900 hover:bg-indigo-100 dark:hover:bg-indigo-800 border border-indigo-200 dark:border-indigo-700 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-indigo-800 dark:text-indigo-200">Sollicitaties</span>
                </a>
                <a href="{{ route('reviews.index') }}" class="group flex items-center gap-3 bg-amber-50 dark:bg-amber-900 hover:bg-amber-100 dark:hover:bg-amber-800 border border-amber-200 dark:border-amber-700 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-amber-500 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-amber-800 dark:text-amber-200">Mijn Reviews</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 bg-slate-50 dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 border border-slate-200 dark:border-slate-600 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-slate-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Profiel</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold mb-1">{{ \App\Models\Commission::where('status', 'open')->count() }}</div>
                    <div class="text-purple-200 text-sm">Available Projects</div>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-1">{{ \App\Models\Commission::where('status', 'open')->where('category_id', Auth::user()->preferred_category_id ?? 1)->count() }}</div>
                    <div class="text-purple-200 text-sm">In Your Category</div>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-1">€{{ number_format(\App\Models\Commission::where('status', 'open')->avg('budget') ?? 0, 0, ',', '.') }}</div>
                    <div class="text-purple-200 text-sm">Avg. Project Budget</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Available Commissions -->
    <section class="py-16 bg-slate-50 dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-3">Available Commissions</h2>
                <p class="text-slate-500 dark:text-slate-400 text-lg">Find projects that match your skills and start working</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse(\App\Models\Commission::with(['category', 'applications'])->where('status', 'open')->latest()->take(6)->get() as $commission)
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow p-6">
                    @if($commission->image)
                    <div class="mb-4 overflow-hidden rounded-3xl border border-slate-200 dark:border-slate-700">
                        <img src="{{ asset('storage/' . $commission->image) }}" alt="Commission image" class="w-full h-40 object-cover">
                    </div>
                    @endif
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white line-clamp-1">{{ $commission->title }}</h3>
                        @if($commission->category)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                            {{ $commission->category->name }}
                        </span>
                        @endif
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-2">{{ $commission->description }}</p>
                    <div class="flex gap-2">
                        <a href="{{ route('commissions.show', $commission) }}" class="flex-1 text-center bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            View Details
                        </a>
                        @php
                        $application = $commission->applications->where('user_id', auth()->id())->first();
                        @endphp
                        @if($application)
                        @if($application->status === 'accepted')
                        <span class="flex-1 text-center bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 px-3 py-2 rounded-lg text-sm font-medium">
                            ✅ Geaccepteerd
                        </span>
                        @elseif($application->status === 'rejected')
                        <span class="flex-1 text-center bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 px-3 py-2 rounded-lg text-sm font-medium">
                            ❌ Afgewezen
                        </span>
                        @else
                        <span class="flex-1 text-center bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-200 px-3 py-2 rounded-lg text-sm font-medium">
                            ⏳ In behandeling
                        </span>
                        @endif
                        @else
                        <a href="{{ route('commissions.show', $commission) }}" class="flex-1 text-center bg-purple-100 dark:bg-purple-900 hover:bg-purple-200 dark:hover:bg-purple-800 text-purple-700 dark:text-purple-200 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            Apply
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
                    <h3 class="text-lg font-medium text-slate-700 dark:text-slate-300 mb-2">No commissions available</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-6">Check back later for new opportunities.</p>
                    <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-md">
                        Refresh
                    </a>
                </div>
                @endforelse
            </div>

            @if(\App\Models\Commission::where('status', 'open')->count() > 6)
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