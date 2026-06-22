<x-base-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="{{ route('commissions.show', $commission) }}" class="inline-flex items-center gap-1 text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                {{ __('Back to commission') }}
            </a>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ __('Messages') }}</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-0.5">{{ $commission->title }}</p>
        </div>

        @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 rounded-lg text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        {{-- Message thread --}}
        <div class="space-y-4 mb-6">
            @forelse($messages as $message)
            @php $isMine = $message->sender_id === auth()->id(); @endphp
            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%]">
                    @unless($isMine)
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mb-1 px-1">
                        {{ $message->sender->firstname }} {{ $message->sender->lastname }}
                    </p>
                    @endunless
                    <div class="px-4 py-2.5 rounded-2xl text-sm leading-relaxed
                        {{ $isMine
                            ? 'bg-indigo-600 text-white rounded-br-sm'
                            : 'bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-bl-sm' }}">
                        {{ $message->body }}
                    </div>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 px-1 {{ $isMine ? 'text-right' : '' }}">
                        {{ $message->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <div class="w-14 h-14 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <p class="text-slate-500 dark:text-slate-400 text-sm">{{ __('No messages yet. Start the conversation!') }}</p>
            </div>
            @endforelse
        </div>

        {{-- Send form --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-4">
            <form action="{{ route('messages.store', $commission) }}" method="POST">
                @csrf
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('Send a message') }}</label>
                <textarea
                    name="body"
                    rows="3"
                    placeholder="{{ __('Write your message...') }}"
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-3 py-2 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                >{{ old('body') }}</textarea>
                <div class="flex justify-end mt-3">
                    <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        {{ __('Send') }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-base-layout>
