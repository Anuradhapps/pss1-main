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
    <div class="bg-gray-100 p-4">

        <div class="max-w-[210mm] mx-auto bg-white shadow-lg p-6 rounded-lg report-container">
            <h2 class="text-2xl font-bold text-center mb-4">Collectors</h2>

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-400 px-4 py-2 text-left">Province</th>
                            <th class="border border-gray-400 px-4 py-2 text-left">District</th>
                            <th class="border border-gray-400 px-4 py-2 text-left">ASC</th>
                            <th class="border border-gray-400 px-4 py-2 text-left">AI</th>
                            <th class="border border-gray-400 px-4 py-2 text-left">Name</th>
                            <th class="border border-gray-400 px-4 py-2 text-left">Phone Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collectors as $collector)
                            <tr class="border border-gray-300">
                                <td class="border border-gray-400 px-4 py-2">{{ $collector[0] }}</td>
                                <td class="border border-gray-400 px-4 py-2">Colombo</td>
                                <td class="border border-gray-400 px-4 py-2">ASC1</td>
                                <td class="border border-gray-400 px-4 py-2">AI1</td>
                                <td class="border border-gray-400 px-4 py-2">Sample info</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>
