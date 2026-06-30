<!-- System Comment Timeline Item -->
<div class="timeline-item">
    <span class="timeline-indicator timeline-indicator-info">
        <i class="bx bx-info-circle fs-6"></i>
    </span>
    <div class="timeline-event">
        <div class="timeline-header">
            <div class="d-flex align-items-center">
                <i class="bx bx-cog me-2 text-muted"></i>
                <h6 class="mb-0 text-muted">System</h6>
                <small class="text-muted ms-auto">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        </div>
        <div class="timeline-body mt-2">
            <div class="alert alert-info alert-dismissible mb-0" role="alert">
                <span class="alert-icon rounded">
                    <i class="bx bx-info-circle"></i>
                </span>
                <div class="alert-text">
                    <strong>{{ $comment->message }}</strong>
                    @if($comment->user && $comment->user->id !== auth()->id())
                        <br><small class="text-muted">by {{ $comment->user->name }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>