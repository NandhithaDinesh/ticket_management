@extends('backend.layouts.master')

@section('content')
    <div class="container-fluid">

        {{-- Success / Error Messages --}}
        @if (session('success'))
            <div id="toast" class="toast-message success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div id="toast" class="toast-message error">{{ session('error') }}</div>
        @endif

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Staffs</h1>
            <button class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addStaffsModal">
                + Add Staff
            </button>
        </div>

        <!-- Staff Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="staffTable" class="table table-hover mb-0">
                        <thead class="thead-light-blue">
                            <tr>
                                <th style="width: 25%;" class="font-weight-bold text-dark">Action</th>
                                <th class="font-weight-bold text-dark">Name</th>
                                <th class="font-weight-bold text-dark">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffs as $staff)
                                <tr>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info viewBtn" data-id="{{ $staff->id }}">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary editBtn" data-id="{{ $staff->id }}"
                                            data-name="{{ $staff->name }}" data-email="{{ $staff->email }}"
                                            data-status="{{ $staff->status }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <form action="{{ route('staffs.destroy', $staff->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this staff?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>

                                        <span
                                            class="badge-tiny {{ $staff->status == 1 ? 'badge-tiny-active' : 'badge-tiny-inactive' }}">
                                            {{ $staff->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-secondary">{{ $staff->name }}</td>
                                    <td class="text-secondary">{{ $staff->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffsModal" tabindex="-1" role="dialog" aria-labelledby="addStaffLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('staffs.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStaffLabel">Add Staff</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Staff Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Staff name"
                                value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Email"
                                value="{{ old('email') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                placeholder="Confirm Password">
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewStaffModal" tabindex="-1" role="dialog" aria-labelledby="viewStaffLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Staff Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="viewStaffName"></span></p>
                    <p><strong>Email:</strong> <span id="viewStaffEmail"></span></p>
                    <p><strong>Status:</strong> <span id="viewStaffStatus"></span></p>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Edit Staff Modal -->
    <div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="editStaffForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Staff</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Staff Name</label>
                            <input type="text" class="form-control" name="name" id="editStaffName">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" id="editStaffEmail">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" id="editStaffStatus">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {

                @if ($errors->any())
                    $('#addStaffsModal').modal('show');
                @endif

                $('#staffTable').DataTable({
                    pageLength: 5,
                    lengthChange: true,
                    searching: true,
                    ordering: true
                });

                $(document).on('click', '.editBtn', function() {
                    const id = $(this).data('id');
                    const name = $(this).data('name');
                    const email = $(this).data('email');
                    const status = $(this).data('status');

                    $('#editStaffName').val(name);
                    $('#editStaffEmail').val(email);
                    $('#editStaffStatus').val(status);
                    $('#editStaffForm').attr('action', '/staffs/' + id);
                    $('#editStaffModal').modal('show');
                });
            });
            $(document).on('click', '.viewBtn', function() {
                let id = $(this).data('id');

                $.get('/staffs/' + id, function(data) {
                    $('#viewStaffName').text(data.name);
                    $('#viewStaffEmail').text(data.email);
                    $('#viewStaffStatus').text(data.status);

                    $('#viewStaffModal').modal('show');
                });
            });
        </script>
    @endpush
@endsection
