@extends('layouts.app')

@section('content')
<div class="mx-auto pt-10 bg-white shadow-lg rounded-lg p-6">
    @if ($message = Session::get('success'))
        <div class="bg-green-500 text-center text-white p-2 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <h2 class="text-2xl font-semibold text-center text-teal-600 mb-4">Student Names & Marks</h2>

    @can('marks-list')
    <!-- Search Bar -->
    <div class="mb-4 flex justify-end">
        <input type="text" id="searchInput" onkeyup="filterStudents()" placeholder="Search by student name..." 
               class="w-[300px] p-2 border border-teal-300 rounded-md" />
    </div>

    <div class="overflow-y-auto h-screen">
        <form action="{{ route('update.marks') }}" method="POST">
            @csrf
            <div class="gap-2 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3" id="studentsContainer">
                @foreach ($studentNames as $student)
                    <div class="student-card flex flex-col space-y-2 bg-teal-50 p-4 rounded-lg shadow-sm hover:bg-teal-100">
                        <span class="text-lg font-medium text-teal-800">{{ $student->student_name }}</span>
                        
                        <!-- Display Total Quiz Marks for Each Course -->
                        <div class="flex flex-col gap-2">
                            <label class="text-teal-800">Total Quiz Marks by Course:</label>
                            <div class="grid grid-cols-3">
                                @foreach($student->total_quiz_marks_by_course as $course => $totalQuizMarks)
                                    <div class="">
                                        <span class="text-teal-800">{{ $course }}:</span>
                                        <span class="font-semibold">{{ $totalQuizMarks }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Input fields for Quiz Marks -->
                        <div class="flex flex-col gap-2">
                            <label class="text-teal-800">Enter Quiz Marks:</label>
                            @foreach(explode(',', $student->course_names) as $course)
                                @php
                                    $encodedCourse = str_replace(' ', '_', $course);
                                @endphp
                                <div class="flex justify-between gap-2">
                                    <span class="text-teal-800">{{ $course }}</span>
                                    <input type="number" name="students[{{ $student->id }}][quiz_marks][{{ $encodedCourse }}]" 
                                        class="border border-teal-300 rounded px-2 py-1 w-20 text-center"
                                        placeholder="0-100" min="0" max="100">
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Display Total Exam Marks for Each Course -->
                        <div class="flex flex-col gap-2">
                            <label class="text-teal-800">Total Exam Marks by Course:</label>
                            <div class="grid grid-cols-3">
                                @foreach($student->total_exam_marks_by_course as $course => $totalExamMarks)
                                    <div class="">
                                        <span class="text-teal-800">{{ $course }}:</span>
                                        <span class="font-semibold">{{ $totalExamMarks }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Input fields for Exam Marks -->
                        <div class="flex flex-col gap-2">
                            <label class="text-teal-800">Enter Exam Marks:</label>
                            @foreach(explode(',', $student->course_names) as $course)
                                @php
                                    $encodedCourse = str_replace(' ', '_', $course);
                                @endphp
                                <div class="flex justify-between gap-2">
                                    <span class="text-teal-800">{{ $course }}</span>
                                    <input type="number" name="students[{{ $student->id }}][exam_marks][{{ $encodedCourse }}]" 
                                        class="border border-teal-300 rounded px-2 py-1 w-20 text-center"
                                        placeholder="0-100" min="0" max="100">
                                </div>
                            @endforeach
                        </div>

                        <input type="hidden" name="students[{{ $student->id }}][name]" value="{{ $student->student_name }}">

                        <div class="flex h-full">
                            <div class="mt-auto w-full">
                                <button 
                                    type="button" 
                                    class="bg-teal-500 w-full text-white py-1 px-4 rounded mt-2 hover:bg-teal-600" 
                                    onclick="openModal({{ json_encode($student) }})">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @can('marks-edit')
                <button type="submit" class="mt-6 w-full bg-[#000000] text-white py-2 rounded-md text-lg font-semibold hover:bg-teal-600">
                    Save Marks
                </button>
            @endcan
        </form>
    </div>
    @endcan
</div>

<!-- Modal -->
<div id="studentModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg max-w-md w-full">
        <h3 class="text-xl font-semibold text-teal-600 mb-4" id="modalStudentName"></h3>

        <div id="modalQuizMarksContainer" class="mb-4">
            <strong class="text-teal-800">Quiz Marks:</strong>
            <ul id="modalQuizMarks" class="font-semibold"></ul>
        </div>

        <div id="modalExamMarksContainer" class="mb-4">
            <strong class="text-teal-800">Exam Marks:</strong>
            <ul id="modalExamMarks" class="font-semibold"></ul>
        </div>

        <button class="mt-4 bg-teal-500 text-white py-2 px-6 rounded-md hover:bg-teal-600" onclick="closeModal()">
            Close
        </button>
    </div>
</div>

<script>
function openModal(student) {
    document.getElementById('modalStudentName').innerText = student.student_name;

    const quizMarksArray = JSON.parse(student.quiz_marks || "{}");
    const examMarksArray = JSON.parse(student.exam_marks || "{}");

    document.getElementById('modalQuizMarks').innerHTML = '';
    document.getElementById('modalExamMarks').innerHTML = '';

    Object.entries(quizMarksArray).forEach(([course, marks]) => {
        const listItem = document.createElement('li');
        listItem.innerText = `${course}: ${marks.join(', ')}`;
        document.getElementById('modalQuizMarks').appendChild(listItem);
    });

    Object.entries(examMarksArray).forEach(([course, marks]) => {
        const listItem = document.createElement('li');
        listItem.innerText = `${course}: ${marks.join(', ')}`;
        document.getElementById('modalExamMarks').appendChild(listItem);
    });

    document.getElementById('studentModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('studentModal').classList.add('hidden');
}

// JavaScript for filtering students by name
function filterStudents() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const studentsContainer = document.getElementById('studentsContainer');
    const studentCards = studentsContainer.getElementsByClassName('student-card');

    for (let i = 0; i < studentCards.length; i++) {
        const studentName = studentCards[i].getElementsByTagName("span")[0];
        const nameText = studentName.textContent || studentName.innerText;
        studentCards[i].style.display = nameText.toLowerCase().includes(filter) ? "" : "none";
    }
}
</script>
@endsection