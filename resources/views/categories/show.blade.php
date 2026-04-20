<x-base-layout>
    <div class="container mt-4">
        <h1>{{ $category->name }}</h1>
        <div class="card">
            <div class="card-body">
                <p class="card-text"><strong>Created:</strong> {{ $category->created_at->format('Y-m-d H:i:s') }}</p>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
</x-base-layout>