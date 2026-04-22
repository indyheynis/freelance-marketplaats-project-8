<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreelanceHub - Find & Hire Freelancers</title>
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
                <div class="flex items-center gap-3">
                    <a href="{{ route('commissions.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Commissions</a>
                    @auth
                        <a href="{{ auth()->user()->isFreelancer() ? route('dashboard.freelancer') : route('dashboard.client') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm">Sign up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <span class="inline-block bg-indigo-100 text-indigo-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-6">
                🚀 The freelance marketplace for everyone
            </span>
            <h1 class="text-5xl font-bold text-slate-900 mb-6 leading-tight">
                Connect with top <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-600">freelancers</span><br>or find your next client
            </h1>
            <p class="text-xl text-slate-500 mb-10 max-w-2xl mx-auto">
                FreelanceHub brings clients and freelancers together. Post commissions, browse opportunities, and get work done — all in one place.
            </p>
            <div class="flex items-center justify-center gap-4 flex-wrap">
                <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-md text-lg">
                    Get Started Free
                </a>
                <a href="{{ route('commissions.index') }}" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 px-8 py-3 rounded-lg font-semibold transition-colors text-lg">
                    Browse Commissions
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold mb-1">500+</div>
                    <div class="text-indigo-200 text-sm">Active Freelancers</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-1">1.2k</div>
                    <div class="text-indigo-200 text-sm">Commissions Posted</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-1">98%</div>
                    <div class="text-indigo-200 text-sm">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-slate-900 mb-3">How it works</h2>
                <p class="text-slate-500 text-lg">Simple steps to get started</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 text-center">
                    <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">1. Create an account</h3>
                    <p class="text-slate-500 text-sm">Sign up as a freelancer or client and set up your profile in minutes.</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 text-center">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">2. Post or browse</h3>
                    <p class="text-slate-500 text-sm">Clients post commissions, freelancers browse and find the perfect project.</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 text-center">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">3. Get it done</h3>
                    <p class="text-slate-500 text-sm">Connect, collaborate and complete projects with ease.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- For Who Section -->
    <section class="py-20 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-slate-900 mb-3">Built for both sides</h2>
                <p class="text-slate-500 text-lg">Whether you're hiring or looking for work, FreelanceHub has you covered.</p>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Client Card -->
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl border border-indigo-200 p-8">
                    <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">For Clients</h3>
                    <ul class="space-y-2 text-slate-600 text-sm mb-6">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Post commissions easily
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Set your own budget & deadline
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Find the right freelancer fast
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors text-sm">
                        Join as Client
                    </a>
                </div>
                <!-- Freelancer Card -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200 p-8">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">For Freelancers</h3>
                    <ul class="space-y-2 text-slate-600 text-sm mb-6">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Browse open commissions
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Work on your own schedule
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Grow your freelance career
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors text-sm">
                        Join as Freelancer
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to get started?</h2>
            <p class="text-indigo-200 text-lg mb-8">Join hundreds of freelancers and clients already using FreelanceHub.</p>
            <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-600 hover:bg-slate-100 px-8 py-3 rounded-lg font-semibold transition-colors text-lg shadow-md">
                Create your free account
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-gradient-to-br from-indigo-500 to-purple-600 rounded flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="font-semibold text-white">FreelanceHub</span>
            </div>
            <p class="text-sm">&copy; {{ date('Y') }} FreelanceHub. All rights reserved.</p>
            <div class="flex gap-4 text-sm">
                <a href="{{ route('commissions.index') }}" class="hover:text-white transition-colors">Commissions</a>
                <a href="{{ route('login') }}" class="hover:text-white transition-colors">Login</a>
                <a href="{{ route('register') }}" class="hover:text-white transition-colors">Register</a>
            </div>
        </div>
    </footer>

</body>
</html>