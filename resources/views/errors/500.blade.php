<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>500 - Server fout | {{ config('app.name', 'Freelance Marketplace') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white min-h-screen flex flex-col">

    <div class="flex-1 flex items-center justify-center px-4">
        <div class="text-center max-w-lg">
            <!-- Animated Icon -->
            <div class="mb-8">
                <div class="relative inline-block">
                    <div class="w-32 h-32 bg-gradient-to-br from-slate-600 to-slate-700 rounded-2xl flex items-center justify-center mx-auto shadow-2xl">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/30">
                        <span class="font-bold text-xl text-slate-900">5</span>
                    </div>
                    <div class="absolute -bottom-2 -left-2 w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/30">
                        <span class="font-bold text-xl text-slate-900">0</span>
                    </div>
                </div>
            </div>

            <!-- Error Title -->
            <h1 class="text-5xl md:text-6xl font-bold mb-4 bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">
                Server Fout
            </h1>

            <!-- Error Message -->
            <p class="text-xl text-slate-300 mb-2">
                Er ging iets mis
            </p>
            <p class="text-slate-400 mb-2">
                Excuses voor het ongemak. Er is een interne fout opgetreden.
            </p>
            @if(config('app.debug'))
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 mb-8 text-left max-w-md mx-auto">
                <p class="text-red-400 font-mono text-sm">{{ $exception->getMessage() ?? 'Database fout' }}</p>
            </div>
            @endif
            <p class="text-slate-500 mb-8">
                Probeer het later opnieuw of neem contact op met de beheerder.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Terug naar home
                </a>
                <a href="javascript:location.reload()" class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-semibold transition-all border border-white/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Pagina herladen
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
