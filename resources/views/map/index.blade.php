<x-base-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-800">Opdrachten op de kaart</h1>
            <p class="text-slate-500 mt-1">Bekijk alle opdrachten bij jou in de buurt</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div id="map" style="height: 600px;"></div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([52.3, 5.3], 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const commissions = @json($commissions);

        commissions.forEach(c => {
            if (!c.latitude || !c.longitude) return;

            const marker = L.marker([c.latitude, c.longitude]).addTo(map);
            marker.bindPopup(`
                <div style="min-width:200px">
                    <strong style="font-size:14px">${c.title}</strong>
                    ${c.category ? `<br><span style="font-size:12px;color:#6366f1">${c.category.name}</span>` : ''}
                    <br><span style="font-size:12px;color:#64748b">📍 ${c.location_name ?? ''}</span>
                    <br><span style="font-size:12px;color:#64748b">💰 ${c.budget ?? 'N/A'}</span>
                    <br><a href="/commissions/${c.id}" style="font-size:12px;color:#6366f1;font-weight:600">Bekijk opdracht →</a>
                </div>
            `);
        });
    </script>
</x-base-layout>