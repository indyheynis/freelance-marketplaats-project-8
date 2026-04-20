<x-base-layout>
    <div class="container mt-4">
        <h1>Edit Commission</h1>
        <form action="{{ route('commissions.update', $commission) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $commission->title }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $commission->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="budget" class="form-label">Budget</label>
                <input type="number" step="0.01" class="form-control" id="budget" name="budget" value="{{ $commission->budget }}">
            </div>

            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" class="form-control" id="deadline" name="deadline" value="{{ $commission->deadline }}">
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $commission->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('commissions.show', $commission) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-base-layout>