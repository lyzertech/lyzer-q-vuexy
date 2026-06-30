<!-- Arrival Timeline Item -->
<div class="timeline-item">
    <span class="timeline-indicator timeline-indicator-success">
        <i class="bx bx-package fs-6"></i>
    </span>
    <div class="timeline-event">
        <div class="timeline-header">
            <div class="d-flex align-items-center">
                <i class="bx bx-check-circle me-2 text-success"></i>
                <h6 class="mb-0 text-success">Arrival Recorded</h6>
                <small class="text-muted ms-auto">{{ $arrival->created_at->diffForHumans() }}</small>
            </div>
        </div>
        <div class="timeline-body mt-2">
            <div class="card border-start border-success border-3">
                <div class="card-body py-3">
                    <div class="row align-items-center mb-3">
                        <div class="col-8">
                            <h6 class="mb-1">{{ $arrival->item->product_name }}</h6>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-label-success me-2">
                                    +{{ number_format($arrival->qty, 2) }} {{ $arrival->item->unit }}
                                </span>
                                @if($arrival->warehouse)
                                <small class="text-muted">
                                    <i class="bx bx-buildings me-1"></i>{{ $arrival->warehouse }}
                                </small>
                                @endif
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <small class="text-muted d-block">Arrival Date</small>
                            <strong>{{ $arrival->arrival_date->format('M d, Y') }}</strong>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    @php
                        $totalRequested = $arrival->item->requested_qty;
                        $currentArrived = $arrival->item->arrived_qty;
                        $progressPercentage = $totalRequested > 0 ? ($currentArrived / $totalRequested) * 100 : 0;
                    @endphp
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="text-muted">Progress</small>
                            <small class="text-muted">{{ number_format($currentArrived, 2) }} / {{ number_format($totalRequested, 2) }} {{ $arrival->item->unit }}</small>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: {{ min(100, $progressPercentage) }}%"></div>
                        </div>
                        <small class="text-muted">{{ number_format($progressPercentage, 1) }}% received</small>
                    </div>

                    @if($arrival->note)
                    <div class="alert alert-light border-0 mb-3">
                        <i class="bx bx-note me-2"></i>
                        <span class="text-muted">{{ $arrival->note }}</span>
                    </div>
                    @endif

                    <div class="d-flex align-items-center justify-content-between">
                        <small class="text-muted">
                            <i class="bx bx-user me-1"></i>
                            Recorded by {{ $arrival->createdBy->name }}
                        </small>
                        
                        @if($arrival->item->remaining_qty <= 0)
                        <span class="badge bg-success">
                            <i class="bx bx-check me-1"></i>Complete
                        </span>
                        @else
                        <small class="text-warning">
                            <i class="bx bx-time me-1"></i>
                            {{ number_format($arrival->item->remaining_qty, 2) }} {{ $arrival->item->unit }} remaining
                        </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>