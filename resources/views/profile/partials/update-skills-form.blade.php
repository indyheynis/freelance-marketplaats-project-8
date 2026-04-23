<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Vaardigheden') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Add or remove your skills.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Hidden fields for required validation -->
        <input type="hidden" name="firstname" value="{{ $user->firstname }}">
        <input type="hidden" name="lastname" value="{{ $user->lastname }}">
        <input type="hidden" name="email" value="{{ $user->email }}">

        <div>
            <x-input-label for="skills" :value="__('Skills')" />
            <p class="text-xs text-gray-500 mt-1">{{ __('Enter skills separated by commas') }}</p>
            <textarea id="skills" name="skills" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ implode(', ', $user->skills ?? []) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>