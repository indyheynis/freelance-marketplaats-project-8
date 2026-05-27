<x-base-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ __('Commissions') }}</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">{{ __('Browse and manage freelance commissions') }}</p>
            </div>
            @if(auth()->check() && (auth()->user()->role === 'client' || auth()->user()->role === 'admin'))
            <a href="{{ route('commissions.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Create New') }}
            </a>
            @endif
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <form method="GET" action="{{ route('commissions.index') }}" class="flex flex-wrap gap-3 items-center mb-8">
            <div class="relative flex-1 min-w-[200px]">
                <select name="category_id"
                    class="w-full pl-4 pr-10 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer hover:border-slate-400 dark:hover:border-slate-500">
                    <option value="">{{ __('-- All categories --') }}</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 dark:text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <button type="submit"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                {{ __('Filter') }}
            </button>
            @if(request('category_id'))
            <a href="{{ route('commissions.index') }}"
                class="inline-flex items-center gap-2 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ __('Clear filter') }}
            </a>
            @endif
        </form>

        <!-- Cards Grid -->
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
                    @if(auth()->check() && (auth()->user()->role === 'client' || auth()->user()->role === 'admin'))
                    <a href="{{ route('commissions.edit', $commission) }}" class="flex-1 inline-flex justify-center items-center gap-1 bg-amber-100 dark:bg-amber-900/30 hover:bg-amber-200 dark:hover:bg-amber-900/50 text-amber-700 dark:text-amber-300 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                        {{ __('Edit') }}
                    </a>
                    @endif
                    @if(auth()->check() && (auth()->user()->role === 'client' || auth()->user()->role === 'admin'))
                    <form action="{{ route('commissions.destroy', $commission) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center items-center gap-1 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 px-3 py-2 rounded-lg text-sm font-medium transition-colors" onclick="return confirm('{{ __('Are you sure?') }}')">
                            {{ __('Delete') }}
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-700 dark:text-slate-200 mb-1">{{ __('No commissions found') }}</h3>
                @if(auth()->check() && (auth()->user()->role === 'client' || auth()->user()->role === 'admin'))
                <p class="text-slate-500 dark:text-slate-400 mb-4">{{ __('Get started by creating your first commission.') }}</p>
                <a href="{{ route('commissions.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    {{ __('Create One') }}
                </a>
                @endif
            </div>
            @endforelse
        </div>
    </div>
</x-base-layout>