@extends('backend.layouts.master')
@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">My Assigned Tasks</h3>

        <div class="row">
            @forelse ($tasks as $task)
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card task-card 
                    {{ $task->status == 0 ? 'border-left-warning' : 'border-left-success' }} 
                    shadow h-100 py-2"
                        data-id="{{ $task->id }}">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div
                                        class="text-xs font-weight-bold 
                                    {{ $task->status == 0 ? 'text-warning' : 'text-success' }} 
                                    text-uppercase mb-1">
                                        {{ $task->title }}
                                    </div>
                                    <p class="text-muted mb-2">{{ Str::limit($task->description, 60) }}</p>
                                    <span
                                        class="badge 
                                    {{ $task->status == 0 ? 'badge-warning' : 'badge-success' }}">
                                        {{ $task->status == 0 ? 'Open' : 'Completed' }}
                                    </span>
                                    <p class="mt-2 mb-0 small text-gray-600">
                                        Assigned on: {{ $task->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">No tasks assigned to you yet.</div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Task Detail Modal -->
    <div class="modal fade" id="taskDetailModal" tabindex="-1" role="dialog" aria-labelledby="taskDetailLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="updateStatusForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <p id="taskDescription" class="text-muted"></p>
                        <p><strong>Assigned On:</strong> <span id="taskCreated"></span></p>
                        <div class="form-group">
                            <label for="taskStatus">Status</label>
                            <select class="form-control" id="taskStatus" name="status">
                                <option value="0">Open</option>
                                <option value="1">Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {


                $(document).on('click', '.task-card', function() {
                    let taskId = $(this).data('id');

                    $.get(`/staff/tasks/${taskId}`, function(data) {
                        $('#taskTitle').text(data.title);
                        $('#taskDescription').text(data.description);
                        $('#taskCreated').text(data.created_at);
                        $('#taskStatus').val(data.status);
                        $('#updateStatusForm').attr('data-id', data.id);
                        $('#taskDetailModal').modal('show');
                    });
                });


                $('#updateStatusForm').submit(function(e) {
                    e.preventDefault();
                    let taskId = $(this).attr('data-id');
                    let status = $('#taskStatus').val();

                    $.ajax({
                        url: `/staff/tasks/${taskId}/update-status`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#taskDetailModal').modal('hide');
                                location.reload(); // refresh to update card color/status
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
