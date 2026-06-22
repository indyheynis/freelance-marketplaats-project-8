<x-base-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ __('My Favorites') }}</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">{{ __('Commissions you have saved') }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-300">
                {{ $commissions->count() }} {{ __('saved') }}
            </span>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($commissions as $commission)
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow p-6">
                <div class="mb-4 overflow-hidden rounded-3xl border border-slate-200 dark:border-slate-700">
                    <img src="{{ $commission->image_url }}" alt="{{ $commission->title }} image" class="w-full h-40 object-cover">
                </div>
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">{{ $commission->title }}</h3>
                    @if($commission->category)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-300">
                        {{ $commission->category->name }}
                    </span>
                    @endif
                </div>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-2">{{ $commission->description }}</p>
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-slate-500 dark:text-slate-400">Budget:</span>
                        <span class="font-medium text-slate-700 dark:text-slate-200">{{ $commission->budget }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-slate-500 dark:text-slate-400">Deadline:</span>
                        <span class="font-medium text-slate-700 dark:text-slate-200">{{ $commission->deadline }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('commissions.show', $commission) }}" class="flex-1 inline-flex justify-center items-center gap-1 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                        {{ __('View') }}
                    </a>
                    <form action="{{ route('favorites.toggle', $commission) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full inline-flex justify-center items-center gap-1 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            {{ __('Remove') }}
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-700 dark:text-slate-200 mb-1">{{ __('No saved commissions yet') }}</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-4">{{ __('Browse commissions and save the ones that interest you.') }}</p>
                <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    {{ __('Browse Commissions') }}
                </a>
            </div>
            @endforelse
        </div>
    </div>
</x-base-layout>
