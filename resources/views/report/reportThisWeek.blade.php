<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pest Surveillance Report</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.5cm;
        }

        body {
            font-family: 'IskoolaPota', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .header,
        .footer {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .header p {
            margin: 3px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }

        .table th {
            background-color: #e4e4e4;
        }

        .note {
            font-size: 10px;
            margin-top: 12px;
            line-height: 1.4;
        }

        h2 {
            text-align: center;
            margin: 10px 0;
        }

        .info p {
            margin: 4px 0;
        }

        .signature {
            margin-top: 30px;
        }

        .footer p {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <p>NATIONAL PLANT PROTECTION SERVICE</p>
        <p>Gannoruwa, Peradeniya</p>
        <p>Tel: 0812 388316 | Email: ppsgannoruwa@yahoo.com</p>
    </div>

    <div class="info">
        <p><strong>To:</strong> Director/Ext. and Training, PDA - {{ ucwords(strtolower($records['province'])) }}</p>
        <p><strong>From:</strong> National Plant Protection Service</p>
        <p><strong>Date:</strong> {{ $records['endDate'] }}</p>
        <p><strong>Subject:</strong> Status Report on Pest Surveillance</p>
        <p><strong>CC:</strong> Director SCPP, Director General of Agriculture, Addl. DGA(Res./Dev.), Director RRDI</p>

    </div>

    <h2>PEST INFESTATION REPORT</h2>

    <div class="info">
        <p>
            <strong>Province/Inter Province:</strong> {{ ucwords(strtolower($records['province'])) }} |
            <strong>Crop:</strong> Paddy |
            <strong>Duration:</strong> {{ $records['startDate'] }} - {{ $records['endDate'] }}
        </p>
    </div>

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
                    <td>{{ $data['districtName'] }}</td>
                    <td>
                        @foreach ($data['ascNames'] as $ascName)
                            {{ $ascName }}@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </td>
                    <td>-</td>
                    <td>{{ $data['pestData']['Thrips'] ?? '-' }}</td>
                    <td>{{ $data['pestData']['Gall_Midge'] ?? '-' }}</td>
                    <td>{{ $data['pestData']['Leaffolder'] ?? '-' }}</td>
                    <td>{{ $data['pestData']['Yellow_Stem_Borer'] ?? '-' }}</td>
                    <td>{{ $data['pestData']['BPH+WBPH'] ?? '-' }}</td>
                    <td>{{ $data['pestData']['Paddy_Bug'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="note">
        <p><strong>Note:</strong> Crop Growth Stage: 1 – Germination; 2 – Seedling; 3 – Tillering; 4 – Stem Elongation;
            5 – Booting; 6 – Heading; 7 – Milk Stage; 8 – Dough Stage; 9 – Mature Grain.</p>
        <p><strong>Damage Levels:</strong> 0–10%: No Risk | 10–20%: Alert | 25–50%: Control Suggested | 50–70%:
            Immediate Action.</p>
    </div>

    <div class="note">
        <strong>NB:</strong> We acknowledge the valuable support of our agriculturists for their efforts in
        establishing the National Pest Surveillance System (NPSS), helping reduce pest outbreaks and improve
        productivity.
    </div>

    <div class="signature">
        <p>Thank you,</p>
        <p><strong>Additional Director / National Plant Protection Service</strong></p>
    </div>

    <div class="footer">
        <p>"Achieve Excellence in Agriculture through Safe and Effective Plant Protection Strategies"</p>
    </div>
</body>

</html>
