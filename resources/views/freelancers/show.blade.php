<x-base-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="mb-8">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-6 flex items-center gap-5">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-purple-700 font-bold text-2xl">
                            {{ strtoupper(substr($freelancer->firstname, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">
                            {{ $freelancer->firstname }} {{ $freelancer->lastname }}
                        </h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700 mt-1">
                            Freelancer
                        </span>
                        @if($freelancer->skills)
                            <div class="flex flex-wrap gap-1.5 mt-2">
                                @foreach($freelancer->skills as $skill)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-600">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Statistieken --}}
                <div class="border-t border-slate-100 grid grid-cols-3 divide-x divide-slate-100">
                    <div class="px-6 py-4 text-center">
                        <p class="text-2xl font-bold text-slate-800">{{ $completedCommissions }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">Opdrachten gedaan</p>
                    </div>
                    <div class="px-6 py-4 text-center">
                        @if($averageRating)
                            <div class="flex items-center justify-center gap-1">
                                <p class="text-2xl font-bold text-slate-800">{{ number_format($averageRating, 1) }}</p>
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Gemiddelde rating ({{ $freelancer->receivedReviews->count() }} {{ $freelancer->receivedReviews->count() === 1 ? 'review' : 'reviews' }})</p>
                        @else
                            <p class="text-2xl font-bold text-slate-400">—</p>
                            <p class="text-xs text-slate-500 mt-0.5">Nog geen reviews</p>
                        @endif
                    </div>
                    <div class="px-6 py-4 text-center">
                        @if($averageDuration)
                            <p class="text-2xl font-bold text-slate-800">{{ $averageDuration }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">Gem. duur (dagen)</p>
                        @else
                            <p class="text-2xl font-bold text-slate-400">—</p>
                            <p class="text-xs text-slate-500 mt-0.5">Gem. duur (dagen)</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Reviews --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800">
                    Reviews ({{ $freelancer->receivedReviews->count() }})
                </h2>
            </div>

            @forelse($freelancer->receivedReviews as $review)
                <div class="px-6 py-5 border-b border-slate-100 last:border-0">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-indigo-700 font-semibold text-sm">
                                    {{ strtoupper(substr($review->reviewer->firstname, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-slate-800 text-sm">
                                    {{ $review->reviewer->firstname }} {{ $review->reviewer->lastname }}
                                </p>
                                <div class="flex gap-0.5 mt-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-300' }}"
                                            fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}"
                                            stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400">{{ $review->created_at?->diffForHumans() }}</span>
                    </div>
                    @if($review->comment)
                        <p class="text-sm text-slate-600 mt-2 ml-12">{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <div class="px-6 py-10 text-center">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                    <p class="text-slate-500 text-sm">Deze freelancer heeft nog geen reviews ontvangen.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-base-layout>
