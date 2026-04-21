<x-base-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Commissions</h1>
                <p class="text-slate-500 mt-1">Browse and manage freelance commissions</p>
            </div>
            @auth
                @if (auth()->user()->role === 'client')
                    <a href="{{ route('commissions.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create New
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-md">
                    Login to Create
                </a>
            @endauth
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

                <form method="GET" action="{{ route('commissions.index') }}">
            <select name="category_id">
                <option value="">-- Kies categorie --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Filter</button>
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
                        @auth
                            @if (auth()->user()->role === 'client')
                                <a href="{{ route('commissions.edit', $commission) }}" class="flex-1 inline-flex justify-center items-center gap-1 bg-amber-100 hover:bg-amber-200 text-amber-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('commissions.destroy', $commission) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center items-center gap-1 bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        @endauth
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
                    <p class="text-slate-500 mb-4">Get started by creating your first commission.</p>
                    @auth
                        @if (auth()->user()->role === 'client')
                            <a href="{{ route('commissions.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Create One
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Login to Create
                        </a>
                    @endauth
                </div>
            @endforelse
        </div>
    </div>
</x-base-layout>