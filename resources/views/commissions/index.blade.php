<x-base-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Commissions</h1>
            <a href="{{ route('commissions.create') }}" class="btn btn-success">Create New</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @forelse ($commissions as $commission)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $commission->title }}</h5>
                    <p class="card-text"><strong>Category:</strong> {{ $commission->category->name ?? 'N/A' }}</p>
                    <p class="card-text"><strong>Description:</strong> {{ $commission->description }}</p>
                    <p class="card-text"><strong>Budget:</strong> {{ $commission->budget }}</p>
                    <p class="card-text"><strong>Deadline:</strong> {{ $commission->deadline }}</p>
                    <a href="{{ route('commissions.show', $commission) }}" class="btn btn-primary">View</a>
                    <a href="{{ route('commissions.edit', $commission) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('commissions.destroy', $commission) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p>No commissions found.</p>
        @endforelse
    </div>
</x-base-layout>