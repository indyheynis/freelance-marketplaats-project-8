<x-base-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">{{ __('Notifications') }}</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">{{ __('Your recent activity') }}</p>
            </div>
            @if($notifications->where('read_at', null)->count() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="inline-flex items-center gap-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    {{ __('Mark all as read') }}
                </button>
            </form>
            @endif
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <div class="space-y-3">
            @forelse ($notifications as $notification)
            @php $isUnread = is_null($notification->read_at); @endphp
            <div class="bg-white dark:bg-slate-800 rounded-xl border {{ $isUnread ? 'border-indigo-300 dark:border-indigo-600' : 'border-slate-200 dark:border-slate-700' }} shadow-sm p-4 flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $isUnread ? 'bg-indigo-100 dark:bg-indigo-900/50' : 'bg-slate-100 dark:bg-slate-700' }}">
                    <svg class="w-5 h-5 {{ $isUnread ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold {{ $isUnread ? 'text-slate-800 dark:text-slate-100' : 'text-slate-600 dark:text-slate-400' }}">
                        {{ $notification->data['title'] }}
                    </p>
                    <p class="text-sm {{ $isUnread ? 'text-slate-600 dark:text-slate-300' : 'text-slate-500 dark:text-slate-500' }} mt-0.5">
                        {{ $notification->data['body'] }}
                    </p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                @if($isUnread)
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="flex-shrink-0">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center gap-1 text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                        {{ __('Mark read') }}
                    </button>
                </form>
                @endif
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-700 dark:text-slate-200 mb-1">{{ __('No notifications yet') }}</h3>
                <p class="text-slate-500 dark:text-slate-400">{{ __('You will be notified when something happens.') }}</p>
            </div>
            @endforelse
        </div>
    </div>
</x-base-layout>
