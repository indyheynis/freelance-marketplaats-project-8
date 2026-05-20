<x-base-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Admin Dashboard</h1>
            <p class="text-slate-500 mt-1">Quick access to user, commission, review and category management.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <a href="{{ route('users.index') }}" class="block bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold text-slate-500">Users</span>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-50 text-indigo-600">U</span>
                </div>
                <h2 class="text-xl font-semibold text-slate-900 mb-2">Manage users</h2>
                <p class="text-sm text-slate-500">Edit, delete, and inspect all registered users.</p>
            </a>

            <a href="{{ route('commissions.index') }}" class="block bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold text-slate-500">Commissions</span>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-purple-50 text-purple-600">C</span>
                </div>
                <h2 class="text-xl font-semibold text-slate-900 mb-2">Browse commissions</h2>
                <p class="text-sm text-slate-500">View all commissions and navigate to details.</p>
            </a>

            <a href="{{ route('reviews.index') }}" class="block bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold text-slate-500">Reviews</span>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-amber-50 text-amber-600">R</span>
                </div>
                <h2 class="text-xl font-semibold text-slate-900 mb-2">View reviews</h2>
                <p class="text-sm text-slate-500">Access review summaries and linked commissions.</p>
            </a>

            <a href="{{ route('categories.index') }}" class="block bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-6 text-left">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold text-slate-500">Categories</span>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-100 text-slate-700">K</span>
                </div>
                <h2 class="text-xl font-semibold text-slate-900 mb-2">Manage categories</h2>
                <p class="text-sm text-slate-500">Create and update category options for commissions.</p>
            </a>
        </div>
    </div>
</x-base-layout>