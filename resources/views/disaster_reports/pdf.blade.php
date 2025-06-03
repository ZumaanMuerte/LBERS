<!DOCTYPE html>
<html>
<head>
    <title>Disaster Report PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Disaster Report Summary</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Location</th>
                <th>Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->date }}</td>
                    <td>{{ $report->location }}</td>
                    <td>{{ ucfirst($report->disaster_type) }}</td>
                    <td>{{ $report->damage_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
