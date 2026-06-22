<x-base-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 mb-4 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                {{ __('Back to Commissions') }}
            </a>
            <div class="mb-5 overflow-hidden rounded-3xl border border-slate-200 dark:border-slate-700">
                <img src="{{ $commission->image_url }}" alt="{{ $commission->title }} image" class="w-full h-64 object-cover">
            </div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ $commission->title }}</h1>
        </div>

        <!-- Commission Details -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden mb-8">
            <!-- Category Badge & Status -->
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                @if($commission->category)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-300">
                    {{ $commission->category->name }}
                </span>
                @endif
                <span class="text-sm text-slate-500 dark:text-slate-400">{{ __('Posted :time', ['time' => $commission->created_at?->diffForHumans() ?? __('Unknown')]) }}</span>
            </div>

            <!-- Description -->
            <div class="px-6 py-6">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-3">{{ __('Description') }}</h2>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">{{ $commission->description }}</p>
            </div>

            <!-- Details Grid -->
            <div class="px-6 py-6 bg-slate-50 dark:bg-slate-900 border-t border-slate-100 dark:border-slate-700">
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Budget') }}</p>
                            <p class="text-xl font-semibold text-slate-800 dark:text-slate-100">{{ $commission->budget }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Deadline') }}</p>
                            <p class="text-xl font-semibold text-slate-800 dark:text-slate-100">{{ $commission->deadline }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions voor client -->
            @auth
            @if(auth()->user()->role === 'client' && auth()->id() === $commission->user_id)
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700 flex items-center gap-3">
                <a href="{{ route('commissions.edit', $commission) }}" class="inline-flex items-center gap-2 bg-amber-100 dark:bg-amber-900/30 hover:bg-amber-200 dark:hover:bg-amber-900/50 text-amber-700 dark:text-amber-300 px-4 py-2 rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Edit') }}
                </a>
                <form action="{{ route('commissions.destroy', $commission) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 px-4 py-2 rounded-lg font-medium transition-colors" onclick="return confirm('{{ __('Are you sure?') }}')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
            @endif

            {{-- Messages link for involved users --}}
            @if(auth()->check() && $commission->isInvolvedUser(auth()->id()))
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('messages.index', $commission) }}" class="inline-flex items-center gap-2 bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    {{ __('Messages') }}
                    @php $msgCount = $commission->messages()->count(); @endphp
                    @if($msgCount > 0)
                    <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold bg-indigo-600 text-white">{{ $msgCount }}</span>
                    @endif
                </a>
            </div>
            @endif

            {{-- Applications section --}}
            @if(auth()->check() && auth()->id() === $commission->user_id)
            <div class="px-6 py-6 border-t border-slate-100 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4">
                    {{ __('Applications (:count)', ['count' => $commission->applications->count()]) }}
                </h2>

                @forelse($commission->applications as $application)
                <div class="bg-slate-50 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 p-4 mb-3">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('freelancers.show', $application->freelancer) }}" class="flex items-center gap-2 group">
                                <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                    <span class="text-purple-700 dark:text-purple-300 font-semibold text-sm">
                                        {{ strtoupper(substr($application->freelancer->firstname, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800 dark:text-slate-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $application->freelancer->firstname }} {{ $application->freelancer->lastname }}</p>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        @php $freelancerRating = $application->freelancer->averageRating(); @endphp
                                        @if($freelancerRating)
                                        <span class="inline-flex items-center gap-0.5 text-xs text-amber-500 font-medium">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                            </svg>
                                            {{ $freelancerRating }}
                                        </span>
                                        @else
                                        <span class="text-xs text-slate-400 dark:text-slate-500">{{ __('No reviews yet') }}</span>
                                        @endif
                                        <span class="text-xs text-slate-300 dark:text-slate-600">·</span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">{{ $application->freelancer->completedCommissionsCount() }} {{ __('Commissions Completed') }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $application->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300' : '' }}
                                        {{ $application->status === 'accepted' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' : '' }}
                                        {{ $application->status === 'rejected' ? 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300' : '' }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                    @if($application->message)
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">{{ $application->message }}</p>
                    @endif

                    @if($application->status === 'pending')
                    <div class="flex gap-2 mt-3">
                        <form action="{{ route('applications.accept', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-1 bg-green-100 dark:bg-green-900/30 hover:bg-green-200 dark:hover:bg-green-900/50 text-green-700 dark:text-green-300 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Accept') }}
                            </button>
                        </form>
                        <form action="{{ route('applications.reject', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-1 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ __('Reject') }}
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                @empty
                <p class="text-slate-500 dark:text-slate-400 text-sm">{{ __('No applications received yet.') }}</p>
                @endforelse
            </div>
            @endif

            {{-- Reviews sectie --}}
            @php
            $hasAcceptedApplication = $commission->applications->where('status', 'accepted')->isNotEmpty();
            $alreadyReviewed = $commission->reviews->where('reviewer_id', auth()->id())->isNotEmpty();
            @endphp

            @if($commission->reviews->isNotEmpty())
            <div class="px-6 py-6 border-t border-slate-100 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4">
                    {{ __('Reviews (:count)', ['count' => $commission->reviews->count()]) }}
                </h2>
                @foreach($commission->reviews as $review)
                <div class="bg-slate-50 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 p-4 mb-3">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                            <span class="text-indigo-700 dark:text-indigo-300 font-semibold text-sm">
                                {{ strtoupper(substr($review->reviewer->firstname, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800 dark:text-slate-100 text-sm">{{ $review->reviewer->firstname }} {{ $review->reviewer->lastname }}</p>
                            <div class="flex gap-0.5 mt-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-300 dark:text-slate-600' }}" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                    @endfor
                            </div>
                        </div>
                        <span class="ml-auto text-xs text-slate-400 dark:text-slate-500">{{ $review->created_at?->diffForHumans() }}</span>
                    </div>
                    @if($review->comment)
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">{{ $review->comment }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            @if($hasAcceptedApplication && !$alreadyReviewed)
            <div class="px-6 py-6 border-t border-slate-100 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-1">{{ __('Leave a Review') }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-5">{{ __('How was your experience with the freelancer?') }}</p>

                @if(session('review_success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg">
                    {{ session('review_success') }}
                </div>
                @endif

                @if($errors->has('rating') || $errors->has('comment'))
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 rounded-lg text-sm">
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form action="{{ route('reviews.store', $commission) }}" method="POST"
                    x-data="{
                                    rating: 0,
                                    hovered: 0,
                                    wordCount: 0,
                                    updateCount(val) { this.wordCount = val.trim() === '' ? 0 : val.trim().split(/\s+/).length; }
                                }">
                    @csrf

                    <div class="flex gap-1 mb-5">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                            @click="rating = {{ $i }}"
                            @mouseenter="hovered = {{ $i }}"
                            @mouseleave="hovered = 0"
                            class="focus:outline-none transition-transform hover:scale-110">
                            <svg class="w-9 h-9 transition-colors"
                                :class="{{ $i }} <= (hovered || rating) ? 'text-amber-400' : 'text-slate-300 dark:text-slate-600'"
                                :fill="{{ $i }} <= (hovered || rating) ? 'currentColor' : 'none'"
                                stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                            </button>
                            @endfor
                    </div>
                    <input type="hidden" name="rating" :value="rating">

                    <div class="mb-4">
                        <textarea
                            name="comment"
                            rows="4"
                            placeholder="{{ __('Tell us about your experience with this freelancer... (optional)') }}"
                            @input="updateCount($event.target.value)"
                            class="w-full border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"></textarea>
                        <div class="flex justify-end mt-1">
                            <span class="text-xs" :class="wordCount > 200 ? 'text-red-500 font-medium' : 'text-slate-400 dark:text-slate-500'">
                                <span x-text="wordCount"></span>{{ __('/200 words') }}
                            </span>
                        </div>
                    </div>

                    <button type="submit"
                        :disabled="rating === 0 || wordCount > 200"
                        :class="rating === 0 || wordCount > 200 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-indigo-700'"
                        class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ __('Post Review') }}
                    </button>
                </form>
            </div>
            @endif
            @endauth {{-- This closes the @auth block --}}

        </div>

        {{-- Offers Section --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100">{{ __('Offers') }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __('View all received offers for this commission') }}</p>
            </div>
            <div class="p-6">
                @forelse($commission->offers as $offer)
                <div class="bg-slate-50 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 p-4 mb-4 last:mb-0">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                <span class="text-indigo-700 dark:text-indigo-300 font-semibold text-sm">
                                    {{ strtoupper(substr($offer->user->firstname ?? $offer->user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-slate-800 dark:text-slate-100">{{ $offer->user->firstname ?? $offer->user->name }} {{ $offer->user->lastname ?? '' }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $offer->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">€{{ number_format($offer->price, 2) }}</p>
                        </div>
                    </div>
                    @if($offer->message)
                    <div class="mt-3 pt-3 border-t border-slate-200 dark:border-slate-700">
                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ $offer->message }}</p>
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400">{{ __('No offers received yet') }}</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Freelancer: Application form --}}
        @auth
        @if(auth()->user()->isFreelancer())
        @php
        $alreadyApplied = $commission->applications->where('user_id', auth()->id())->first();
        $isFavorite = auth()->user()->favorites()->where('commission_id', $commission->id)->exists();
        @endphp

        <div class="mb-4 flex justify-end">
            <form action="{{ route('favorites.toggle', $commission) }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors
            {{ $isFavorite
                ? 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50'
                : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-600' }}">
                    <svg class="w-4 h-4" fill="{{ $isFavorite ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    {{ $isFavorite ? __('Saved as Favorite') : __('Save as Favorite') }}
                </button>
            </form>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100">{{ __('Apply') }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __("Tell us why you're the perfect candidate") }}</p>
            </div>

            <div class="p-6">
                @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 rounded-lg">
                    {{ session('error') }}
                </div>
                @endif

                @if($alreadyApplied)
                <div class="p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="font-medium">{{ __('You have already applied for this commission') }}</span>
                    </div>
                    @if($alreadyApplied->message)
                    <p class="mt-2 text-sm text-green-700 dark:text-green-300">{{ __('Your message:') }} "{{ $alreadyApplied->message }}"</p>
                    @endif
                </div>
                <form action="{{ route('applications.destroy', $alreadyApplied) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center gap-3">
                        <button type="submit" class="inline-flex items-center gap-2 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('Withdraw Application') }}
                        </button>
                        <a href="{{ route('commissions.pdf', $commission) }}" class="inline-flex items-center gap-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {{ __('Download as PDF') }}
                        </a>
                    </div>
                </form>
                @else
                <form action="{{ route('applications.store', $commission) }}" method="POST">
                    @csrf
                    <textarea name="message" rows="4" placeholder="{{ __('Tell us why you are a great fit for this commission...') }}"
                        class="w-full border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 rounded-lg px-4 py-3 text-sm mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                    <div class="flex items-center gap-3">
                        <button type="submit" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            {{ __('Apply') }}
                        </button>
                        <a href="{{ route('commissions.pdf', $commission) }}" class="inline-flex items-center gap-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {{ __('Download as PDF') }}
                        </a>
                    </div>
                </form>
                @endif
            </div>
        </div>
        @endif
        @endauth

        @guest
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="p-4 bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg">
                    <p class="font-medium mb-2">{{ __('Interested in this commission?') }}</p>
                    <p class="text-sm mb-4">{{ __('Log in or register to apply.') }}</p>
                    <div class="flex gap-3">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                            {{ __('Log in') }}
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-600 px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                            {{ __('Register') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endguest
    </div>
</x-base-layout>