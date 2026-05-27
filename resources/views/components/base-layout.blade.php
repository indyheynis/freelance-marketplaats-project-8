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

<body class="font-sans antialiased bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 sticky top-0 z-50 shadow-sm">
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
                        <span class="font-bold text-xl text-slate-800 dark:text-white">FreelanceHub</span>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:block flex-1 max-w-md mx-8">
                    <form action="{{ request()->routeIs('categories.*') ? route('categories.search') : route('search') }}" method="GET" class="relative">
                        <input type="text" name="q" placeholder="{{ request()->routeIs('categories.*') ? __('Search categories...') : __('Search commissions...') }}" value="{{ request('q') }}"
                            class="w-full pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-700 dark:text-slate-100 border border-slate-200 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </form>
                </div>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('commissions.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors {{ request()->routeIs('commissions.index') ? 'text-indigo-600' : '' }}">
                        {{ __('Commissions') }}
                    </a>
                    <a href="{{ route('categories.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors {{ request()->routeIs('categories.index') ? 'text-indigo-600' : '' }}">
                        {{ __('Categories') }}
                    </a>
                    @auth
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('users.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors {{ request()->routeIs('users.index') ? 'text-indigo-600' : '' }}">
                        {{ __('Users') }}
                    </a>
                    @endif
                    @endauth
                </div>

                <!-- Auth Links -->
                <div class="flex items-center gap-3">
                    <button id="theme-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    @guest
                    {{-- Language switcher for guests --}}
                    <div class="flex items-center gap-1">
                        <form method="POST" action="{{ route('locale.switch', 'en') }}">
                            @csrf
                            <button type="submit" class="px-2 py-1 text-xs font-medium rounded {{ app()->getLocale() === 'en' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
                                EN
                            </button>
                        </form>
                        <form method="POST" action="{{ route('locale.switch', 'nl') }}">
                            @csrf
                            <button type="submit" class="px-2 py-1 text-xs font-medium rounded {{ app()->getLocale() === 'nl' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
                                NL
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors text-sm">{{ __('Log in') }}</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm text-sm">{{ __('Sign up') }}</a>
                    @else
                    @if(Auth::user()->isFreelancer())
                    <a href="{{ route('applications.index') }}" class="hidden md:inline text-slate-600 hover:text-indigo-600 font-medium transition-colors text-sm {{ request()->routeIs('applications.index') ? 'text-indigo-600' : '' }}">{{ __('Applications') }}</a>
                    <a href="{{ route('reviews.index') }}" class="hidden md:inline text-slate-600 hover:text-indigo-600 font-medium transition-colors text-sm {{ request()->routeIs('reviews.index') ? 'text-indigo-600' : '' }}">{{ __('Reviews') }}</a>
                    @endif
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 rounded-lg px-3 py-2 transition-colors">
                            <div class="w-6 h-6 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-semibold">{{ strtoupper(substr(Auth::user()->firstname ?? Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="hidden md:inline text-sm font-medium text-slate-700">{{ Auth::user()->firstname ?? Auth::user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition
                            class="absolute right-0 mt-2 w-52 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg py-1 z-50">
                            @if(Auth::user()->isFreelancer())
                            <a href="{{ route('dashboard.freelancer') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                                </svg>
                                {{ __('Dashboard') }}
                            </a>
                            <a href="{{ route('applications.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 md:hidden">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                {{ __('Applications') }}
                            </a>
                            <a href="{{ route('reviews.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 md:hidden">
                                <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                                {{ __('Reviews') }}
                            </a>
                            @elseif(Auth::user()->isClient())
                            <a href="{{ route('dashboard.client') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                                </svg>
                                {{ __('Dashboard') }}
                            </a>
                            @elseif(Auth::user()->isAdmin())
                            <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                                </svg>
                                {{ __('Management') }}
                            </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Profile') }}
                            </a>

                            {{-- Language switcher --}}
                            <div class="border-t border-slate-100 my-1"></div>
                            <div class="px-4 py-2">
                                <p class="text-xs text-slate-400 mb-1.5">{{ __('Language') }}</p>
                                <div class="flex gap-1.5">
                                    <form method="POST" action="{{ route('locale.switch', 'en') }}">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded {{ app()->getLocale() === 'en' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
                                            🇬🇧 EN
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('locale.switch', 'nl') }}">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded {{ app()->getLocale() === 'nl' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
                                            🇳🇱 NL
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:hover:text-white" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Nav -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col gap-2">
                    <a href="{{ route('commissions.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium py-2">{{ __('Commissions') }}</a>
                    <a href="{{ route('categories.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium py-2">{{ __('Categories') }}</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 dark:bg-slate-950 text-slate-400 dark:text-slate-500 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="font-bold text-lg text-white dark:text-slate-100">FreelanceHub</span>
                </div>
                <p class="text-sm">&copy; {{ date('Y') }} FreelanceHub. {{ __('All rights reserved.') }}</p>
            </div>
        </div>
    </footer>

</body>

</html>
