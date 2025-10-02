<x-app-layout>
    <div class="space-y-4">
        {{-- Header --}}
        <x-headings.top-heading title="Reports Dashboard" icon="fas fa-chart-line"
            class="bg-gradient-to-r from-green-800 to-green-600 shadow" />

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 m-2 gap-2 sm:grid-cols-2 md:grid-cols-3 ">

            {{-- All Data Export Card --}}
            <div class="border border-gray-700 bg-gray-900 shadow">
                <div class="p-4 border-b border-gray-700 bg-gray-800">
                    <h5 class="flex items-center text-lg font-semibold text-green-400">
                        <i class="mr-2 text-green-500 fas fa-database"></i> Full Data Export
                    </h5>
                </div>
                <div class="p-4">
                    <x-form class="space-y-3" id="export-form" action="{{ route('export.allpestdata') }}"
                        method="post">
                        @csrf
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">Start Date</label>
                            <input type="date" name="start_date"
                                class="w-full px-3 py-2 text-white bg-gray-800 border border-gray-700 focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">End Date</label>
                            <input type="date" name="end_date"
                                class="w-full px-3 py-2 text-white bg-gray-800 border border-gray-700 focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        </div>
                        <button type="submit"
                            class="flex items-center justify-center w-full px-4 py-2 mt-3 text-sm font-semibold text-white transition bg-green-700 hover:bg-green-600 border border-green-600">
                            <i class="mr-2 fas fa-file-excel"></i> Export Excel
                        </button>
                    </x-form>
                </div>
            </div>

            {{-- Recent Memos Card --}}
            <div class="border border-gray-700 bg-gray-900 shadow">
                <div class="p-4 border-b border-gray-700 bg-gray-800">
                    <h5 class="flex items-center text-lg font-semibold text-green-400">
                        <i class="mr-2 text-green-500 fas fa-clock"></i> Recent Memos
                    </h5>
                </div>
                <div class="p-4">
                    <p class="mb-3 text-sm text-gray-400">Last 2 weeks by province:</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($provinces as $province)
                            @php
                                $hasData = in_array($province->id, $dataHaveProvinces);
                            @endphp
                            <a href="{{ $hasData ? route('export.last2weeksDataexportToPDF', ['id' => $province->id]) : '#' }}"
                                class="flex items-center justify-center px-3 py-2 text-xs font-medium transition border
                                    {{ $hasData
                                        ? 'text-white bg-gray-800 border-gray-700 hover:bg-gray-700 hover:border-gray-600'
                                        : 'text-gray-500 bg-gray-900 border-gray-800 cursor-not-allowed' }}">
                                <i
                                    class="mr-1 fas {{ $hasData ? 'fa-file-pdf text-red-400' : 'fa-file text-gray-600' }}"></i>
                                {{ $province->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Quick Exports Card --}}
            <div class="border border-gray-700 bg-gray-900 shadow">
                <div class="p-4 border-b border-gray-700 bg-gray-800">
                    <h5 class="flex items-center text-lg font-semibold text-green-400">
                        <i class="mr-2 text-green-500 fas fa-file-export"></i> Quick Exports
                    </h5>
                </div>
                <div class="space-y-2 p-4">
                    <div class="flex items-center justify-between p-3 bg-gray-800 border border-gray-700">
                        <div class="flex items-center">
                            <i class="mr-2 text-blue-400 fas fa-info-circle"></i>
                            <span class="text-sm font-medium text-gray-300">Collectors Other Info</span>
                        </div>
                        <a href="{{ route('export.reportOfOtherInfo') }}"
                            class="p-2 text-xs font-medium text-white transition bg-gray-700 border border-gray-600 hover:bg-gray-600">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-800 border border-gray-700">
                        <div class="flex items-center">
                            <i class="mr-2 text-purple-400 fas fa-users"></i>
                            <span class="text-sm font-medium text-gray-300">Collectors Registry</span>
                        </div>
                        <a href="{{ route('export.collectorsList') }}"
                            class="p-2 text-xs font-medium text-white transition bg-gray-700 border border-gray-600 hover:bg-gray-600">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
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
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.blob())
                .then(blob => {
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'pest_data_export.xlsx';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</x-app-layout>
