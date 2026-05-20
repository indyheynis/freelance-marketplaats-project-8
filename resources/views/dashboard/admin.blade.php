<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FreelanceHub - Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-800 min-h-screen flex flex-col">
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
                    <a href="{{ route('users.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Users</a>
                    <a href="{{ route('categories.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Categories</a>
                    <a href="{{ route('reviews.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Reviews</a>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-slate-500">Welcome, {{ Auth::user()->firstname }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-600 hover:text-red-600 font-medium transition-colors">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-slate-900 mb-3">Admin Dashboard</h1>
                <p class="text-slate-500 text-lg">Quick access to user, commission, review and category management.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                <a href="{{ route('users.index') }}" class="block bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-semibold text-slate-500">Users</span>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-50 text-indigo-600">U</span>
                    </div>
                    <h2 class="text-xl font-semibold text-slate-900 mb-2">Manage users</h2>
                    <p class="text-sm text-slate-500">Edit, delete, and inspect all registered users.</p>
                </a>

                <a href="{{ route('commissions.index') }}" class="block bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-semibold text-slate-500">Commissions</span>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-purple-50 text-purple-600">C</span>
                    </div>
                    <h2 class="text-xl font-semibold text-slate-900 mb-2">Browse commissions</h2>
                    <p class="text-sm text-slate-500">View all commissions and navigate to details.</p>
                </a>

                <a href="{{ route('reviews.index') }}" class="block bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-semibold text-slate-500">Reviews</span>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-amber-50 text-amber-600">R</span>
                    </div>
                    <h2 class="text-xl font-semibold text-slate-900 mb-2">View reviews</h2>
                    <p class="text-sm text-slate-500">Access review summaries and linked commissions.</p>
                </a>

                <a href="{{ route('categories.index') }}" class="block bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-semibold text-slate-500">Categories</span>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-100 text-slate-700">K</span>
                    </div>
                    <h2 class="text-xl font-semibold text-slate-900 mb-2">Manage categories</h2>
                    <p class="text-sm text-slate-500">Create and update category options for commissions.</p>
                </a>
            </div>
        </div>
    </main>
</body>

</html>