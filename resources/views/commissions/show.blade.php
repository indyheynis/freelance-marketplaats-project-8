<x-base-layout>
    <div class="container mt-4">
        <h1>{{ $commission->title }}</h1>
        <div class="card">
            <div class="card-body">
                <p class="card-text"><strong>Category:</strong> {{ $commission->category->name ?? 'N/A' }}</p>
                <p class="card-text"><strong>Description:</strong> {{ $commission->description }}</p>
                <p class="card-text"><strong>Amount:</strong> {{ $commission->amount }}</p>
                <p class="card-text"><strong>Budget:</strong> {{ $commission->budget }}</p>
                <p class="card-text"><strong>Deadline:</strong> {{ $commission->deadline }}</p>
                <a href="{{ route('commissions.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('commissions.edit', $commission) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
</x-base-layout>