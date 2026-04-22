<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Freelance Marketplace') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-slate-800">FreelanceHub</span>
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('commissions.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors {{ request()->routeIs('commissions.index') ? 'text-indigo-600' : '' }}">
                        Commissions
                    </a>
                    <a href="{{ route('categories.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors {{ request()->routeIs('categories.index') ? 'text-indigo-600' : '' }}">
                        Categories
                    </a>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('users.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors {{ request()->routeIs('users.index') ? 'text-indigo-600' : '' }}">
                                Users
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Auth Links -->
                <div class="flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm">Sign up</a>
                    @else
                        <div class="flex items-center gap-4">
                            <span class="text-slate-600 text-sm">Welcome, {{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-slate-600 hover:text-red-600 font-medium transition-colors text-sm">Log out</button>
                            </form>
                        </div>
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-slate-600 hover:text-slate-800" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Nav -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col gap-2">
                    <a href="{{ route('commissions.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium py-2">Commissions</a>
                    <a href="{{ route('categories.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium py-2">Categories</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="font-bold text-lg text-white">FreelanceHub</span>
                </div>
                <p class="text-sm">&copy; {{ date('Y') }} FreelanceHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
