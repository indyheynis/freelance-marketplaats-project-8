<x-base-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Commissions</h1>
                <p class="text-slate-500 mt-1">Browse and manage freelance commissions</p>
            </div>
           @if(auth()->check() && auth()->user()->role === 'client')       
            <a href="{{ route('commissions.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create New
            </a>
            @endif
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

                <form method="GET" action="{{ route('commissions.index') }}" class="flex flex-wrap gap-3 items-center mb-8">
            <div class="relative flex-1 min-w-[200px]">
                <select name="category_id"
                    class="w-full pl-4 pr-10 py-2.5 border border-slate-300 rounded-lg bg-white text-slate-700 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer hover:border-slate-400">
                    <option value="">-- Alle categorieën --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <button type="submit"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter
            </button>
            @if(request('category_id'))
                <a href="{{ route('commissions.index') }}"
                    class="inline-flex items-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Wis filter
                </a>
            @endif
        </form>

        <!-- Cards Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($commissions as $commission)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold text-slate-800">{{ $commission->title }}</h3>
                        @if($commission->category)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $commission->category->name }}
                            </span>
                        @endif
                    </div>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-2">{{ $commission->description }}</p>
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-slate-500">Budget:</span>
                            <span class="font-medium text-slate-700">{{ $commission->budget }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-slate-500">Deadline:</span>
                            <span class="font-medium text-slate-700">{{ $commission->deadline }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                        <a href="{{ route('commissions.show', $commission) }}" class="flex-1 inline-flex justify-center items-center gap-1 bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            View
                        </a>
                          @if(auth()->check() && auth()->user()->role === 'client')    
                        <a href="{{ route('commissions.edit', $commission) }}" class="flex-1 inline-flex justify-center items-center gap-1 bg-amber-100 hover:bg-amber-200 text-amber-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            Edit
                        </a>
                        @endif
                          @if(auth()->check() && auth()->user()->role === 'client')    
                        <form action="{{ route('commissions.destroy', $commission) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center items-center gap-1 bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                            @endif
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-700 mb-1">No commissions found</h3>
                    @if(auth()->check() && auth()->user()->role === 'client')                        
                    <p class="text-slate-500 mb-4">Get started by creating your first commission.</p>
                    <a href="{{ route('commissions.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Create One
                    </a>
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</x-base-layout>