<!DOCTYPE html>
<html>
<head>
    <title>Earthquake Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Earthquake Report</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Location</th>
                <th>Intensity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($earthquakes as $eq)
                <tr>
                    <td>{{ $eq->date }}</td>
                    <td>{{ $eq->location }}</td>
                    <td>{{ $eq->intensity_scale }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
