@extends('layouts.app')
@section('content')
<div class="h-screen">
    <div class="p-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 lg:grid-cols-4 gap-3">
        <div class="bg-black text-white p-4 rounded-xl">
            <div>Users</div>
            <div class="text-[25px] font-bold">{{ $userCount }}</div>
        </div>
        <div class="bg-black text-white p-4 rounded-xl">
            <div>Students</div>
            <div class="text-[25px] font-bold">{{ $studentCount }}</div>
        </div>
        <div class="bg-black text-white p-4 rounded-xl">
            <div>Teachers</div>
            <div class="text-[25px] font-bold">{{ $teacherCount }}</div>
        </div>
        <div class="bg-black text-white p-4 rounded-xl">
            <div>Classes</div>
            <div class="text-[25px] font-bold">{{ $classCount }}</div>
        </div>
        <div class="bg-black text-white p-4 rounded-xl">
            <div>Amount per semester</div>
            <div class="text-[25px] font-bold">1000</div>
        </div>
        <div class="bg-black text-white p-4 rounded-xl">
            <div>Amount per year</div>
            <div class="text-[25px] font-bold">1000</div>
        </div>
        <div class="bg-black text-white p-4 rounded-xl">
            <div>Documents</div>
            <div class="text-[25px] font-bold">{{ $documentCount }}</div>
        </div>
        <div class="bg-black text-white p-4 rounded-xl">
            <div>Courses</div>
            <div class="text-[25px] font-bold">{{ $courseCount }}</div>
        </div>
    </div>
    <div class="max-w-full  bg-white p-6 rounded-lg shadow-md">
<div class="flex gap-10 ">
    <div class="w-full"><canvas id="comparisonChart" class="mb-4"></canvas></div>
    <div class="h-[800px]"><canvas id="pieChart"></canvas></div>
</div>
        <script>
            // Getting the data from the server
            const userCount = {{ $userCount }};
            const teacherCount = {{ $teacherCount }};
            const studentCount = {{ $studentCount }};
            const classCount = {{ $classCount }};
            const documentCount = {{ $documentCount }};
            const courseCount = {{ $courseCount }};

            // Bar Chart
            const ctxBar = document.getElementById('comparisonChart').getContext('2d');
            const comparisonChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Users', 'Teachers', 'Students', 'Classes', 'Documents', 'Courses'],
                    datasets: [{
                        label: 'Count',
                        data: [userCount, teacherCount, studentCount, classCount, documentCount, courseCount],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Pie Chart
            const ctxPie = document.getElementById('pieChart').getContext('2d');
            const pieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Users', 'Teachers', 'Students', 'Classes', 'Documents', 'Courses'],
                    datasets: [{
                        label: 'Count',
                        data: [userCount, teacherCount, studentCount, classCount, documentCount, courseCount],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',  // Users
                            'rgba(54, 162, 235, 0.6)',  // Teachers
                            'rgba(255, 206, 86, 0.6)',   // Students
                            'rgba(75, 192, 192, 0.6)',   // Classes
                            'rgba(153, 102, 255, 0.6)',  // Documents
                            'rgba(255, 159, 64, 0.6)'    // Courses
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    </div>
</div>
@endsection
