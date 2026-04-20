<x-base-layout>
@foreach ($commissions as $commission)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $commission->title }}</h5>
            <p class="card-text">Description: {{ $commission->description }}</p>
            <p class="card-text">Amount: {{ $commission->amount }}</p>
            <p class="card-text">Status: {{ $commission->status }}</p>
            <p class="card-text">Budget: {{ $commission->budget }}</p>
            <a href="{{ route('commissions.show', $commission->id) }}" class="btn btn-primary">View Details</a>
        </div>
    </div>
@endforeach
</x-base-layout>