<x-base-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Mijn Sollicitaties</h1>
                <p class="text-slate-500 mt-1">Overzicht van al jouw sollicitaties</p>
            </div>
            <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-md">
                Nieuwe opdracht zoeken
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse($applications as $application)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">{{ $application->commission->title }}</h3>
                            @if($application->commission->category)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mt-1">
                                    {{ $application->commission->category->name }}
                                </span>
                            @endif
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $application->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                            {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            @if($application->status === 'pending') ⏳ In behandeling
                            @elseif($application->status === 'accepted') ✅ Geaccepteerd
                            @elseif($application->status === 'rejected') ❌ Afgewezen
                            @endif
                        </span>
                    </div>

                    <div class="flex items-center gap-4 text-sm text-slate-500 mb-3">
                        <span>Budget: <span class="font-medium text-slate-700">{{ $application->commission->budget }}</span></span>
                        <span>Deadline: <span class="font-medium text-slate-700">{{ $application->commission->deadline }}</span></span>
                        <span>Gesolliciteerd: <span class="font-medium text-slate-700">{{ $application->created_at->diffForHumans() }}</span></span>
                    </div>

                    @if($application->message)
                        <div class="bg-slate-50 rounded-lg p-3 mb-4 text-sm text-slate-600">
                            <span class="font-medium text-slate-700">Jouw bericht:</span> {{ $application->message }}
                        </div>
                    @endif

                    <div class="flex items-center gap-3 pt-3 border-t border-slate-100">
                        <a href="{{ route('commissions.show', $application->commission) }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Bekijk opdracht
                        </a>
                        @if($application->status === 'pending')
                            <form action="{{ route('applications.destroy', $application) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-2 bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Intrekken
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-16">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-700 mb-2">Nog geen sollicitaties</h3>
                    <p class="text-slate-500 mb-6">Ga op zoek naar opdrachten die bij jou passen.</p>
                    <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-md">
                        Bekijk opdrachten
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-base-layout>