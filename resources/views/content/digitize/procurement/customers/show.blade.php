@extends('layouts/layoutMaster')

@section('title', $customer->customer_name . ' - Customer Details')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection


@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection


@section('content')

<!-- Customer Header -->
<div class="row g-6 mb-6">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg me-4">
                                <span class="avatar-initial rounded bg-label-primary fs-2 fw-bold">
                                    {{ strtoupper(substr($customer->customer_name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ $customer->customer_name }}</h4>
                                <p class="text-muted mb-0">{{ $customer->customer_code ?: 'No code assigned' }}</p>
                                <div class="d-flex align-items-center mt-1">
                                    <span class="badge bg-{{ $customer->status === 'active' ? 'success' : 'secondary' }} me-2">
                                        {{ ucfirst($customer->status) }}
                                    </span>
                                    @if($customer->customer_type)
                                    <span class="badge bg-label-info me-2">{{ ucfirst($customer->customer_type) }}</span>
                                    @endif
                                    @if($customer->is_vip)
                                    <span class="badge bg-label-warning">VIP</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <div class="btn-group" role="group">
                            <a href="{{ route('procurement.customers.edit', $customer->id_customer) }}" class="btn btn-primary">
                                <i class="bx bx-edit me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="toggleStatus('{{ $customer->id_customer }}', '{{ $customer->status }}')">
                                    <i class="bx bx-{{ $customer->status === 'active' ? 'x' : 'check' }}-circle me-1"></i>
                                    {{ $customer->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('procurement.customers.analytics', $customer->id_customer) }}">
                                    <i class="bx bx-line-chart me-1"></i>Analytics Report
                                </a></li>
                                <li><a class="dropdown-item" href="#" onclick="exportCustomerData('{{ $customer->id_customer }}')">
                                    <i class="bx bx-export me-1"></i>Export Data
                                </a></li>
                            </ul>
                        </div>
                        <a href="{{ route('procurement.customers.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bx bx-arrow-back me-1"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Row -->
<div class="row g-6 mb-6">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-md mx-auto mb-3">
                    <span class="avatar-initial rounded bg-label-success">
                        <i class="bx bx-file fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">{{ $stats['total_requests'] ?? 0 }}</h4>
                <p class="mb-0">Total Requests</p>
                <small class="text-muted">{{ $stats['completed_requests'] ?? 0 }} completed</small>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-md mx-auto mb-3">
                    <span class="avatar-initial rounded bg-label-info">
                        <i class="bx bx-money fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">Rp {{ number_format($stats['total_value'] ?? 0, 0, ',', '.') }}</h4>
                <p class="mb-0">Total Value</p>
                <small class="text-muted">All time</small>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-md mx-auto mb-3">
                    <span class="avatar-initial rounded bg-label-warning">
                        <i class="bx bx-calendar fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">{{ $stats['avg_request_days'] ?? 0 }}</h4>
                <p class="mb-0">Avg Completion</p>
                <small class="text-muted">Days</small>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-md mx-auto mb-3">
                    <span class="avatar-initial rounded bg-label-primary">
                        <i class="bx bx-time fs-4"></i>
                    </span>
                </div>
                <h4 class="mb-0">{{ $stats['last_request_days'] ?? 'N/A' }}</h4>
                <p class="mb-0">Last Request</p>
                <small class="text-muted">Days ago</small>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row g-6">
    <!-- Left Column - Customer Information -->
    <div class="col-12 col-lg-8">
        <!-- Contact Information -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Contact Information</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Contact Person</h6>
                        <p class="mb-0">{{ $customer->contact_person ?: 'Not specified' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Email</h6>
                        <p class="mb-0">
                            @if($customer->contact_email)
                                <a href="mailto:{{ $customer->contact_email }}">{{ $customer->contact_email }}</a>
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Phone</h6>
                        <p class="mb-0">
                            @if($customer->contact_phone)
                                <a href="tel:{{ $customer->contact_phone }}">{{ $customer->contact_phone }}</a>
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Tax ID / NPWP</h6>
                        <p class="mb-0">{{ $customer->tax_id ?: 'Not specified' }}</p>
                    </div>
                    @if($customer->address)
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Primary Address</h6>
                        <p class="mb-0">{{ $customer->address }}</p>
                        @if($customer->city || $customer->postal_code)
                        <small class="text-muted">{{ $customer->city }}{{ $customer->city && $customer->postal_code ? ', ' : '' }}{{ $customer->postal_code }}</small>
                        @endif
                    </div>
                    @endif
                    @if($customer->billing_address && $customer->billing_address !== $customer->address)
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Billing Address</h6>
                        <p class="mb-0">{{ $customer->billing_address }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Business Terms -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Business Terms & Settings</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Payment Terms</h6>
                        <p class="mb-0">{{ $customer->payment_terms ? $customer->payment_terms . ' days' : 'Not specified' }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Credit Limit</h6>
                        <p class="mb-0">
                            @if($customer->credit_limit > 0)
                                Rp {{ number_format($customer->credit_limit, 0, ',', '.') }}
                            @else
                                Unlimited
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Customer Type</h6>
                        <p class="mb-0">{{ $customer->customer_type ? ucfirst($customer->customer_type) : 'Not specified' }}</p>
                    </div>
                    
                    <div class="col-12">
                        <h6 class="text-muted mb-2">Customer Capabilities</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @if($customer->is_vip)
                            <span class="badge bg-warning">VIP Customer</span>
                            @endif
                            @if($customer->allow_credit)
                            <span class="badge bg-success">Credit Allowed</span>
                            @else
                            <span class="badge bg-secondary">Cash Only</span>
                            @endif
                            @if($customer->auto_approve)
                            <span class="badge bg-info">Auto Approve</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($customer->notes)
                    <div class="col-12">
                        <h6 class="text-muted mb-2">Notes</h6>
                        <p class="mb-0">{{ $customer->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Requests -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Procurement Requests</h5>
                <a href="{{ route('procurement.customers.request_history', $customer->id_customer) }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Request #</th>
                            <th>Title</th>
                            <th>Items</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRequests as $request)
                        <tr>
                            <td>
                                <a href="{{ route('procurement.requests.show', $request->id_procurement_request) }}" class="fw-medium">
                                    {{ $request->request_number }}
                                </a>
                            </td>
                            <td>
                                <span class="fw-medium">{{ Str::limit($request->title, 30) }}</span>
                                @if($request->priority === 'urgent')
                                <span class="badge badge-sm bg-danger ms-1">!</span>
                                @elseif($request->priority === 'high')
                                <span class="badge badge-sm bg-warning ms-1">!</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-label-secondary">{{ $request->items->count() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ \App\Enums\procurement\ProcurementRequestStatus::from($request->status)->color() }}">
                                    {{ \App\Enums\procurement\ProcurementRequestStatus::from($request->status)->label() }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress me-3" style="height: 6px; width: 80px;">
                                        <div class="progress-bar" style="width: {{ $request->getProgressPercentage() }}%"></div>
                                    </div>
                                    <span class="text-muted small">{{ $request->getProgressPercentage() }}%</span>
                                </div>
                            </td>
                            <td>{{ $request->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('procurement.requests.show', $request->id_procurement_request) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-show"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="bx bx-file fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No procurement requests yet</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column - Analytics & Actions -->
    <div class="col-12 col-lg-4">
        <!-- Request Trends Chart -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Request Trends</h5>
            </div>
            <div class="card-body">
                <div id="requestTrendsChart"></div>
                
                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Completion Rate</span>
                        <span class="fw-medium">{{ number_format($analytics['completion_rate'] ?? 85, 1) }}%</span>
                    </div>
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: {{ $analytics['completion_rate'] ?? 85 }}%"></div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">On-Time Delivery</span>
                        <span class="fw-medium">{{ number_format($analytics['ontime_rate'] ?? 78, 1) }}%</span>
                    </div>
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-info" style="width: {{ $analytics['ontime_rate'] ?? 78 }}%"></div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Satisfaction Score</span>
                        <span class="fw-medium">{{ number_format($analytics['satisfaction_score'] ?? 92, 1) }}%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: {{ $analytics['satisfaction_score'] ?? 92 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('procurement.requests.create') }}?customer_id={{ $customer->id_customer }}" class="btn btn-primary">
                        <i class="bx bx-plus me-2"></i>New Request
                    </a>
                    <button type="button" class="btn btn-outline-info" onclick="sendQuote('{{ $customer->id_customer }}')">
                        <i class="bx bx-message-dots me-2"></i>Send Quote
                    </button>
                    <a href="{{ route('procurement.customers.analytics', $customer->id_customer) }}" class="btn btn-outline-secondary">
                        <i class="bx bx-line-chart me-2"></i>View Analytics
                    </a>
                    @if($customer->contact_email)
                    <a href="mailto:{{ $customer->contact_email }}" class="btn btn-outline-secondary">
                        <i class="bx bx-envelope me-2"></i>Send Email
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Customer Summary -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Customer Summary</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Customer Since</small>
                    <p class="mb-0 fw-medium">{{ $customer->created_at->format('M d, Y') }}</p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Last Updated</small>
                    <p class="mb-0 fw-medium">{{ $customer->updated_at->format('M d, Y') }}</p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Customer Rating</small>
                    <div class="d-flex align-items-center mt-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bx bx{{ $i <= ($customerRating ?? 4) ? 's' : '' }}-star text-warning me-1"></i>
                        @endfor
                        <span class="text-muted ms-2">({{ $customerRating ?? 4 }}/5)</span>
                    </div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Account Status</small>
                    <div class="mt-1">
                        <span class="badge bg-{{ $customer->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($customer->status) }}
                        </span>
                        @if($customer->is_vip)
                        <span class="badge bg-warning ms-1">VIP</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Chart data
window.requestTrendsData = @json($requestTrendsChart ?? []);

function toggleStatus(customerId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this customer?`)) {
        fetch(`{{ route('procurement.customers.toggle_status', ':id') }}`.replace(':id', customerId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function sendQuote(customerId) {
    // Implementation for sending quote
    alert('Quote sending functionality to be implemented');
}

function exportCustomerData(customerId) {
    window.location.href = `{{ route('procurement.customers.export') }}?customer_id=${customerId}`;
}
</script>

@endsection