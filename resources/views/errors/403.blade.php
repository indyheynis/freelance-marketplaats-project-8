<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>403 - Geen toegang | {{ config('app.name', 'Freelance Marketplace') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-900 via-red-950 to-slate-900 text-white min-h-screen flex flex-col">

    <div class="flex-1 flex items-center justify-center px-4">
        <div class="text-center max-w-lg">
            <!-- Animated Icon -->
            <div class="mb-8">
                <div class="relative inline-block">
                    <div class="w-32 h-32 bg-gradient-to-br from-red-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto shadow-2xl shadow-red-500/30">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m0 0v2m0-2h2m-2 0H10m4-8V4a2 2 0 00-2-2H8a2 2 0 00-2 2v9a5 5 0 005 5h4a5 5 0 005-5v-1" />
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center shadow-lg shadow-red-500/30">
                        <span class="font-bold text-xl text-white">4</span>
                    </div>
                    <div class="absolute -bottom-2 -left-2 w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center shadow-lg shadow-red-500/30">
                        <span class="font-bold text-xl text-white">3</span>
                    </div>
                </div>
            </div>

            <!-- Error Title -->
            <h1 class="text-5xl md:text-6xl font-bold mb-4 bg-gradient-to-r from-white to-red-200 bg-clip-text text-transparent">
                Verboden
            </h1>

            <!-- Error Message -->
            <p class="text-xl text-red-200 mb-2">
                Geen autorisatie
            </p>
            <p class="text-slate-400 mb-8">
                Je hebt geen rechten om deze pagina te bekijken. Neem contact op met een administrator als je denkt dat dit een fout is.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Terug naar home
                </a>
                <a href="javascript:history.back()" class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-semibold transition-all border border-white/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Vorige pagina
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900/50 text-slate-400 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm">&copy; {{ date('Y') }} FreelanceHub. Alle rechten voorbehouden.</p>
        </div>
    </footer>

</body>
</html>
