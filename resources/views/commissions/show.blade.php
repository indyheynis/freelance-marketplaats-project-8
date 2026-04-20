<x-base-layout>
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title mb-4">{{ $commission->title }}</h1>
                <p class="card-text">{{ $commission->description }}</p>
                <p class="card-text"><strong>Created at:</strong> {{ $commission->created_at->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </div>
</x-base-layout>