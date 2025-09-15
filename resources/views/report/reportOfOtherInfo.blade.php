<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Other Information Report</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm;
        }

        body {
            font-family: 'IskoolaPota', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            color: #000;
            background-color: #fff;
        }

        .report-container {
            width: 100%;
            padding: 10px;
        }

        h2 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 5px;
        }

        h5 {
            font-size: 12px;
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px 8px;
            font-size: 11px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        tr:nth-child(even) td {
            background-color: #fafafa;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="report-container">
        <h2>Reported Information from AI Ranges in Sri Lanka ({{ $season }})</h2>
        <h5>National Plant Protection Service, Gannoruwa</h5>
        <hr>

        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">Date</th>
                    <th style="width: 120px;">District</th>
                    <th style="width: 120px;">ASC</th>
                    <th style="width: 120px;">AI Range</th>
                    <th>Other Information</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    @if (!empty($record['otherinfo']))
                        <tr>
                            <td>{{ $record['c_date'] }}</td>
                            <td>{{ $record['district_name'] }}</td>
                            <td>{{ $record['asc_name'] }}</td>
                            <td>{{ $record['ai_range_name'] }}</td>
                            <td>{{ $record['otherinfo'] }}</td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">No data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- <div class="footer">
            "Working Together for a Pest-Free Sri Lanka"
        </div> --}}
    </div>
</body>

</html>
