<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NPSS Collectors List</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
        }

        .report-container {
            width: 100%;
            padding: 10px 20px;
        }

        h2 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 12px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px 8px;
            font-size: 11px;
            text-align: left;
        }

        th {
            background-color: #e0e0e0;
            font-weight: bold;
        }

        .district-row {
            background-color: #f99;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }

        .collector-row:nth-child(even) td {
            background-color: #f9f9f9;
        }

        .footer-note {
            text-align: center;
            font-size: 10px;
            margin-top: 30px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="report-container">
        <h2>Name List of NPSS Data Collectors</h2>
        <div class="subtitle">Plant Protection Service, Gannoruwa</div>

        <table>
            <thead>
                <tr>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 25%;">AI Range</th>
                    <th style="width: 20%;">Phone Number</th>
                    <th style="width: 25%;">Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $districtData)
                    <tr class="district-row">
                        <td colspan="4">
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
                        </tr>
                    @endforeach

                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">No collector data found.</td>
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
