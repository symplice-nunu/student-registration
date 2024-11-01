<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Class List</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Class List</h2>
    <table>
        <thead>
            <tr>
                <th>Class ID</th>
                <th>Class Name</th>
                <th>Teacher ID</th>
                <th>Schedule</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes as $class)
                <tr>
                    <td>{{ $class->classID }}</td>
                    <td>{{ $class->className }}</td>
                    <td>{{ $class->teacherID }}</td>
                    <td>{{ $class->schedule }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
