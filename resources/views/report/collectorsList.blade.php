<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NPSS Collectors List</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
            /* reduced margin for compact layout */
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
            /* slightly smaller for compact table */
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
        }

        .report-container {
            width: 100%;
            padding: 5px 10px;
        }

        h2 {
            font-size: 16px;
            text-align: center;
            margin-bottom: 3px;
            font-weight: bold;
        }

        .subtitle {
            text-align: center;
            font-size: 11px;
            margin-bottom: 10px;
            font-style: italic;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 4px 6px;
            /* tighter padding for compact layout */
            text-align: left;
        }

        th {
            background-color: #d4f0d4;
            /* subtle color for headers */
            font-weight: bold;
        }

        .district-row {
            background-color: #c6e0f5;
            /* soft color for district rows */
            font-weight: bold;
            font-size: 10.5px;
            text-transform: uppercase;
        }

        .collector-row:nth-child(even) td {
            background-color: #f5f5f5;
        }

        .collector-row:hover td {
            background-color: #e0f7fa;
            /* subtle hover highlight for readability */
        }

        .footer-note {
            text-align: center;
            font-size: 9px;
            margin-top: 20px;
            color: #555;
        }

        /* Responsive for PDF printing */
        @media print {
            body {
                font-size: 10px;
            }

            table th,
            table td {
                padding: 3px 5px;
            }
        }
    </style>
</head>

<body>
    <div class="report-container">
        <h2>Name List of NPSS Data Collectors</h2>
        <div class="subtitle">National Plant Protection Service, Gannoruwa</div>

        <table>
            <thead>
                <tr>
                    <th style="width: 25%;">Name</th>
                    <th style="width: 15%;">AI Range</th>
                    <th style="width: 15%;">Phone Number</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 12%;">Season</th>
                    <th style="width: 13%;">Data Count</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $districtData)
                    <tr class="district-row">
                        <td colspan="6">
                            {{ $districtData['district'] }} &nbsp;&mdash;&nbsp;
                            Collectors: {{ count($districtData['collectors']) }}
                        </td>
                    </tr>

                    @foreach ($districtData['collectors'] as $collector)
                        <tr class="collector-row">
                            <td>{{ $collector[0] }}</td>
                            <td>{{ $collector[2] }}</td>
                            <td>{{ $collector[3] }}</td>
                            <td>{{ $collector[5] }}</td>
                            <td>{{ $collector[7] }}</td>
                            <td>{{ $collector[6] }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">No collector data found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-note">
            "Empowering Agriculture through Timely Pest Surveillance & Reporting"
        </div>
    </div>
</body>

</html>
