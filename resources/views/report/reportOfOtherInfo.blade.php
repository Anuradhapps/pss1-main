<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* Reset for body */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        /* Page Layout for Print */
        @page {
            size: A4 portrait;
            margin: 20mm;
        }

        /* Report Container */
        .report-container {
            width: 100%;
            max-width: 210mm;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Header */
        h2 {

            font-size: 20px;
            text-align: center;
            color: #333;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .date {
            white-space: nowrap;
            min-width: 60px;
        }

        h5 {
            margin: 0;
            margin-top: 5px;
            padding: 0;
            font-size: 10px;
            text-align: center;
            color: #333;
            font-weight: bold;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            font-size: 10px;
            padding: 3px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
            color: #333;
        }

        td {
            background-color: #fff;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Media Query for Print */
        @media print {
            body {
                background-color: white;
                margin: 0;
                padding: 0;
            }

            .report-container {
                padding: 20px;
                box-shadow: none;
                margin: 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                padding: 10px;
                font-size: 12px;
            }

            th {
                background-color: #f4f4f4;
                color: #333;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            tr:hover {
                background-color: transparent;
            }
        }
    </style>
</head>

<body>
    <div class="p-4 bg-gray-100">

        <div class="report-container">
            <h2>Sri Lanka Rice Cultivation Report ({{ $season }})</h2>
            <h5>Plant Protection service, Gannoruwa.</h5>
            <hr>

            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th class="date">Date</th>
                            <th>District</th>
                            <th>ASC</th>
                            <th>AI</th>
                            <th>Other Infomation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $commonDataCollect)
                            @if ($commonDataCollect['otherinfo'] != null)
                                <tr>
                                    <td>{{ $commonDataCollect['c_date'] }}</td>
                                    <td>{{ $commonDataCollect['district_name'] }}</td>
                                    <td>{{ $commonDataCollect['asc_name'] }}</td>
                                    <td>{{ $commonDataCollect['ai_range_name'] }}</td>
                                    <td>{{ $commonDataCollect['otherinfo'] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>
