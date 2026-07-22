@php
    $marginLeft = $level * 40; // 40px indent per level
@endphp

<div class="comment-item mb-3" style="margin-left: {{ $marginLeft }}px;">
    <div class="d-flex gap-3">
        <div class="avatar avatar-sm flex-shrink-0">
            <span class="avatar-initial rounded-circle bg-label-secondary">
                <i class="ti ti-user"></i>
            </span>
        </div>
        <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-start mb-1">
                <div>
                    <h6 class="mb-0">{{ $comment->user->name ?? 'Unknown' }}</h6>
                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
                @if($comment->user_id === auth()->id())
                    <form method="POST" action="{{ route('crm-purchase-request-delete-comment', $comment->id) }}" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-text-danger">
                            <i class="ti ti-trash"></i>
                        </button>
                    </form>
                @endif
            </div>
            <p class="mb-2">{{ $comment->content }}</p>

            {{-- Reply Button --}}
            <button type="button" class="btn btn-sm btn-text-primary reply-btn" data-comment-id="{{ $comment->id }}">
                <i class="ti ti-corner-down-right me-1"></i>Reply
            </button>

            {{-- Reply Form (hidden by default) --}}
            <div class="reply-form mt-2" id="reply-form-{{ $comment->id }}" style="display: none;">
                <form method="POST" action="{{ route('crm-purchase-request-add-comment', $comment->commentable_id) }}">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <div class="d-flex gap-2">
                        <textarea name="content" class="form-control form-control-sm" rows="2" placeholder="Write a reply..." required></textarea>
                        <div class="d-flex flex-column gap-1">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="ti ti-send"></i>
                            </button>
                            <button type="button" class="btn btn-label-secondary btn-sm cancel-reply" data-comment-id="{{ $comment->id }}">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Nested Replies --}}
            @if($comment->replies && $comment->replies->count() > 0)
                <div class="replies mt-3">
                    @foreach($comment->replies as $reply)
                        @include('content.digitize.crm.partials.comment-item', ['comment' => $reply, 'level' => $level + 1])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
