<!-- Comment Reply Timeline Item (Recursive/Threaded) -->
<div class="timeline-reply ms-4">
    <div class="d-flex mt-3">
        <div class="avatar avatar-sm me-3">
            <span class="avatar-initial rounded-circle bg-label-secondary">
                {{ substr($reply->user->name, 0, 2) }}
            </span>
        </div>
        <div class="flex-grow-1">
            <div class="card border-start border-primary border-2">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 me-2">{{ $reply->user->name }}</h6>
                            @if($reply->isEdited())
                                <small class="text-muted">(edited)</small>
                            @endif
                            <small class="text-muted ms-2">{{ $reply->created_at->diffForHumans() }}</small>
                        </div>
                        @if($reply->canBeEdited())
                            <div class="dropdown">
                                <button class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" onclick="editComment({{ $reply->id_procurement_comment }})">Edit</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="deleteComment({{ $reply->id_procurement_comment }})">Delete</a></li>
                                </ul>
                            </div>
                        @endif
                    </div>
                    
                    <div class="comment-content mb-2" id="comment-content-{{ $reply->id_procurement_comment }}">
                        <p class="mb-0">{{ $reply->message }}</p>
                    </div>
                    
                    @if($reply->attachments->count() > 0)
                    <div class="attachments mb-2">
                        @foreach($reply->attachments as $attachment)
                            <div class="d-inline-block me-2 mb-1">
                                <a href="{{ route('procurement.attachments.download', $attachment->id_procurement_attachment) }}" 
                                   class="btn btn-xs btn-outline-secondary">
                                    <i class="bx bx-paperclip me-1"></i>
                                    {{ Str::limit($attachment->original_name, 15) }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                    @endif

                    @if(!$reply->request->isReadOnly())
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-link p-0 text-muted" 
                                onclick="showReplyForm({{ $reply->id_procurement_comment }})">
                            <i class="bx bx-reply me-1"></i>Reply
                        </button>
                        
                        @if($reply->replies->count() > 0)
                        <span class="mx-2">•</span>
                        <small class="text-muted">{{ $reply->replies->count() }} {{ Str::plural('reply', $reply->replies->count()) }}</small>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Reply Form (initially hidden) -->
            @if(!$reply->request->isReadOnly())
            <div id="reply-form-{{ $reply->id_procurement_comment }}" class="mt-2 d-none">
                <form class="reply-form" data-parent-id="{{ $reply->id_procurement_comment }}">
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
                                        onclick="hideReplyForm({{ $reply->id_procurement_comment }})">Cancel</button>
                                <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif

            <!-- Nested Replies (Recursive) -->
            @if($reply->replies->count() > 0)
            <div class="nested-replies mt-2">
                @foreach($reply->replies as $nestedReply)
                    @include('content.digitize.procurement.components.timeline.comment-reply', ['reply' => $nestedReply])
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>