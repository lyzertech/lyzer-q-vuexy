@extends('layouts/layoutMaster')

@section('title', 'Inquiry Detail')

@section('content')

    <div class="row">
        {{-- Left: Project Information --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Project Information</h5>
                    <a href="{{ route('crm-inquiry') }}" class="btn btn-label-secondary btn-sm">
                        <i class="ti ti-arrow-left me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="40%">Project</th>
                                <td><strong>{{ $inquiry->title ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <th>PIC Sales</th>
                                <td>{{ $inquiry->pic_sales ?? '-' }}</td>
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
                                        $priorityCls = $priorityMap[$inquiry->priority] ?? 'bg-label-secondary';
                                    @endphp
                                    <span class="badge {{ $priorityCls }}">{{ $inquiry->priority ?? '-' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Products</th>
                                <td><strong>{{ $relatedInquiries->count() }}</strong> items</td>
                            </tr>
                            <tr>
                                <th>Notes</th>
                                <td>{{ $inquiry->notes ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $inquiry->created_at ? $inquiry->created_at->format('Y-m-d H:i') : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Product List --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Products in this Project</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Inquiry #</th>
                                    <th>Product Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relatedInquiries as $item)
                                <tr class="{{ $item->id_inquiry == $inquiry->id_inquiry ? 'table-active' : '' }}">
                                    <td>
                                        <small>{{ $item->inquiry_number }}</small>
                                    </td>
                                    <td>{{ $item->product_type ?? '-' }}</td>
                                    <td>
                                        @php
                                            $statusMap = [
                                                'Waiting Supplier Feedback' => 'bg-label-warning',
                                                'Updated by Purchasing' => 'bg-label-info',
                                                'Pending'  => 'bg-label-info',
                                                'Approved' => 'bg-label-success',
                                                'Rejected' => 'bg-label-danger',
                                            ];
                                            $statusCls = $statusMap[$item->status] ?? 'bg-label-secondary';
                                        @endphp
                                        <span class="badge {{ $statusCls }}">{{ $item->status }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Product Details & Supplier Information --}}
    <div class="row">
        @foreach($relatedInquiries as $item)
        <div class="col-md-6 mb-4">
            <div class="card h-100 {{ $item->id_inquiry == $inquiry->id_inquiry ? 'border-primary' : '' }}">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="ti ti-package me-1"></i>
                        {{ $item->product_type ?? 'Product' }}
                    </h6>
                    <small class="text-muted">{{ $item->inquiry_number }}</small>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tbody>
                            <tr>
                                <th width="45%">Price Information</th>
                                <td>{{ $item->price_information ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Lead Time</th>
                                <td>{{ $item->lead_time ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>MOQ</th>
                                <td>{{ $item->moq ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Availability</th>
                                <td>{{ $item->availability_status ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Shipping Terms</th>
                                <td>{{ $item->shipping_terms ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Validity Period</th>
                                <td>{{ $item->validity_period ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Update Supplier Information Form - Only for Purchasing role --}}
    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role_id == 8)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Update Supplier Information</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="post" action="{{ route('crm-inquiry-batch-update') }}">
                        @csrf
                        @method('POST')

                        @foreach($relatedInquiries as $index => $item)
                        <div class="card mb-4 border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="ti ti-package me-1"></i>
                                    {{ $item->product_type ?? 'Product' }} 
                                    <small class="text-muted">- {{ $item->inquiry_number }}</small>
                                </h6>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="inquiries[{{ $index }}][id]" value="{{ $item->id_inquiry }}">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Price Information</label>
                                            <textarea class="form-control" name="inquiries[{{ $index }}][price_information]" rows="2">{{ $item->price_information }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Lead Time Information</label>
                                            <input type="text" class="form-control" name="inquiries[{{ $index }}][lead_time]" value="{{ $item->lead_time }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">MOQ (Minimum Order Quantity)</label>
                                            <input type="text" class="form-control" name="inquiries[{{ $index }}][moq]" value="{{ $item->moq }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Availability / Stock Status</label>
                                            <input type="text" class="form-control" name="inquiries[{{ $index }}][availability_status]" value="{{ $item->availability_status }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Shipping Terms</label>
                                            <input type="text" class="form-control" name="inquiries[{{ $index }}][shipping_terms]" value="{{ $item->shipping_terms }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Validity Period</label>
                                            <input type="text" class="form-control" name="inquiries[{{ $index }}][validity_period]" value="{{ $item->validity_period }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Update All Supplier Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection
