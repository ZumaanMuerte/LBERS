<!DOCTYPE html>
<html>
<head>
    <title>Wind Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Wind Report</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Location</th>
                <th>Wind Signal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($winds as $wind)
                <tr>
                    <td>{{ $wind->date }}</td>
                    <td>{{ $wind->location }}</td>
                    <td>{{ $wind->wind_signal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
