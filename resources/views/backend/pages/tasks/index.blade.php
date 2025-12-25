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
            <h1 class="h3 mb-0 text-gray-800">Tasks</h1>
            <button class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addTasksModal">
                + Add Task
            </button>
        </div>

        <!-- Tasks Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="taskTable" class="table table-hover mb-0">
                        <thead class="thead-light-blue">
                            <tr>
                                <th style="width: 25%;" class="font-weight-bold text-dark">Action</th>
                                <th class="font-weight-bold text-dark">Title</th>
                                <th class="font-weight-bold text-dark">Description</th>
                                <th class="font-weight-bold text-dark">Assigned Staff</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info viewBtn" data-id="{{ $task->id }}">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary editBtn" data-id="{{ $task->id }}"
                                            data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                                            data-assigned-to="{{ $task->assigned_to }}" data-status="{{ $task->status }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this task?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>

                                        <span
                                            class="badge-tiny {{ $task->status == 1 ? 'badge-tiny-active' : 'badge-tiny-inactive' }}">
                                            {{ $task->status == 1 ? 'Completed' : 'Opened' }}
                                        </span>
                                    </td>
                                    <td class="text-secondary">{{ $task->title }}</td>
                                    <td class="text-secondary">{{ $task->description }}</td>
                                    <td class="text-secondary">{{ $task->assignedStaff->name ?? 'Not Assigned' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTasksModal" tabindex="-1" role="dialog" aria-labelledby="addTaskLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskLabel">Add Task</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Task Name</label>
                            <input type="text" class="form-control" name="title" placeholder="Task title"
                                value="{{ old('title') }}">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" class="form-control" name="description" placeholder="Description"
                                value="{{ old('description') }}"></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1">Completed</option>
                                <option value="0">Opened</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Assign to Staff</label>
                            <select class="form-control" name="assigned_to">
                                <option value="">-- Select Staff --</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Task Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p><strong>Title:</strong> <span id="viewTaskName"></span></p>
                    <p><strong>Description:</strong> <span id="viewTaskDescription"></span></p>
                    <p><strong>Status:</strong> <span id="viewTaskStatus"></span></p>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="editTaskForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Task</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Task Name</label>
                            <input type="text" class="form-control" name="name" id="editTaskName">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" class="form-control" name="email" id="editTaskDescription"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Assign to Staff</label>
                            <select class="form-control" name="assigned_to" id="editTaskAssignedTo">
                                <option value="">-- Select Staff --</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" id="editTaskStatus">
                                <option value="1">Completed</option>
                                <option value="0">Open</option>
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
                    $('#addTaskModal').modal('show');
                @endif

                $('#taskTable').DataTable({
                    pageLength: 5,
                    lengthChange: true,
                    searching: true,
                    ordering: true
                });

                $(document).on('click', '.editBtn', function() {
                    const id = $(this).data('id');
                    const title = $(this).data('title');
                    const description = $(this).data('description');
                    const status = $(this).data('status');
                    const assignedTo = $(this).data('assigned-to');
                    $('#editTaskName').val(title);
                    $('#editTaskDescription').val(description);
                    $('#editTaskStatus').val(status);
                    $('#editTaskAssignedTo').val(assignedTo);
                    $('#editTaskForm').attr('action', '/tasks/' + id);
                    $('#editTaskModal').modal('show');
                });
            });
            $(document).on('click', '.viewBtn', function() {
                let id = $(this).data('id');

                $.get('/tasks/' + id, function(data) {
                    $('#viewTaskName').text(data.name);
                    $('#viewTaskDescription').text(data.description);
                    $('#viewTaskStatus').text(data.status);
                    $('#viewTaskAssignedTo').text(data.assigned_to);
                    $('#viewTaskModal').modal('show');
                });
            });
        </script>
    @endpush
@endsection
