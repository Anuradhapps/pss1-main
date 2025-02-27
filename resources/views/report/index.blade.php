<x-app-layout>
    <div
        class="flex flex-col items-start justify-between p-3 mb-2 space-y-4 rounded-md shadow-md bg-gradient-to-r from-gray-900 to-gray-600 md:flex-row md:items-center md:space-y-0">
        <h1 class="text-2xl font-bold text-white">Report</h1>
    </div>


    <div class="grid-cols-2 gap-4 sm:grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
        <div class="p-3 mb-1 bg-gray-500 rounded shadow-xl dark:bg-gray-900">
            <h5 class="mb-3 text-xl font-bold text-orange-100 dark:text-orange-600">All Data</h5>
            <x-form id="export-form" action="{{ route('export.users') }}" method="post">

                @csrf
                <x-form.input type="date" name="start_date" label="Start Date:" />
                <x-form.input type="date" name="end_date" label="End Date:" />
                <button type="submit"
                    class="h-8 px-2 py-1 text-xs font-bold text-white bg-red-800 rounded hover:bg-red-900">
                    Download
                </button>
            </x-form>
        </div>

        <div class="flex flex-wrap gap-3 p-3 mb-1 bg-gray-500 rounded shadow-xl dark:bg-gray-900">
            <h5 class="mb-3 text-xl font-bold text-orange-100 dark:text-orange-600">Memo - last 2 weeks</h5>
            <div class= "flex flex-wrap gap-3">
                @foreach ($provinces as $province)
                    @if (in_array($province->id, $dataHaveProvinces))
                        <a href="{{ route('export.pdf', ['id' => $province->id]) }}"
                            class="h-8 px-2 py-2 text-xs font-bold text-white bg-blue-800 rounded-xl hover:bg-blue-900">{{ $province->name }}</a>
                    @else
                        <a href="{{ route('export.pdf', ['id' => $province->id]) }}"
                            class="h-8 px-2 py-2 text-xs font-bold text-white bg-red-800 cursor-not-allowed pointer-events-none opacity-80 rounded-xl hover:bg-red-900">{{ $province->name }}</a>
                    @endif
                @endforeach
            </div>


        </div>
    </div>

    <script>
        document.getElementById('export-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent form from submitting normally

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
