<x-base-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Profile</h1>
                <p class="text-slate-500 mt-1">Manage your account details, password, skills, and profile settings.</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-skills-form')
                </div>
            </div>

            <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-base-layout>