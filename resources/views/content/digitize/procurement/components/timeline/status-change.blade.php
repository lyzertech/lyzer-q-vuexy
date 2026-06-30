<!-- Status Change Timeline Item -->
<div class="timeline-item">
    <span class="timeline-indicator timeline-indicator-warning">
        <i class="bx bx-transfer-alt fs-6"></i>
    </span>
    <div class="timeline-event">
        <div class="timeline-header">
            <div class="d-flex align-items-center">
                <i class="bx bx-flag me-2 text-warning"></i>
                <h6 class="mb-0">Status Changed</h6>
                <small class="text-muted ms-auto">{{ $history->created_at->diffForHumans() }}</small>
            </div>
        </div>
        <div class="timeline-body mt-2">
            <div class="card border-start border-warning border-3">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center mb-2">
                        @if($history->old_status)
                            <span class="badge bg-label-secondary me-2">{{ ucwords(str_replace('_', ' ', $history->old_status)) }}</span>
                            <i class="bx bx-chevron-right mx-2 text-muted"></i>
                        @endif
                        <span class="badge bg-label-primary">{{ ucwords(str_replace('_', ' ', $history->new_status)) }}</span>
                    </div>
                    
                    @if($history->note)
                    <p class="text-muted mb-2">
                        <i class="bx bx-note me-1"></i>
                        {{ $history->note }}
                    </p>
                    @endif

                    <div class="d-flex align-items-center justify-content-between">
                        <small class="text-muted">
                            @if($history->item)
                                <i class="bx bx-package me-1"></i>
                                <strong>Item:</strong> {{ $history->item->product_name }}
                            @else
                                <i class="bx bx-file me-1"></i>
                                <strong>Request Status</strong>
                            @endif
                        </small>
                        <small class="text-muted">
                            <i class="bx bx-user me-1"></i>
                            {{ $history->changedBy->name }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>