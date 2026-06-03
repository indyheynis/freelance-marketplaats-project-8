<x-base-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">{{ __('My Reviews') }}</h1>
                <p class="text-slate-500 text-sm mt-1">{{ __('Reviews that clients have left about you.') }}</p>
            </div>
            @if($reviews->isNotEmpty())
                <div class="flex items-center gap-1.5 bg-amber-50 border border-amber-200 rounded-lg px-4 py-2">
                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                    <span class="font-bold text-slate-800">{{ number_format($reviews->avg('rating'), 1) }}</span>
                    <span class="text-slate-500 text-sm">({{ $reviews->count() }} {{ $reviews->count() === 1 ? 'review' : 'reviews' }})</span>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            @forelse($reviews as $review)
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
                        <div class="text-right">
                            @if($review->commission)
                                <a href="{{ route('commissions.show', $review->commission) }}" class="text-xs text-indigo-600 hover:underline font-medium">
                                    {{ $review->commission->title }}
                                </a>
                            @endif
                            <p class="text-xs text-slate-400 mt-0.5">{{ $review->created_at?->diffForHumans() }}</p>
                        </div>
                    </div>
                    @if($review->comment)
                        <p class="text-sm text-slate-600 mt-2 ml-12">{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <div class="px-6 py-14 text-center">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                    <p class="text-slate-500 text-sm">{{ __('You have not received any reviews yet.') }}</p>
                    <p class="text-slate-400 text-xs mt-1">{{ __('Complete commissions to receive reviews from clients.') }}</p>
                </div>
            @endforelse
        </div>

    </div>
</x-base-layout>
