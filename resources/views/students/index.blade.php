@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Students</h2>
            </div>
            <div class="pull-right">
                @can('student-create')
                <a class="btn btn-success" href="{{ route('students.create') }}"> Create New Student</a>
                @endcan
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($students as $student)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $student->name }}</td>
	        <td>{{ $student->detail }}</td>
	        <td>
                <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('students.show', $student->id) }}">Show</a>
                    @can('student-edit')
                    <a class="btn btn-primary" href="{{ route('students.edit', $student->id) }}">Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('student-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>

    {!! $students->links() !!}

<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>

@endsection
