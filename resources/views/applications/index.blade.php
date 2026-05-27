<x-base-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ __('My Applications') }}</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">{{ __('Overview of all your applications') }}</p>
            </div>
            <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-md">
                {{ __('Find New Commission') }}
            </a>
        </div>

        <!-- Filter -->
        <div class="mb-6">
            <form method="GET" action="{{ route('applications.index') }}" class="flex items-center gap-3">
                <select name="status" onchange="this.form.submit()"
                    class="border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-slate-800">
                    <option value="">{{ __('All applications') }}</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('⏳ Pending') }}</option>
                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>{{ __('✅ Accepted') }}</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>{{ __('❌ Rejected') }}</option>
                </select>
                @if(request('status'))
                <a href="{{ route('applications.index') }}" class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
                    {{ __('Clear filter') }}
                </a>
                @endif
            </form>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <div class="space-y-4">
            @forelse($applications as $application)
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">{{ $application->commission->title }}</h3>
                        @if($application->commission->category)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-300 mt-1">
                                {{ $application->commission->category->name }}
                            </span>
                        @endif
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $application->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300' : '' }}
                        {{ $application->status === 'accepted' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' : '' }}
                        {{ $application->status === 'rejected' ? 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300' : '' }}">
                        @if($application->status === 'pending') {{ __('⏳ Pending') }}
                        @elseif($application->status === 'accepted') {{ __('✅ Accepted') }}
                        @elseif($application->status === 'rejected') {{ __('❌ Rejected') }}
                        @endif
                    </span>
                </div>

                <div class="flex items-center gap-4 text-sm text-slate-500 dark:text-slate-400 mb-3">
                    <span>Budget: <span class="font-medium text-slate-700 dark:text-slate-200">{{ $application->commission->budget }}</span></span>
                    <span>Deadline: <span class="font-medium text-slate-700 dark:text-slate-200">{{ $application->commission->deadline }}</span></span>
                    <span>{{ __('Applied:') }} <span class="font-medium text-slate-700 dark:text-slate-200">{{ $application->created_at?->diffForHumans() ?? __('Unknown') }}</span></span>
                </div>

                @if($application->message)
                    <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-3 mb-4 text-sm text-slate-600 dark:text-slate-400">
                        <span class="font-medium text-slate-700 dark:text-slate-200">{{ __('Your message:') }}</span> {{ $application->message }}
                    </div>
                @endif

                <div class="flex items-center gap-3 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('commissions.show', $application->commission) }}" class="inline-flex items-center gap-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        {{ __('View Commission') }}
                    </a>
                    @if($application->status === 'pending')
                        <form action="{{ route('applications.destroy', $application) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-2 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                {{ __('Withdraw') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-16">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-700 dark:text-slate-200 mb-2">{{ __('No applications yet') }}</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6">{{ __('Search for commissions that match your profile.') }}</p>
                <a href="{{ route('commissions.index') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-md">
                    {{ __('View Commissions') }}
                </a>
            </div>
            @endforelse
        </div>
    </div>
</x-base-layout>