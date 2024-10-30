<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9; /* Light background for contrast */
        }
        h2 {
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
    <h2>Student Report</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>DOB</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->dateOfBirth }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ $student->phoneNumber }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
