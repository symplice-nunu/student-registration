<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9; /* Light background for contrast */
        }
        h1 {
            text-align: center;
            color: #333; /* Darker text for better readability */
            margin-bottom: 20px; /* Space below the title */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }
        th, td {
            padding: 8px; /* Increased padding for more space */
            border: 1px solid #dddddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50; /* Green header for visibility */
            color: white; /* White text on header */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Zebra striping for rows */
        }
        tr:hover {
            background-color: #e0f7fa; /* Light blue highlight on hover */
        }
    </style>
</head>
<body>

<h1>Teachers Report</h1>

<table>
    <thead>
        <tr>
            <th>Teacher ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Date of Birth</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($teachers as $teacher)
            <tr>
                <td>{{ $teacher->teacherID }}</td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->phoneNumber }}</td>
                <td>{{ $teacher->DOB }}</td>
                <td>{{ $teacher->address }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
