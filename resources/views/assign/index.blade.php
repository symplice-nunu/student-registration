<!-- resources/views/school/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="h-screen mx-auto p-5">

@if ($message = Session::get('success'))
    <div class="bg-green-500 text-center text-white p-2 rounded mb-4">
        {{ $message }}
    </div>
@endif

<div class="border-b border-gray-300 mb-4">
    <!-- Tab Links -->
    <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
            <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-white bg-teal-500" onclick="openTab(event, 'assign-course')">
                Assign Course
            </a>
        </li>
        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
            <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-teal-500 bg-white" onclick="openTab(event, 'student-courses')">
                Student Courses
            </a>
        </li>
    </ul>
</div>

<!-- Tab Content -->
<div id="assign-course" class="tab-content">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Students List -->
        <div>
            <div class="text-center bg-teal-500 text-white rounded-md py-1 mb-2">Students</div>
            <div class="border-2 bg-gray-200 border-gray-400 rounded-md h-[250px] overflow-y-auto overflow-x-hidden p-5">
                @foreach($students as $student)
                    <div class="student-item py-2 bg-gray-300 border border-gray-400 hover:bg-blue-500 hover:text-white mb-2 rounded px-2 cursor-pointer" onclick="selectItem(this, '{{ $student->name }}', 'student')">
                        {{ $student->name }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Classes List -->
        <div>
            <div class="text-center bg-teal-500 text-white rounded-md py-1 mb-2">Classes</div>
            <div class="border-2 bg-gray-200 border-gray-400 rounded-md h-[250px] overflow-y-auto overflow-x-hidden p-5">
                @foreach($classes as $class)
                    <div class="class-item py-2 bg-gray-300 border border-gray-400 hover:bg-teal-500 hover:text-white mb-2 rounded px-2 cursor-pointer" onclick="selectItem(this, '{{ $class->className }}', 'class')">
                        {{ $class->className }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Courses List -->
        <div>
            <div class="text-center bg-teal-500 text-white rounded-md py-1 mb-2">Courses</div>
            <div class="border-2 bg-gray-200 border-gray-400 rounded-md h-[250px] overflow-y-auto overflow-x-hidden p-5">
                @foreach($courses as $course)
                    <div class="course-item py-2 bg-gray-300 border border-gray-400 hover:bg-cyan-500 hover:text-white mb-2 rounded px-2 cursor-pointer" onclick="selectItem(this, '{{ $course->courseName }}', 'course')">
                        {{ $course->courseName }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Form to Submit Selected Items -->
    <form action="{{ route('submit.selected.items') }}" method="POST" id="selectedItemsForm">
        @csrf
        <input type="hidden" name="selected_student" id="selected_student">
        <input type="hidden" name="selected_class" id="selected_class">
        <input type="hidden" name="selected_courses" id="selected_courses">

        <div id="selectedItem" class="border-2 border-gray-400 rounded-md mt-4 h-[250px] w-full overflow-y-auto overflow-x-hidden p-5">
            <!-- Selected student, class, and course names will appear here -->
        </div>

        <!-- Submit Button -->
        <button type="button" onclick="submitSelectedItems()" class="mt-4 px-4 py-2 bg-teal-500 text-white rounded-md">Submit Selection</button>
    </form>
</div>

<div id="student-courses" class="tab-content hidden">
    <div class="text-center text-lg text-teal-500 mb-4">Student Courses List</div>
    <div class="overflow-x-auto">
        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Student Name</th>
                    <th class="px-4 py-2 border">Class</th>
                    <th class="px-4 py-2 border">Course</th>
                    <th class="px-4 py-2 border">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($selections as $selection)
                    <tr>
                        <td class="px-4 py-2 border">{{ $selection->id }}</td>
                        <td class="px-4 py-2 border">{{ $selection->student_name }}</td>
                        <td class="px-4 py-2 border">{{ $selection->class_name }}</td>
                        <td class="px-4 py-2 border">{{ $selection->course_names }}</td>
                        <td class="px-4 py-2 border">{{ $selection->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $selections->links() }}
    </div>
</div>

<style>
    .active-tab { background-color: #14b8a6; color: white; }
    .active-student { background-color: #3b82f6; color: white; }
    .active-class { background-color: #14b8a6; color: white; }
    .active-course { background-color: #06b6d4; color: white; }
</style>

<script>
    let selectedStudent = '';
    let selectedClass = '';
    let selectedCourses = [];

    function selectItem(element, itemName, type) {
        if (type === 'student') {
            document.querySelectorAll('.student-item').forEach(item => item.classList.remove('active-student'));
            selectedStudent = itemName;
            element.classList.add('active-student');
        } else if (type === 'class') {
            document.querySelectorAll('.class-item').forEach(item => item.classList.remove('active-class'));
            selectedClass = itemName;
            element.classList.add('active-class');
        } else if (type === 'course') {
            if (selectedCourses.includes(itemName)) {
                selectedCourses = selectedCourses.filter(course => course !== itemName);
                element.classList.remove('active-course');
            } else {
                selectedCourses.push(itemName);
                element.classList.add('active-course');
            }
        }
        updateSelectedDisplay();
    }

    function updateSelectedDisplay() {
        document.getElementById('selectedItem').innerHTML = `
            <div class='grid grid-cols-3'>
                <div>
                    <div class='bg-teal-500 py-1 px-3 text-white rounded-l-md'>Selected Student</div>
                    <div class='bg-gray-200 h-[170px] text-gray-500 mt-2 py-1 px-3 rounded-l-md'>${selectedStudent || 'None'}</div>
                </div>
                <div>
                    <div class='bg-teal-500 py-1 px-3 text-white'>Selected Class</div>
                    <div class='bg-gray-200 h-[170px] text-gray-500 mt-2 py-1 px-3'>${selectedClass || 'None'}</div>
                </div>
                <div>
                    <div class='bg-teal-500 py-1 px-3 text-white rounded-r-md'>Selected Class</div>
                    <div class='bg-gray-200 h-[170px] overflow-y-auto overflow-x-hidden text-gray-500 mt-2 py-1 px-3 rounded-r-md'>${selectedCourses.length > 0 ? selectedCourses.join('<br />') : 'None'}</div>
                </div>
            </div>
        `;
    }

    function submitSelectedItems() {
        document.getElementById('selected_student').value = selectedStudent;
        document.getElementById('selected_class').value = selectedClass;
        document.getElementById('selected_courses').value = selectedCourses.join(',');

        document.getElementById('selectedItemsForm').submit();
    }
    function openTab(event, tabId) {
        let i, tabContent, tabLinks;

        tabContent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabContent.length; i++) {
            tabContent[i].style.display = "none";
        }

        tabLinks = document.getElementsByTagName("a");
        for (i = 0; i < tabLinks.length; i++) {
            tabLinks[i].className = tabLinks[i].className.replace("active-tab", "");
        }

        document.getElementById(tabId).style.display = "block";
        event.currentTarget.className += " active-tab";
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("assign-course").style.display = "block";
    });
</script>

@endsection
