<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pest Surveillance Report</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header,
        .footer {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;

        }

        .table th {
            background-color: #f2f2f2;
        }

        .note {
            font-size: 10px;
            margin-top: 10px;
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <p><strong>PLANT PROTECTION SERVICE</strong><br>
            Gannoruwa, Peradeniya<br>
            Tel: 0812 388316 | Email: <a href="mailto:ppsgannoruwa@yahoo.com">ppsgannoruwa@yahoo.com</a></p>
    </div>

    <p><strong>To:</strong> Director/Ext. and Training, PDA- {{ ucwords(strtolower($records['province'])) }}</p>
    <p><strong>From:</strong> Plant Protection Service</p>
    <p><strong>Date:</strong> {{ $records['endDate'] }}</p>
    <p><strong>Subject:</strong> Status Report on Pest Surveillance</p>
    <p><strong>CC:</strong> Director SCPP, Director General of Agriculture, Addl. DGA(Res./Dev.), Director RRDI</p>

    <h2 style="text-align: center;">PEST INFESTATION REPORT</h2>

    <p><strong>Province/Inter Province:</strong> {{ ucwords(strtolower($records['province'])) }} |
        <strong>Crop:</strong> Paddy | <strong>Duration:</strong>
        {{ $records['startDate'] }} - {{ $records['endDate'] }}
    </p>

    <table class="table">
        <thead>
            <tr>
                <th>District</th>
                <th>ASC/YAYA</th>
                <th>Crop Growth Stage</th>
                <th>Thrips</th>
                <th>Gall Midge</th>
                <th>Leaf-folder</th>
                <th>Yellow Stem Borer</th>
                <th>BPH/ WBPH</th>
                <th>Paddy Bugs</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records['data'] as $data)
                <tr>
                    <!-- Display the district name -->
                    <td>{{ $data['districtName'] }}</td>




                    <!-- Display ascNames (e.g., Dadigama) -->
                    <td>
                        @foreach ($data['ascNames'] as $ascName)
                            {{ $ascName }},
                        @endforeach
                    </td>
                    <td>-</td>
                    <!-- Loop through pestData and display pest counts -->
                    @foreach ($data['pestData'] as $pestName => $pestCount)
                        <td>{{ $pestCount }}</td>
                    @endforeach
                </tr>
            @endforeach


        </tbody>
    </table>

    <p class="note">
        <strong>Note:</strong> Crop Growth Stage: 1 – Germination; 2-Seedling; 3-Tillering; 4-Stem Elongation;
        5-Booting; 6-Heading; 7-Milk Stage; 8-Dough Stage; 9-Mature Grain.<br>
        <strong>Damage Levels:</strong> 0-10%: No risk | 10%-20%: Alert | 25%-50%: Control suggested | 50%-70%:
        Immediate action.
    </p>

    <p class="note">
        <strong>NB:</strong> Thanks to our Agriculturists for their efforts in establishing the National Pest
        Surveillance System (NPSS), helping minimize pest outbreaks and increase crop productivity.
    </p>

    <p>Thank you,<br><strong>Additional Director / Plant Protection Service</strong></p>

    <div class="footer">
        <p>"Achieve Excellence in Agriculture through Safe and Effective Plant Protection Strategies"</p>
    </div>

</body>

</html>
