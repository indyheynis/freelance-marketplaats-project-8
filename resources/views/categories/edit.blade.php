<x-base-layout>
    <div class="container mt-4">
        <h1>Edit Category</h1>
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('categories.show', $category) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-base-layout>