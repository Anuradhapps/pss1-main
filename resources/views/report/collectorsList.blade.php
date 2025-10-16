<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NPSS Collectors List</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: 'IskoolaPota', sans-serif;
            font-size: 10px;
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
            margin-bottom: 2px;
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
            padding: 5px 6px;
            text-align: left;
        }

        th {
            background-color: #d4f0d4;
            font-weight: bold;
        }

        .season-row {
            background-color: #b8f0b8;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            text-align: center;
        }

        .region-row {
            background-color: #ffeaa7;
            font-weight: bold;
            font-size: 10.5px;
            text-transform: uppercase;
        }

        .district-row {
            background-color: #c6e0f5;
            font-weight: bold;
            font-size: 10.5px;
            text-transform: uppercase;
        }

        .collector-row:nth-child(even) td {
            background-color: #f5f5f5;
        }

        .collector-row:hover td {
            background-color: #e0f7fa;
        }

        .footer-note {
            text-align: center;
            font-size: 9px;
            margin-top: 15px;
            color: #555;
            font-style: italic;
        }

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
        <h2>NPSS Data Collectors List</h2>
        <div class="subtitle">National Plant Protection Service, Gannoruwa</div>

        {{-- Summary Section --}}
        @if (isset($summary) && count($summary) > 0)
            <h3 style="text-align: center; font-size: 12px; margin-top: 5px;">Summary (Collectors by Region & District)
            </h3>
            <table style="margin-bottom: 20px; font-size: 10px;">
                <thead>
                    <tr>
                        <th style="width: 18%;">Season</th>
                        <th style="width: 22%;">Region</th>
                        <th style="width: 22%;">District</th>
                        <th style="width: 12%;">Total Collectors</th>
                        <th style="width: 12%;">&gt;= 4 Entries</th>
                        <th style="width: 12%;">&lt; 4 Entries</th>
                        <th style="width: 12%;">0 Entries</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summary as $row)
                        <tr>
                            <td>{{ $row['season'] }}</td>
                            <td>{{ $row['region'] }}</td>
                            <td>{{ $row['district'] }}</td>
                            <td>{{ $row['collectorCount'] }}</td>
                            <td>{{ $row['countGE4'] }}</td>
                            <td>{{ $row['countLT4'] }}</td>
                            <td>{{ $row['countZero'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- Main Table --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 25%;">Name</th>
                    <th style="width: 15%;">AI Range</th>
                    <th style="width: 15%;">Phone</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 12%;">Season</th>
                    <th style="width: 13%;">Data Count</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $seasonData)
                    {{-- 🌾 Season Header --}}
                    <tr class="season-row">
                        <td colspan="6">SEASON: {{ $seasonData['season'] }}</td>
                    </tr>

                    {{-- 🌍 Regions --}}
                    @foreach ($seasonData['regions'] as $region)
                        <tr class="region-row">
                            <td colspan="6">REGION: {{ $region['region'] }}</td>
                        </tr>

                        {{-- 🏙 Districts --}}
                        @foreach ($region['districts'] as $district)
                            <tr class="district-row">
                                <td colspan="6">
                                    {{ $district['district'] }} — Collectors: {{ count($district['collectors']) }}
                                </td>
                            </tr>

                            {{-- 👥 Collectors --}}
                            @foreach ($district['collectors'] as $collector)
                                <tr class="collector-row">
                                    <td>{{ $collector['name'] }}</td>
                                    <td>{{ $collector['ai_range'] }}</td>
                                    <td>{{ $collector['phone'] }}</td>
                                    <td>{{ $collector['email'] }}</td>
                                    <td>{{ $collector['season'] }}</td>
                                    <td>{{ $collector['data_count'] }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach

                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">No collector data found.</td>
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
