<x-app-layout>
    <div class="space-y-3 ">
        {{-- Header --}}
        <div
            class="flex flex-col items-start justify-between p-4 space-y-4 rounded-md shadow-lg bg-gradient-to-r from-gray-900 to-gray-700 md:flex-row md:items-center md:space-y-0">
            <h1 class="text-2xl font-bold tracking-tight text-white">📊 Report Dashboard</h1>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">

            {{-- All Data Card --}}
            <div class="p-3 bg-gray-900 shadow-lg rounded-xl">
                <h5 class="mb-4 text-xl font-bold text-orange-500">📁 All Data Export</h5>
                <x-form class="space-y-3" id="export-form" action="{{ route('export.allpestdata') }}" method="post">
                    @csrf
                    <x-form.input type="date" name="start_date" label="Start Date" />
                    <x-form.input type="date" name="end_date" label="End Date" />
                    <button type="submit"
                        class="w-full px-4 py-2 mt-3 text-sm font-bold text-white transition bg-red-700 rounded hover:bg-red-800">
                        ⬇️ Download Excel
                    </button>
                </x-form>
            </div>

            {{-- Memo Last 2 Weeks --}}
            <div class="p-3 bg-gray-900 shadow-lg rounded-xl">
                <h5 class="mb-4 text-xl font-bold text-orange-500">🕒 Last 2 Weeks Memo</h5>
                <div class="flex flex-wrap gap-2">
                    @foreach ($provinces as $province)
                        @php
                            $hasData = in_array($province->id, $dataHaveProvinces);
                        @endphp
                        <a href="{{ route('export.last2weeksDataexportToPDF', ['id' => $province->id]) }}"
                            class="px-3 py-2 text-xs font-semibold rounded-xl transition-all duration-150 text-white {{ $hasData ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-700 opacity-70 cursor-not-allowed pointer-events-none' }}">
                            {{ $province->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Other Info --}}
            <div class="p-3 space-y-4 bg-gray-900 shadow-lg rounded-xl">
                <div class="flex items-center justify-between p-4 rounded-md bg-slate-700">
                    <h5 class="text-sm font-bold text-white">🗂️ Other Information</h5>
                    <a href="{{ route('export.reportOfOtherInfo') }}"
                        class="px-3 py-2 text-xs font-bold text-white transition bg-red-700 rounded hover:bg-red-800">Download</a>
                </div>

                <div class="flex items-center justify-between p-4 rounded-md bg-slate-700">
                    <h5 class="text-sm font-bold text-white">👥 Data Collectors List</h5>
                    <a href="{{ route('export.collectorsList') }}"
                        class="px-3 py-2 text-xs font-bold text-white transition bg-red-700 rounded hover:bg-red-800">Download</a>
                </div>
            </div>

        </div>
    </div>

    {{-- JS Export Script --}}
    <script>
        document.getElementById('export-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.blob())
                .then(blob => {
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'users.xlsx';
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    window.location.href = "{{ route('report.index') }}";
                });
        });
    </script>
</x-app-layout>
