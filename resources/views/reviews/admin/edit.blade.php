<x-base-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="{{ route('admin.reviews.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                {{ __('All Reviews') }}
            </a>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ __('Edit Review') }}</h1>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 mb-6">
            <dl class="space-y-2 text-sm">
                <div class="flex gap-2">
                    <dt class="text-slate-500 dark:text-slate-400 w-28 shrink-0">{{ __('Reviewer') }}</dt>
                    <dd class="text-slate-800 dark:text-slate-200 font-medium">{{ $review->reviewer?->firstname }} {{ $review->reviewer?->lastname }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="text-slate-500 dark:text-slate-400 w-28 shrink-0">{{ __('Freelancer') }}</dt>
                    <dd class="text-slate-800 dark:text-slate-200 font-medium">{{ $review->reviewee?->firstname }} {{ $review->reviewee?->lastname }}</dd>
                </div>
                @if($review->commission)
                <div class="flex gap-2">
                    <dt class="text-slate-500 dark:text-slate-400 w-28 shrink-0">{{ __('Commission') }}</dt>
                    <dd class="text-indigo-600 dark:text-indigo-400">
                        <a href="{{ route('commissions.show', $review->commission) }}" class="hover:underline">{{ $review->commission->title }}</a>
                    </dd>
                </div>
                @endif
            </dl>
        </div>

        <form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('Rating') }}</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer">
                        <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" {{ old('rating', $review->rating) == $i ? 'checked' : '' }}>
                        <svg class="w-8 h-8 text-slate-300 dark:text-slate-600 peer-checked:text-amber-400 hover:text-amber-300 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                        </svg>
                    </label>
                    @endfor
                </div>
                @error('rating')<p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="comment" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('Comment') }}</label>
                <textarea
                    id="comment"
                    name="comment"
                    rows="4"
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                >{{ old('comment', $review->comment) }}</textarea>
                @error('comment')<p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">{{ __('Cancel') }}</a>
                <button type="submit" class="px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 hover:bg-indigo-700 text-white transition-colors">{{ __('Save') }}</button>
            </div>
        </form>

    </div>
</x-base-layout>
