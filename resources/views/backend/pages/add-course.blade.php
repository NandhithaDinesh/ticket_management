@extends('backend.layouts.master')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Course</h1>


        </div>
        <!-- Content Row -->
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class ="col-md-12">
                <form class="user" action="{{ route('admin.course.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control form-control-user" id="exampleCourseTitle"
                                name="course_title" value="{{ old('course_title"') }}" placeholder="Course title">
                            @error('course_title"')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-user" id="exampleMobie" name="price"
                                value="{{ old('price') }}" placeholder="Price">
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group row">
                        <textarea class="form-control form-control-user" id="exampleDescription" name="description" placeholder="Description">{{ old('description') }}</textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 mb-3 mb-sm-0">
                        </div>
                        <div class="col-sm-2 mb-3 mb-sm-0">
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Save
                            </button>
                        </div>
                        <hr>

                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
