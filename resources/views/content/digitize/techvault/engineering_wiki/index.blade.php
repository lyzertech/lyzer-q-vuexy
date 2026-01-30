@extends('layouts/layoutMaster')

@section('title', 'Engineering Wiki')

@section('content')

    <div class="row g-6">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold py-3 mb-0">Engineering Wiki</h4>
                <a href="{{ route('techvault-engineeringwiki.create') }}" class="btn btn-primary">Add New Wiki</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="GET">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Title</th>
                                        <th>Customer Name</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Device Type</th>
                                        <th>Status</th>
                                        <th>Priority</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <select name="category" class="form-select form-select-sm">
                                                <option value="">Category</option>
                                                <option value="issue" @selected(request('category') == 'issue')>Issue</option>
                                                <option value="update" @selected(request('category') == 'update')>Update</option>
                                                <option value="note" @selected(request('category') == 'note')>Note</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="brand" class="form-select form-select-sm">
                                                <option value="">Brand</option>
                                                @foreach ($brands ?? [] as $brand)
                                                    <option value="{{ $brand }}" @selected(request('brand') == $brand)>
                                                        {{ $brand }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="device_type" class="form-select form-select-sm">
                                                <option value="">Device Type</option>
                                                @foreach ($deviceTypes ?? [] as $type)
                                                    <option value="{{ $type }}" @selected(request('device_type') == $type)>
                                                        {{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="status" class="form-select form-select-sm">
                                                <option value="">Status</option>
                                                <option value="open" @selected(request('status') == 'open')>Open</option>
                                                <option value="monitoring" @selected(request('status') == 'monitoring')>Monitoring</option>
                                                <option value="solved" @selected(request('status') == 'solved')>Solved</option>
                                                <option value="closed" @selected(request('status') == 'closed')>Closed</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="priority" class="form-select form-select-sm">
                                                <option value="">Priority</option>
                                                <option value="low" @selected(request('priority') == 'low')>Low</option>
                                                <option value="medium" @selected(request('priority') == 'medium')>Medium</option>
                                                <option value="high" @selected(request('priority') == 'high')>High</option>
                                                <option value="critical" @selected(request('priority') == 'critical')>Critical</option>
                                            </select>
                                        </td>
                                        <td></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-secondary btn-sm w-100"
                                                    type="submit">Filter</button>
                                                <a href="{{ route('techvault-engineeringwiki') }}"
                                                    class="btn btn-outline-danger btn-sm w-100">Reset</a>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($wikis as $wiki)
                                        <tr>
                                            <td>{{ $wiki->title }}</td>
                                            <td>{{ $wiki->customer_name }}</td>
                                            <td>
                                                <span
                                                    class="badge
                                                @if ($wiki->category == 'issue') bg-danger
                                                @elseif($wiki->category == 'update') bg-warning text-dark
                                                @elseif($wiki->category == 'note') bg-info
                                                @else bg-secondary @endif
                                            ">
                                                    {{ ucfirst($wiki->category) }}
                                                </span>
                                            </td>
                                            <td>{{ $wiki->brand }}</td>
                                            <td>{{ $wiki->device_type }}</td>
                                            <td>@include(
                                                'content.digitize.techvault.engineering_wiki.partials.status_badge',
                                                ['status' => $wiki->status]
                                            )</td>
                                            <td>@include(
                                                'content.digitize.techvault.engineering_wiki.partials.priority_badge',
                                                ['priority' => $wiki->priority]
                                            )</td>
                                            <td>{{ $wiki->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="{{ route('techvault-engineeringwiki.show', $wiki) }}"
                                                    class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('techvault-engineeringwiki.edit', $wiki) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('techvault-engineeringwiki.destroy', $wiki) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete this wiki?')">Delete</button>
                                                </form>
                                                <a href="#" class="btn btn-sm btn-secondary" title="Report">
                                                    <i class="fa fa-file-alt mx-2"></i>Report
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No records found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                    </div>
                    <div class="mt-3">
                        {{ $wikis->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
