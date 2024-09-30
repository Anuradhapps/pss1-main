<x-app-layout>
    <div class="flex justify-between border-b border-gray-200 py-1 mb-5">
        <h1 class="text-2xl font-bold text-gray-300">Report</h1>
    </div>
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
        <x-form id="export-form" action="{{ route('export.users') }}" method="post">
            @csrf
            <x-form.input type="date" name="start_date" label="Start Date:" />
            <x-form.input type="date" name="end_date" label="End Date:" />
            <button type="submit" class="bg-red-800 text-white font-bold py-1 px-2 rounded hover:bg-red-900 text-xs h-8">
                Download
            </button>
        </x-form>
        
    </div>
    <script>
        document.getElementById('export-form').addEventListener('submit', function(e) {
            e.preventDefault();  // Prevent form from submitting normally
    
            // Perform the AJAX request to trigger the download
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.blob())
            .then(blob => {
                // Create a link to download the file
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'users.xlsx';
                link.click();
    
                // Redirect after the download
                window.location.href = "{{ route('report.index') }}";
            });
        });
    </script>
</x-app-layout>