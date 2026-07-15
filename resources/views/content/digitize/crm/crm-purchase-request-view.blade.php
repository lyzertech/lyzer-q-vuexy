@extends('layouts/layoutMaster')

@section('title', 'Purchase Request Detail')

@section('content')

    <div class="row">
        {{-- Left: Display --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Purchase Request Detail</h5>
                    <a href="{{ route('crm-purchase-request') }}" class="btn btn-label-secondary btn-sm">
                        <i class="ti ti-arrow-left me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="40%">PR Number</th>
                                <td>{{ $purchase_request->pr_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>{{ $purchase_request->title ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Requested By</th>
                                <td>{{ $purchase_request->requested_by ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>{{ $purchase_request->department ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Priority</th>
                                <td>
                                    @php
                                        $priorityMap = [
                                            'Low'    => 'bg-label-secondary',
                                            'Medium' => 'bg-label-info',
                                            'High'   => 'bg-label-warning',
                                            'Urgent' => 'bg-label-danger',
                                        ];
                                        $priorityCls = $priorityMap[$purchase_request->priority] ?? 'bg-label-secondary';
                                    @endphp
                                    <span class="badge {{ $priorityCls }}">{{ $purchase_request->priority ?? '-' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @php
                                        $statusMap = [
                                            'Pending'  => 'bg-label-warning',
                                            'Approved' => 'bg-label-success',
                                            'Rejected' => 'bg-label-danger',
                                        ];
                                        $statusCls = $statusMap[$purchase_request->status] ?? 'bg-label-secondary';
                                    @endphp
                                    <span class="badge {{ $statusCls }}">{{ $purchase_request->status ?? '-' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Notes</th>
                                <td>{{ $purchase_request->notes ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $purchase_request->created_at ? $purchase_request->created_at->format('Y-m-d H:i') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $purchase_request->updated_at ? $purchase_request->updated_at->format('Y-m-d H:i') : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Edit Form --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Edit Purchase Request</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="post"
                        action="{{ route('crm-purchase-request-edit', ['id_purchase_request' => $purchase_request->id_purchase_request]) }}">
                        @csrf
                        @method('POST')

                        <div class="mb-3">
                            <label class="form-label" for="edit-pr-number">PR Number</label>
                            <input type="text" class="form-control" id="edit-pr-number" name="pr_number"
                                value="{{ $purchase_request->pr_number }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="edit-title">Title</label>
                            <input type="text" class="form-control" id="edit-title" name="title"
                                value="{{ $purchase_request->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="edit-requested-by">Requested By</label>
                            <input type="text" class="form-control" id="edit-requested-by" name="requested_by"
                                value="{{ $purchase_request->requested_by }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="edit-department">Department</label>
                            <input type="text" class="form-control" id="edit-department" name="department"
                                value="{{ $purchase_request->department }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="edit-priority">Priority</label>
                            <select class="form-control" id="edit-priority" name="priority" required>
                                @foreach (['Low', 'Medium', 'High', 'Urgent'] as $p)
                                    <option value="{{ $p }}"
                                        {{ $purchase_request->priority === $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="edit-status">Status</label>
                            <select class="form-control" id="edit-status" name="status" required>
                                @foreach (['Pending', 'Approved', 'Rejected'] as $s)
                                    <option value="{{ $s }}"
                                        {{ $purchase_request->status === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="edit-notes">Notes</label>
                            <textarea class="form-control" id="edit-notes" name="notes" rows="3">{{ $purchase_request->notes }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Update</button>
                        <a href="{{ route('crm-purchase-request') }}" class="btn btn-label-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
