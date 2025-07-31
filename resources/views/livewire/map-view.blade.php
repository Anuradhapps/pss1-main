 <div id="map" style="height: 800px; width: 100%;z-index: 10;"></div>
 <script>
     document.addEventListener('livewire:load', function() {
         let map;

         function initMap() {
             // Get full collector data from Livewire
             const collectors = @json($collectors);
             //  if (collectors.filter(c => c.gps_lati && c.gps_long).length === 0) {
             //      alert("No collectors with valid GPS data available.");
             //  }
             if (map) {
                 map.off();
                 map.remove();
             }

             // Initialize map centered on Sri Lanka
             map = L.map('map').setView([7.8731, 80.7718], 8);

             L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                 attribution: '&copy; OpenStreetMap contributors'
             }).addTo(map);

             // 🔄 Extract only needed properties
             collectors.forEach(collector => {
                 const lat = parseFloat(collector.gps_lati);
                 const lng = parseFloat(collector.gps_long);

                 if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
                     console.warn('Collector skipped due to missing GPS:', collector);
                     return;
                 }

                 const userName = collector.user?.name || 'Unknown';
                 const aiRange = collector.get_ai_range?.name || 'N/A';
                 const riceVariety = collector.rice_veriety || 'Not specified';

                 const marker = L.marker([lat, lng]).addTo(map);
                 marker.bindPopup(`
        <div class="text-sm leading-snug">
            <strong class="text-green-600">${userName}</strong><br>
            <span class="text-gray-700">AI Range:</span> ${aiRange}<br>
            <span class="text-gray-700">Rice Variety:</span> ${riceVariety}
        </div>
    `);
             });


             // ✅ Fix rendering bug (some tiles not visible unless resized)
             setTimeout(() => {
                 map.invalidateSize();
             }, 100);
         }

         // First load
         initMap();

         // Re-run map after Livewire update (like region change)
         Livewire.hook('message.processed', () => {
             initMap();
         });
     });
 </script>
