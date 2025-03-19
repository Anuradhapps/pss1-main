<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }

            .report-container {
                max-width: 100%;
                box-shadow: none;
                padding: 100px;
            }
        }
    </style>
</head>

<body>
    <div class="p-4 bg-gray-100">

        <div class="max-w-[210mm] mx-auto bg-white shadow-lg p-6 rounded-lg report-container">
            <h2 class="mb-4 text-2xl font-bold text-center">Collectors</h2>


            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 text-left border border-gray-400">Province</th>
                            <th class="px-4 py-2 text-left border border-gray-400">District</th>
                            <th class="px-4 py-2 text-left border border-gray-400">ASC</th>
                            <th class="px-4 py-2 text-left border border-gray-400">AI</th>
                            <th class="px-4 py-2 text-left border border-gray-400">Name</th>
                            <th class="px-4 py-2 text-left border border-gray-400">Phone Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collectors as $collector)
                            <tr class="border border-gray-300">
                                <td class="px-4 py-2 border border-gray-400">{{ $collector[0] }}</td>
                                <td class="px-4 py-2 border border-gray-400">Colombo</td>
                                <td class="px-4 py-2 border border-gray-400">ASC1</td>
                                <td class="px-4 py-2 border border-gray-400">AI1</td>
                                <td class="px-4 py-2 border border-gray-400">Sample info</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>
