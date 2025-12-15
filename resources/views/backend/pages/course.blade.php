@extends('backend.layouts.master')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Course</h1>
            <a href="{{ route('admin.course.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add Course</a>

        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">

                <table id="courseTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 250px;"> Action</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.course.edit', $course->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.course.destroy', $course->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                                    </form>
                                <td>{{ $course->course_title }}</td>
                                <td>{{ $course->description }}</td>
                                <td>{{ $course->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- /.container-fluid -->
@endsection
