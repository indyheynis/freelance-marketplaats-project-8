<x-base-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('commissions.index') }}"
                class="inline-flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 mb-4 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Commissions
            </a>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Edit Commission</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Update the details for your commission</p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
            <form action="{{ route('commissions.update', $commission) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="mb-4 overflow-hidden rounded-3xl border border-slate-200 dark:border-slate-700">
                    <img src="{{ $commission->image ? asset('storage/' . $commission->image) : asset('images/commission-placeholder.svg') }}"
                        alt="{{ $commission->title }} image"
                        class="w-full h-64 object-cover">
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Title</label>
                    <input type="text"
                        class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all {{ $errors->has('title') ? 'border-red-500' : '' }}"
                        id="title" name="title" value="{{ old('title', $commission->title) }}" required>
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Description</label>
                    <textarea class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all resize-none {{ $errors->has('description') ? 'border-red-500' : '' }}"
                        id="description" name="description" rows="4">{{ old('description', $commission->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="budget" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Budget</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400">€</span>
                            <input type="number" step="0.01"
                                class="w-full pl-8 pr-4 py-2.5 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all {{ $errors->has('budget') ? 'border-red-500' : '' }}"
                                id="budget" name="budget" value="{{ old('budget', $commission->budget) }}">
                        </div>
                        @error('budget')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deadline" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Deadline</label>
                        <input type="date"
                            class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all {{ $errors->has('deadline') ? 'border-red-500' : '' }}"
                            id="deadline" name="deadline" value="{{ old('deadline', $commission->deadline) }}">
                        @error('deadline')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Category</label>
                    <select class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all {{ $errors->has('category_id') ? 'border-red-500' : '' }}"
                        id="category_id" name="category_id" required>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $commission->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Example image</label>
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"
                        class="w-full text-sm text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-300">
                    @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Locatie -->
                <div class="mt-4">
                    <x-input-label for="location_name" :value="__('Locatie (optioneel)')" />
                    <x-text-input id="location_name" class="block mt-1 w-full" type="text" name="location_name"
                        :value="old('location_name', $commission->location_name)" placeholder="Klik op de kaart" readonly />
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $commission->latitude) }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $commission->longitude) }}">
                </div>

                <!-- Kaart -->
                <div class="mt-3">
                    <div id="editMap" style="height: 350px; border-radius: 10px; border: 1px solid #e2e8f0;"></div>
                    <p class="text-xs text-slate-500 mt-1">Klik op de kaart om de locatie te wijzigen</p>
                </div>

                <div class="flex items-center gap-3 pt-4">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Commission
                    </button>
                    <a href="{{ route('commissions.show', $commission) }}"
                        class="inline-flex items-center gap-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 px-5 py-2.5 rounded-lg font-medium transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const existingLat = {
            {
                $commission - > latitude ?? 52.3
            }
        };
        const existingLng = {
            {
                $commission - > longitude ?? 5.3
            }
        };

        const editMap = L.map('editMap').setView([existingLat, existingLng], {
            {
                $commission - > latitude ? 13 : 7
            }
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(editMap);

        let editMarker;

        // Bestaande locatie tonen
        @if($commission - > latitude)
        editMarker = L.marker([{
            {
                $commission - > latitude
            }
        }, {
            {
                $commission - > longitude
            }
        }]).addTo(editMap);
        @endif

        editMap.on('click', async function(e) {
            const {
                lat,
                lng
            } = e.latlng;

            if (editMarker) editMap.removeLayer(editMarker);
            editMarker = L.marker([lat, lng]).addTo(editMap);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
            const data = await res.json();
            document.getElementById('location_name').value = data.display_name ?? `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
        });
    </script>
</x-base-layout>