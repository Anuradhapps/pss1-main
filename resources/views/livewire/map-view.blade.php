<div id="map" style="height: {{ $height }}; width: {{ $width }}; z-index: 10;"></div>

<script>
    document.addEventListener('livewire:load', function() {
        let map;

        function initMap() {
            const collectors = @json($collectors);

            if (map) {
                map.off();
                map.remove();
            }

            map = L.map('map').setView([7.8731, 80.7718], 8);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            collectors.forEach(c => {
                const lat = parseFloat(c.gps_lati);
                const lng = parseFloat(c.gps_long);

                if (isNaN(lat) || isNaN(lng)) return;

                const userName = c.user?.name ?? 'Unknown';
                const aiRange = c.get_ai_range?.name ?? 'N/A';
                const riceVariety = c.rice_variety ?? 'Not specified'; // corrected field name

                L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup(`
                <div class="text-sm leading-snug">
                    <strong class="text-green-600">${userName}</strong><br>
                    <span class="text-gray-700">AI Range:</span> ${aiRange}<br>
                    <span class="text-gray-700">Rice Variety:</span> ${riceVariety}
                </div>
             `);
            });

            setTimeout(() => map.invalidateSize(), 100);
        }

        initMap();

        Livewire.hook('message.processed', () => {
            initMap();
        });
    });
</script>
