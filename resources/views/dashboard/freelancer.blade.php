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
            <div class="flex justify-between h-16 items-center">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-slate-800">FreelanceHub</span>
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('commissions.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Commissions</a>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-slate-500">Welcome, {{ Auth::user()->firstname }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-600 hover:text-red-600 font-medium transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h1 class="text-4xl font-bold text-slate-900 mb-4">
                Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-indigo-600">{{ Auth::user()->firstname }}</span>!
            </h1>
            <p class="text-xl text-slate-500 mb-8 max-w-2xl mx-auto">
                Discover new opportunities and grow your freelance career.
            </p>
            <div class="flex items-center justify-center gap-4">
                <a href="{{ route('commissions.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-md">
                    Browse Commissions
                </a>
                <a href="{{ route('profile.edit') }}" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Update Profile
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
                @forelse(\App\Models\Commission::with(['category', 'applications'])->where('status', 'open')->latest()->take(6)->get() as $commission) <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6">
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
                        @if($commission->applications->where('user_id', auth()->id())->count() > 0)
                        <span class="flex-1 text-center bg-green-100 text-green-700 px-3 py-2 rounded-lg text-sm font-medium">
                            ✅ Applied
                        </span>
                        @else
                        <a href="{{ route('commissions.show', $commission) }}" class="flex-1 text-center bg-purple-100 hover:bg-purple-200 text-purple-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            Apply
                        </a>
                        @endif
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
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
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