@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl pt-10 pb-10 bg-gray-50 shadow-lg rounded-lg p-6">
    <h2 class="text-3xl font-semibold text-center text-teal-700 mb-8">Student Selections</h2>

    <div class="gap-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($selections as $selection)
            <div class="bg-white rounded-lg shadow-md p-6 transform transition duration-200 hover:scale-105 hover:shadow-lg">
                <!-- Card Header -->
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-teal-800">{{ $selection->student_name }}</h3>
                </div>

                <!-- Email Info -->
                <div class="mt-4 space-y-3">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M2 6a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm16 2.243l-5.374 4.31a2 2 0 01-2.252 0L4 8.243V18h16V8.243zM4.838 6L12 10.758 19.162 6H4.838z"/></svg>
                        <span class="text-gray-700">{{ $selection->email }}</span>
                    </div>

                    <!-- Editable Course Names -->
                    <div class="mt-2">
                        <div class="flex items-start space-x-2 text-teal-800">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4a2 2 0 012 2v14a2 2 0 01-4 0V6a2 2 0 012-2zM4 4h4a2 2 0 110 4H4a2 2 0 110-4zm12 0h4a2 2 0 110 4h-4a2 2 0 110-4zM4 14h4a2 2 0 110 4H4a2 2 0 110-4zm12 0h4a2 2 0 110 4h-4a2 2 0 110-4z"/></svg>
                            <div>
                                <h4 class="font-semibold text-sm">Courses Enrolled:</h4>
                                
                                <!-- Editable Input Field for Course Names -->
                                <div id="courseDisplay_{{ $selection->id }}">
                                    <p class="text-gray-700 text-sm">{{ $selection->course_names }}</p>
                                    <button class="text-teal-500 text-sm underline hover:text-teal-700" onclick="editCourseNames({{ $selection->id }})">Edit</button>
                                </div>
                                
                                <div id="courseEdit_{{ $selection->id }}" class="hidden">
                                    <input type="text" id="courseNamesInput_{{ $selection->id }}" value="{{ $selection->course_names }}" class="border border-teal-300 rounded px-2 py-1 w-full mt-1 text-sm">
                                    <button class="mt-2 bg-teal-500 text-white py-1 px-4 rounded hover:bg-teal-600" onclick="saveCourseNames({{ $selection->id }})">Save</button>
                                    <button class="mt-2 bg-gray-300 text-gray-700 py-1 px-4 rounded hover:bg-gray-400" onclick="cancelEdit({{ $selection->id }})">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function editCourseNames(id) {
    document.getElementById(`courseDisplay_${id}`).classList.add('hidden');
    document.getElementById(`courseEdit_${id}`).classList.remove('hidden');
}

function cancelEdit(id) {
    document.getElementById(`courseDisplay_${id}`).classList.remove('hidden');
    document.getElementById(`courseEdit_${id}`).classList.add('hidden');
}

async function saveCourseNames(id) {
    const newCourseNames = document.getElementById(`courseNamesInput_${id}`).value;

    try {
        const response = await fetch(`/update-course-names/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ course_names: newCourseNames }),
        });

        if (response.ok) {
            document.getElementById(`courseDisplay_${id}`).querySelector('p').innerText = newCourseNames;
            cancelEdit(id);
        } else {
            alert('Failed to update course names.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}
</script>
@endsection