<!-- User Comment Timeline Item -->
<div class="timeline-item">
    <span class="timeline-indicator timeline-indicator-primary">
        <div class="avatar avatar-sm">
            <span class="avatar-initial rounded-circle bg-label-primary">
                {{ substr($comment->user->name, 0, 2) }}
            </span>
        </div>
    </span>
    <div class="timeline-event">
        <div class="timeline-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h6 class="mb-0 me-2">{{ $comment->user->name }}</h6>
                @if($comment->isEdited())
                    <small class="text-muted">(edited)</small>
                @endif
            </div>
            <div class="d-flex align-items-center">
                <small class="text-muted me-2">{{ $comment->created_at->diffForHumans() }}</small>
                @if($comment->canBeEdited())
                    <div class="dropdown">
                        <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" onclick="editComment({{ $comment->id_procurement_comment }})">Edit</a></li>
                            <li><a class="dropdown-item" href="#" onclick="deleteComment({{ $comment->id_procurement_comment }})">Delete</a></li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="timeline-body mt-2">
            <div class="comment-content" id="comment-content-{{ $comment->id_procurement_comment }}">
                <p class="mb-2">{{ $comment->message }}</p>
            </div>
            
            @if($comment->attachments->count() > 0)
            <div class="attachments mb-3">
                <small class="text-muted d-block mb-2">Attachments:</small>
                @foreach($comment->attachments as $attachment)
                    <div class="d-inline-block me-2 mb-2">
                        <a href="{{ route('procurement.attachments.download', $attachment->id_procurement_attachment) }}" 
                           class="btn btn-sm btn-outline-secondary">
                            <i class="bx bx-paperclip me-1"></i>
                            {{ Str::limit($attachment->original_name, 20) }}
                            <small class="text-muted">({{ $attachment->getFileSizeFormatted() }})</small>
                        </a>
                    </div>
                @endforeach
            </div>
            @endif

            @if(!$comment->request->isReadOnly())
            <div class="timeline-actions mt-2">
                <button class="btn btn-sm btn-link p-0 text-muted" 
                        onclick="showReplyForm({{ $comment->id_procurement_comment }})">
                    <i class="bx bx-reply me-1"></i>Reply
                </button>
            </div>
            @endif
        </div>

        <!-- Reply Form (initially hidden) -->
        @if(!$comment->request->isReadOnly())
        <div id="reply-form-{{ $comment->id_procurement_comment }}" class="mt-3 d-none">
            <form class="reply-form" data-parent-id="{{ $comment->id_procurement_comment }}">
                @csrf
                <div class="d-flex">
                    <div class="avatar avatar-sm me-3">
                        <span class="avatar-initial rounded-circle bg-label-secondary">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <div class="form-floating form-floating-outline mb-2">
                            <textarea name="message" class="form-control" rows="2" placeholder="Write a reply..." required></textarea>
                            <label>Write a reply...</label>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary me-2" 
                                    onclick="hideReplyForm({{ $comment->id_procurement_comment }})">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif

        <!-- Nested Replies -->
        @if($comment->replies->count() > 0)
        <div class="timeline-nested mt-3">
            @foreach($comment->replies as $reply)
                @include('content.digitize.procurement.components.timeline.comment-reply', ['reply' => $reply])
            @endforeach
        </div>
        @endif
    </div>
</div>