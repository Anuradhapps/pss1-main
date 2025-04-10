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

        body {
            font-family: Arial, sans-serif;
            background: white;
            margin: 0;
            padding: 0;
        }

        .report-container {
            width: 100%;
            max-width: 800px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            padding-bottom: 50px;
            border-bottom: 1px solid #444444;
            font-size: 20px;
            text-align: center;
            color: #333;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }


        .table-container {
            margin-top: 10px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #8f8f8f;
            padding: 3px;
            text-align: left;
            font-size: 13px
        }

        th {
            border: 1px solid #444444;
            background: #d4d4d4;
            font-size: 14px
        }

        .district-header {
            background: #fa9494;
            font-weight: bold;
            padding: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="report-container">
        <h2>NPSS Collectors List</h2>

        <div class="table-container">
            <table>

                <tbody>
                    @foreach ($data as $asDistricts)
                        <tr class="district-header">
                            <td colspan="4">{{ $asDistricts['district'] }} - Collectors:
                                {{ count($asDistricts['collectors']) }}</td>
                        </tr>

                        <tr>
                            <th>Name</th>
                            <th>ASC</th>
                            <th>AI</th>
                            <th>Phone Number</th>
                        </tr>

                        @foreach ($asDistricts['collectors'] as $collector)
                            <tr>
                                <td>{{ $collector[0] }}</td>
                                <td>{{ $collector[1] }}</td>
                                <td>{{ $collector[2] }}</td>
                                <td>{{ $collector[3] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
