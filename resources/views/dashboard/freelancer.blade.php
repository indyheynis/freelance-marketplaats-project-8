<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FreelanceHub - Freelancer Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center gap-6">
                <a href="/" class="flex items-center gap-2 shrink-0">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-slate-800">FreelanceHub</span>
                </a>

                <div class="hidden md:flex items-center gap-6 flex-1">
                    <a href="{{ route('commissions.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors text-sm">Commissions</a>
                    <a href="{{ route('applications.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors text-sm">Sollicitaties</a>
                    <a href="{{ route('reviews.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors text-sm">Reviews</a>
                </div>

                <div class="relative shrink-0" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 rounded-lg px-3 py-2 transition-colors">
                        <div class="w-6 h-6 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs font-semibold">{{ strtoupper(substr(Auth::user()->firstname, 0, 1)) }}</span>
                        </div>
                        <span class="hidden md:inline text-sm font-medium text-slate-700">{{ Auth::user()->firstname }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-lg py-1 z-50">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profiel
                        </a>
                        <a href="{{ route('applications.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 md:hidden">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Sollicitaties
                        </a>
                        <a href="{{ route('reviews.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 md:hidden">
                            <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                            Reviews
                        </a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">
                    Welkom terug, <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-indigo-600">{{ Auth::user()->firstname }}</span>!
                </h1>
                <p class="text-slate-500 mt-1">Ontdek nieuwe opdrachten en beheer je freelance carrière.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('commissions.index') }}" class="group flex items-center gap-3 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-purple-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-purple-800">Opdrachten</span>
                </a>
                <a href="{{ route('applications.index') }}" class="group flex items-center gap-3 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-indigo-800">Sollicitaties</span>
                </a>
                <a href="{{ route('reviews.index') }}" class="group flex items-center gap-3 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-amber-500 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-amber-800">Mijn Reviews</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-slate-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Profiel</span>
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
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900 mb-3">Available Commissions</h2>
                <p class="text-slate-500 text-lg">Find projects that match your skills and start working</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse(\App\Models\Commission::with(['category', 'applications'])->where('status', 'open')->latest()->take(6)->get() as $commission)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6">
                    @if($commission->image)
                    <div class="mb-4 overflow-hidden rounded-3xl border border-slate-200">
                        <img src="{{ asset('storage/' . $commission->image) }}" alt="Commission image" class="w-full h-40 object-cover">
                    </div>
                    @endif
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold text-slate-800 line-clamp-1">{{ $commission->title }}</h3>
                        @if($commission->category)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ $commission->category->name }}
                        </span>
                        @endif
                    </div>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-2">{{ $commission->description }}</p>
                    <div class="flex gap-2">
                        <a href="{{ route('commissions.show', $commission) }}" class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            View Details
                        </a>
                        @php
                        $application = $commission->applications->where('user_id', auth()->id())->first();
                        @endphp
                        @if($application)
                        @if($application->status === 'accepted')
                        <span class="flex-1 text-center bg-green-100 text-green-700 px-3 py-2 rounded-lg text-sm font-medium">
                            ✅ Geaccepteerd
                        </span>
                        @elseif($application->status === 'rejected')
                        <span class="flex-1 text-center bg-red-100 text-red-700 px-3 py-2 rounded-lg text-sm font-medium">
                            ❌ Afgewezen
                        </span>
                        @else
                        <span class="flex-1 text-center bg-amber-100 text-amber-700 px-3 py-2 rounded-lg text-sm font-medium">
                            ⏳ In behandeling
                        </span>
                        @endif
                        @else
                        <a href="{{ route('commissions.show', $commission) }}" class="flex-1 text-center bg-purple-100 hover:bg-purple-200 text-purple-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            Apply
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-700 mb-2">No commissions available</h3>
                    <p class="text-slate-500 mb-6">Check back later for new opportunities.</p>
                    <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-md">
                        Refresh
                    </a>
                </div>
                @endforelse
            </div>

            @if(\App\Models\Commission::where('status', 'open')->count() > 6)
            <div class="text-center mt-8">
                <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 px-6 py-3 rounded-lg font-semibold transition-colors">
                    View All Commissions
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2026 FreelanceHub. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>