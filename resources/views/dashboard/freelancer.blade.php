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
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>

<body class="font-sans antialiased bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16 gap-2">

                {{-- Logo --}}
                <a href="/" class="flex items-center gap-2 shrink-0 mr-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="font-bold text-lg text-slate-900 dark:text-white hidden sm:inline">FreelanceHub</span>
                </a>

                {{-- Primary nav links --}}
                <div class="hidden md:flex items-center gap-0.5">
                    <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors duration-150 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ __('Commissions') }}
                    </a>
                    <a href="{{ route('applications.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 transition-colors duration-150 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ __('Applications') }}
                    </a>
                    <a href="{{ route('reviews.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors duration-150 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        {{ __('Reviews') }}
                    </a>
                    <a href="{{ route('invoices.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors duration-150 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('Invoices') }}
                    </a>

                    <a href="{{ route('favorites.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-150 cursor-pointer
                        {{ request()->routeIs('favorites.*')
                            ? 'bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400'
                            : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        {{ __('Favorites') }}
                    </a>

                </div>

                {{-- Right side --}}
                <div class="flex items-center gap-1 ml-auto">

                    {{-- Dark mode toggle --}}
                    <button
                        x-data="{
                            dark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                            toggle() {
                                this.dark = !this.dark;
                                document.documentElement.classList.toggle('dark', this.dark);
                                localStorage.theme = this.dark ? 'dark' : 'light';
                            }
                        }"
                        @click="toggle()"
                        type="button"
                        aria-label="Toggle dark mode"
                        class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-700 dark:hover:text-slate-200 transition-colors duration-150 cursor-pointer">
                        <svg x-show="dark" style="width:18px;height:18px" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd" />
                        </svg>
                        <svg x-show="!dark" style="width:18px;height:18px" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>

                    {{-- User dropdown --}}
                    <div class="relative ml-1" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-2 pl-1.5 pr-2.5 py-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-150 cursor-pointer">
                            <div class="w-7 h-7 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-white text-xs font-bold">{{ strtoupper(substr(Auth::user()->firstname, 0, 1)) }}</span>
                            </div>
                            <span class="hidden md:inline text-sm font-medium text-slate-700 dark:text-slate-300">{{ Auth::user()->firstname }}</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-150" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-1.5 w-52 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg shadow-slate-900/5 py-1 z-50">

                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3.5 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors cursor-pointer">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Profile') }}
                            </a>

                            {{-- Mobile-only links --}}
                            <a href="{{ route('commissions.index') }}" class="flex items-center gap-2.5 px-3.5 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors cursor-pointer md:hidden">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ __('Commissions') }}
                            </a>
                            <a href="{{ route('applications.index') }}" class="flex items-center gap-2.5 px-3.5 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors cursor-pointer md:hidden">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                {{ __('Applications') }}
                            </a>
                            <a href="{{ route('reviews.index') }}" class="flex items-center gap-2.5 px-3.5 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors cursor-pointer md:hidden">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                {{ __('Reviews') }}
                            </a>
                            <a href="{{ route('invoices.index') }}" class="flex items-center gap-2.5 px-3.5 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors cursor-pointer md:hidden">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ __('Invoices') }}
                            </a>

                            <div class="border-t border-slate-100 dark:border-slate-800 my-1 mx-1"></div>
                            <div class="px-3.5 py-2">
                                <p class="text-xs font-medium text-slate-400 dark:text-slate-500 mb-2">{{ __('Language') }}</p>
                                <div class="flex gap-1.5">
                                    <form method="POST" action="{{ route('locale.switch', 'en') }}">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded-md cursor-pointer transition-colors duration-150 {{ app()->getLocale() === 'en' ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}">🇬🇧 EN</button>
                                    </form>
                                    <form method="POST" action="{{ route('locale.switch', 'nl') }}">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded-md cursor-pointer transition-colors duration-150 {{ app()->getLocale() === 'nl' ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' }}">🇳🇱 NL</button>
                                    </form>
                                </div>
                            </div>

                            <div class="border-t border-slate-100 dark:border-slate-800 my-1 mx-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-3.5 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log out') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Mobile hamburger --}}
                    <button type="button"
                        onclick="document.getElementById('mobile-menu-freelancer').classList.toggle('hidden')"
                        class="md:hidden ml-1 w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-150 cursor-pointer"
                        aria-label="Open menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Nav --}}
            <div id="mobile-menu-freelancer" class="hidden md:hidden border-t border-slate-100 dark:border-slate-800 py-3">
                <div class="flex flex-col gap-0.5">
                    <a href="{{ route('commissions.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ __('Commissions') }}
                    </a>
                    <a href="{{ route('applications.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ __('Applications') }}
                    </a>
                    <a href="{{ route('reviews.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        {{ __('Reviews') }}
                    </a>
                    <a href="{{ route('invoices.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('Invoices') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                    {!! __('Welcome back, :name!', ['name' => '<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-indigo-600">' . e(Auth::user()->firstname) . '</span>']) !!}
                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">{{ __('Discover new commissions and manage your freelance career.') }}</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('commissions.index') }}" class="group flex items-center gap-3 bg-purple-50 dark:bg-purple-900/30 hover:bg-purple-100 dark:hover:bg-purple-900 border border-purple-200 dark:border-purple-700 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-purple-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-purple-800 dark:text-purple-300">{{ __('Commissions') }}</span>
                        <p class="text-xs text-purple-600 dark:text-purple-400">{{ \App\Models\Commission::where('status', 'open')->count() }} {{ __('open') }}</p>
                    </div>
                </a>

                <a href="{{ route('applications.index') }}" class="group flex items-center gap-3 bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-900 border border-indigo-200 dark:border-indigo-700 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-indigo-800 dark:text-indigo-300">{{ __('Applications') }}</span>
                        <p class="text-xs text-indigo-600 dark:text-indigo-400">{{ Auth::user()->applications()->count() }} {{ __('total') }}</p>
                    </div>
                </a>

                <a href="{{ route('reviews.index') }}" class="group flex items-center gap-3 bg-amber-50 dark:bg-amber-900/30 hover:bg-amber-100 dark:hover:bg-amber-900 border border-amber-200 dark:border-amber-700 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-amber-500 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-amber-800 dark:text-amber-300">{{ __('My Reviews') }}</span>
                        <p class="text-xs text-amber-600 dark:text-amber-400">{{ Auth::user()->receivedReviews()->count() ?? 0 }} {{ __('received') }}</p>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 bg-slate-50 dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 border border-slate-200 dark:border-slate-600 rounded-xl p-4 transition-colors">
                    <div class="w-9 h-9 bg-slate-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('Profile') }}</span>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
                    </div>
                </a>
            </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold mb-1">{{ \App\Models\Commission::where('status', 'open')->count() }}</div>
                    <div class="text-purple-200 text-sm">{{ __('Available Projects') }}</div>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-1">{{ \App\Models\Commission::where('status', 'open')->where('category_id', Auth::user()->preferred_category_id ?? 1)->count() }}</div>
                    <div class="text-purple-200 text-sm">{{ __('In Your Category') }}</div>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-1">€{{ number_format(\App\Models\Commission::where('status', 'open')->avg('budget') ?? 0, 0, ',', '.') }}</div>
                    <div class="text-purple-200 text-sm">{{ __('Avg. Project Budget') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Available Commissions -->
    <section class="py-16 bg-slate-50 dark:bg-slate-900">
        <section class="py-16 bg-slate-50 dark:bg-slate-900">
            @php auth()->user()->load('favorites'); @endphp
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-3">{{ __('Available Commissions') }}</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-lg">{{ __('Find projects that match your skills and start working') }}</p>
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
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-300">
                                {{ $commission->category->name }}
                            </span>
                            @endif
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-2">{{ $commission->description }}</p>
                        <div class="flex gap-2">
                            <a href="{{ route('commissions.show', $commission) }}" class="flex-1 text-center bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                {{ __('View Details') }}
                            </a>

                            {{-- Favoriet knop --}}
                            @php $isFavorite = auth()->user()->favorites->contains($commission->id); @endphp
                            <form action="{{ route('favorites.toggle', $commission) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ $isFavorite ? 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-200' }}" title="{{ $isFavorite ? 'Verwijder uit favorieten' : 'Voeg toe aan favorieten' }}">
                                    {{ $isFavorite ? '❤️' : '🤍' }}
                                </button>
                            </form>

                            @php $application = $commission->applications->where('user_id', auth()->id())->first(); @endphp
                            @if($application)
                            @if($application->status === 'accepted')
                            <span class="flex-1 text-center bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-3 py-2 rounded-lg text-sm font-medium">
                                {{ __('✅ Accepted') }}
                            </span>
                            @elseif($application->status === 'rejected')
                            <span class="flex-1 text-center bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 px-3 py-2 rounded-lg text-sm font-medium">
                                {{ __('❌ Rejected') }}
                            </span>
                            @else
                            <span class="flex-1 text-center bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 px-3 py-2 rounded-lg text-sm font-medium">
                                {{ __('⏳ Pending') }}
                            </span>
                            @endif
                            @else
                            <a href="{{ route('commissions.show', $commission) }}" class="flex-1 text-center bg-purple-100 dark:bg-purple-900/30 hover:bg-purple-200 dark:hover:bg-purple-800 text-purple-700 dark:text-purple-300 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                {{ __('Apply') }}
                            </a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('No commissions available') }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 mb-6">{{ __('Check back later for new opportunities.') }}</p>
                        <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-md">
                            {{ __('Refresh') }}
                        </a>
                    </div>
                    @endforelse
                </div>

                @if(\App\Models\Commission::where('status', 'open')->count() > 6)
                <div class="text-center mt-8">
                    <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-600 px-6 py-3 rounded-lg font-semibold transition-colors">
                        {{ __('View All Commissions') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                @endif
            </div>
        </section>

        <!-- My Invoices -->
        <section class="py-16 bg-white dark:bg-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-1">{{ __('My Invoices') }}</h2>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">{{ __('Invoices from your accepted offers') }}</p>
                    </div>
                    <a href="{{ route('invoices.index') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 text-sm font-medium transition-colors">
                        {{ __('View all') }} →
                    </a>
                </div>

                @php $recentInvoices = Auth::user()->freelancerInvoices()->with('commission')->latest()->take(5)->get(); @endphp

                @if($recentInvoices->isEmpty())
                <p class="text-slate-500 dark:text-slate-400 text-sm">{{ __('No invoices yet. Invoices are created when a client accepts your offer.') }}</p>
                @else
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50">
                                <th class="text-left px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">{{ __('Invoice') }}</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">{{ __('Commission') }}</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">{{ __('Amount') }}</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">{{ __('Status') }}</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach($recentInvoices as $invoice)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-3 font-mono text-slate-700 dark:text-slate-300">{{ $invoice->invoice_number }}</td>
                                <td class="px-6 py-3 text-slate-600 dark:text-slate-400">{{ $invoice->commission->title ?? '-' }}</td>
                                <td class="px-6 py-3 font-semibold text-slate-800 dark:text-slate-200">€{{ number_format($invoice->amount, 2, ',', '.') }}</td>
                                <td class="px-6 py-3">
                                    @if($invoice->isPaid())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300">{{ __('Paid') }}</span>
                                    @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300">{{ __('Pending') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 text-sm font-medium transition-colors">{{ __('View') }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </section>