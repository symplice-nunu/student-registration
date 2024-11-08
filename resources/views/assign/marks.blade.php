@extends('layouts.app')

@section('content')
<div class=" mx-auto pt-10 bg-white shadow-lg rounded-lg p-6">
    <!-- Display Success Message -->
    @if ($message = Session::get('success'))
        <div class="bg-green-500 text-center text-white p-2 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <h2 class="text-2xl font-semibold text-center text-teal-600 mb-4">Student Names & Marks</h2>

    @can('marks-list')
   <!-- <?php //if(Auth::user()->email }} ?>-->
    <form action="{{ route('update.marks') }}" method="POST">
        @csrf
        <ul class="gap-2 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($studentNames as $student)
                <li class="flex flex-col space-y-2 bg-teal-50 p-4 rounded-lg shadow-sm hover:bg-teal-100">
                    <span class="text-lg font-medium text-teal-800">{{ $student->student_name }}</span>

                    <!-- Display total quiz marks and exam marks -->
                    <div class="flex justify-between">
                        <div class="flex items-center space-x-2">
                            <label class="text-teal-800">Total Quiz Marks:</label>
                            <span class="font-semibold">{{ $student->total_quiz_marks }}</span>
                        </div>
                        <!-- Quiz Marks Input -->
                        @can('marks-edit')
                        <div class="">
                            <input type="number" name="students[{{ $student->id }}][quiz_marks]" 
                                class="border border-teal-300 rounded px-2 py-1 w-20 text-center"
                                placeholder="0-100" min="0" max="100">
                        </div>
                        @endcan
                    </div>

                    <div class="flex justify-between">
                        <div class="flex items-center space-x-2">
                            <label class="text-teal-800">Total Exam Marks:</label>
                            <span class="font-semibold">{{ $student->total_exam_marks }}</span>
                        </div> 
                        <!-- Exam Marks Input -->
                        @can('marks-edit')
                        <div class="flex items-center space-x-2">
                            <input type="number" name="students[{{ $student->id }}][exam_marks]" 
                                class="border border-teal-300 rounded px-2 py-1 w-20 text-center"
                                placeholder="0-100" min="0" max="100">
                        </div>
                        @endcan
                    </div>

                    

                    <!-- Input fields for new quiz and exam marks -->
                    <input type="hidden" name="students[{{ $student->id }}][name]" value="{{ $student->student_name }}">

                    

                   
                    <!-- Button to open modal with student details -->
                    <button type="button" class="bg-teal-500 text-white py-1 px-4 rounded mt-2 hover:bg-teal-600" onclick="openModal({{ json_encode($student) }})">
                        View Details
                    </button>
                </li>
            @endforeach
        </ul>

        <!-- Save Button -->
        @can('marks-edit')
        <button type="submit" class="mt-6 w-full bg-teal-500 text-white py-2 rounded-md text-lg font-semibold hover:bg-teal-600">
            Save Marks
        </button>
        @endcan
    </form>
    @endcan
</div>

<!-- Modal for displaying student details -->
<div id="studentModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg max-w-md w-full">
        <h3 class="text-xl font-semibold text-teal-600 mb-4" id="modalStudentName"></h3>

        <!-- Display all Quiz Marks from array -->
        <div id="modalQuizMarksContainer" class="mb-4">
            <strong class="text-teal-800">Quiz Marks:</strong>
            <ul id="modalQuizMarks" class="font-semibold"></ul>
        </div>

        <!-- Display all Exam Marks from array -->
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
// Function to open modal and populate it with student details
function openModal(student) {
    // Set the student name in the modal header
    document.getElementById('modalStudentName').innerText = student.student_name;

    // Ensure quiz_marks and exam_marks are arrays, and remove any non-numeric characters
    let quizMarksArray = Array.isArray(student.quiz_marks) ? student.quiz_marks : student.quiz_marks.split(',');
    let examMarksArray = Array.isArray(student.exam_marks) ? student.exam_marks : student.exam_marks.split(',');

    // Remove any non-numeric characters (only keep numbers)
    quizMarksArray = quizMarksArray.map(function(mark) {
        return mark.replace(/[^0-9]/g, ''); // Remove anything that is not a number
    });

    examMarksArray = examMarksArray.map(function(mark) {
        return mark.replace(/[^0-9]/g, ''); // Remove anything that is not a number
    });

    // Clear previous quiz marks and exam marks from modal
    document.getElementById('modalQuizMarks').innerHTML = '';
    document.getElementById('modalExamMarks').innerHTML = '';

    // Populate quiz marks as numbered list
    quizMarksArray.forEach(function(quizMark, index) {
        let listItem = document.createElement('li');
        listItem.innerText = `${index + 1}. ${quizMark}`;  // Add numbering
        document.getElementById('modalQuizMarks').appendChild(listItem);
    });

    // Populate exam marks as numbered list
    examMarksArray.forEach(function(examMark, index) {
        let listItem = document.createElement('li');
        listItem.innerText = `${index + 1}. ${examMark}`;  // Add numbering
        document.getElementById('modalExamMarks').appendChild(listItem);
    });

    // Show the modal
    document.getElementById('studentModal').classList.remove('hidden');
}

// Function to close the modal
function closeModal() {
    document.getElementById('studentModal').classList.add('hidden');
}
</script>




@endsection
