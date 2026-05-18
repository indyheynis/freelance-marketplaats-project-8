<x-base-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-4 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Commissions
            </a>
            @if($commission->image)
            <div class="mb-5 overflow-hidden rounded-3xl border border-slate-200">
                <img src="{{ asset('storage/' . $commission->image) }}" alt="Commission image" class="w-full h-64 object-cover">
            </div>
            @endif
            <h1 class="text-3xl font-bold text-slate-800">{{ $commission->title }}</h1>
        </div>

        <!-- Commission Details -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <!-- Category Badge & Status -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                @if($commission->category)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    {{ $commission->category->name }}
                </span>
                @endif
                <span class="text-sm text-slate-500">Posted {{ $commission->created_at?->diffForHumans() ?? 'Onbekend' }}</span>
            </div>

            <!-- Description -->
            <div class="px-6 py-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-3">Description</h2>
                <p class="text-slate-600 leading-relaxed">{{ $commission->description }}</p>
            </div>

            <!-- Details Grid -->
            <div class="px-6 py-6 bg-slate-50 border-t border-slate-100">
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Budget</p>
                            <p class="text-xl font-semibold text-slate-800">{{ $commission->budget }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Deadline</p>
                            <p class="text-xl font-semibold text-slate-800">{{ $commission->deadline }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions voor client -->
            @auth
            @if(auth()->user()->role === 'client')
            <div class="px-6 py-4 border-t border-slate-100 flex items-center gap-3">
                <a href="{{ route('commissions.edit', $commission) }}" class="inline-flex items-center gap-2 bg-amber-100 hover:bg-amber-200 text-amber-700 px-4 py-2 rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form action="{{ route('commissions.destroy', $commission) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg font-medium transition-colors" onclick="return confirm('Are you sure?')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>

            {{-- Sollicitaties sectie --}}
            <div class="px-6 py-6 border-t border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    Sollicitaties ({{ $commission->applications->count() }})
                </h2>

                @forelse($commission->applications as $application)
                <div class="bg-slate-50 rounded-lg border border-slate-200 p-4 mb-3">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('freelancers.show', $application->freelancer) }}" class="flex items-center gap-2 group">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <span class="text-purple-700 font-semibold text-sm">
                                        {{ strtoupper(substr($application->freelancer->firstname, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $application->freelancer->firstname }} {{ $application->freelancer->lastname }}</p>
                                    <p class="text-xs text-slate-500">{{ $application->created_at?->diffForHumans() ?? 'Onbekend' }}</p>
                                </div>
                            </a>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $application->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                    @if($application->message)
                    <p class="text-sm text-slate-600 mt-2">{{ $application->message }}</p>
                    @endif

                    @if($application->status === 'pending')
                    <div class="flex gap-2 mt-3">
                        <form action="{{ route('applications.accept', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-1 bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Accepteren
                            </button>
                        </form>
                        <form action="{{ route('applications.reject', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Afwijzen
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                @empty
                <p class="text-slate-500 text-sm">Nog geen sollicitaties ontvangen.</p>
                @endforelse
            </div>

            {{-- Reviews sectie --}}
            @php
            $hasAcceptedApplication = $commission->applications->where('status', 'accepted')->isNotEmpty();
            $alreadyReviewed = $commission->reviews->where('reviewer_id', auth()->id())->isNotEmpty();
            @endphp

            @if($commission->reviews->isNotEmpty())
            <div class="px-6 py-6 border-t border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    Reviews ({{ $commission->reviews->count() }})
                </h2>
                @foreach($commission->reviews as $review)
                <div class="bg-slate-50 rounded-lg border border-slate-200 p-4 mb-3">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-indigo-700 font-semibold text-sm">
                                {{ strtoupper(substr($review->reviewer->firstname, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800 text-sm">{{ $review->reviewer->firstname }} {{ $review->reviewer->lastname }}</p>
                            <div class="flex gap-0.5 mt-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-300' }}" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                    @endfor
                            </div>
                        </div>
                        <span class="ml-auto text-xs text-slate-400">{{ $review->created_at?->diffForHumans() }}</span>
                    </div>
                    @if($review->comment)
                    <p class="text-sm text-slate-600 mt-2">{{ $review->comment }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            @if($hasAcceptedApplication && !$alreadyReviewed)
            <div class="px-6 py-6 border-t border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800 mb-1">Review achterlaten</h2>
                <p class="text-sm text-slate-500 mb-5">Hoe was jouw ervaring met de freelancer?</p>

                @if(session('review_success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                    {{ session('review_success') }}
                </div>
                @endif

                @if($errors->has('rating') || $errors->has('comment'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
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

                                {{-- Sterren --}}
                                <div class="flex gap-1 mb-5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                            @click="rating = {{ $i }}"
                                            @mouseenter="hovered = {{ $i }}"
                                            @mouseleave="hovered = 0"
                                            class="focus:outline-none transition-transform hover:scale-110">
                                            <svg class="w-9 h-9 transition-colors"
                                                :class="{{ $i }} <= (hovered || rating) ? 'text-amber-400' : 'text-slate-300'"
                                                :fill="{{ $i }} <= (hovered || rating) ? 'currentColor' : 'none'"
                                                stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" :value="rating">

                                {{-- Commentaar --}}
                                <div class="mb-4">
                                    <textarea
                                        name="comment"
                                        rows="4"
                                        placeholder="Vertel over jouw ervaring met deze freelancer... (optioneel)"
                                        @input="updateCount($event.target.value)"
                                        class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"></textarea>
                                    <div class="flex justify-end mt-1">
                                        <span class="text-xs" :class="wordCount > 200 ? 'text-red-500 font-medium' : 'text-slate-400'">
                                            <span x-text="wordCount"></span>/200 woorden
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
                                    Review plaatsen
                                </button>
                            </form>
                        </div>
                    @endif
                @endif
            @endauth
        </div>

        {{-- Offertes Sectie --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-xl font-semibold text-slate-800">Offertes</h2>
                <p class="text-sm text-slate-500 mt-1">Bekijk alle ontvangen offertes voor deze opdracht</p>
            </div>
            <div class="p-6">
                @forelse($commission->offers as $offer)
                <div class="bg-slate-50 rounded-lg border border-slate-200 p-4 mb-4 last:mb-0">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-700 font-semibold text-sm">
                                    {{ strtoupper(substr($offer->user->firstname ?? $offer->user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-slate-800">{{ $offer->user->firstname ?? $offer->user->name }} {{ $offer->user->lastname ?? '' }}</p>
                                <p class="text-xs text-slate-500">{{ $offer->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-green-600">€{{ number_format($offer->price, 2) }}</p>
                        </div>
                    </div>
                    @if($offer->message)
                    <div class="mt-3 pt-3 border-t border-slate-200">
                        <p class="text-sm text-slate-600">{{ $offer->message }}</p>
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-slate-500">Nog geen offertes ontvangen</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Freelancer: Sollicitatie formulier --}}
        @auth
        @if(auth()->user()->isFreelancer())
        @php
        $alreadyApplied = $commission->applications->where('user_id', auth()->id())->first();
        @endphp

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="text-xl font-semibold text-slate-800">Solliciteren</h2>
                        <p class="text-sm text-slate-500 mt-1">Vertel waarom jij de perfecte kandidaat bent</p>
                    </div>

                    <div class="p-6">
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($alreadyApplied)
                            <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg mb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="font-medium">Je hebt al gesolliciteerd op deze opdracht</span>
                                </div>
                                @if($alreadyApplied->message)
                                    <p class="mt-2 text-sm text-green-700">Jouw bericht: "{{ $alreadyApplied->message }}"</p>
                                @endif
                            </div>
                            <form action="{{ route('applications.destroy', $alreadyApplied) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-2 bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Sollicitatie intrekken
                                </button>
                            </form>
                        @else
                            <form action="{{ route('applications.store', $commission) }}" method="POST">
                                @csrf
                                <textarea name="message" rows="4" placeholder="Vertel waarom jij geschikt bent voor deze opdracht..."
                                    class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                                <button type="submit" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Solliciteren
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        @endauth

        {{-- Niet ingelogd --}}
        @guest
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="p-4 bg-slate-100 border border-slate-200 text-slate-700 rounded-lg">
                    <p class="font-medium mb-2">Geïnteresseerd in deze opdracht?</p>
                    <p class="text-sm mb-4">Log in of registreer om te solliciteren.</p>
                    <div class="flex gap-3">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                            Registreer
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endguest
    </div>
</x-base-layout>