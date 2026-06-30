<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use App\Models\procurement\ProcurementRequest;
use App\Models\procurement\ProcurementComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcurementCommentController extends Controller
{
    public function index(ProcurementRequest $request)
    {
        // Get all comments with their nested replies for timeline view
        $comments = $request->comments()
                           ->with(['user', 'allReplies.user', 'attachments'])
                           ->rootComments()
                           ->orderBy('created_at', 'asc')
                           ->get();

        return response()->json([
            'comments' => $comments->map(function ($comment) {
                return $this->formatCommentForResponse($comment);
            })
        ]);
    }

    public function store(Request $request, ProcurementRequest $procurementRequest)
    {
        if ($procurementRequest->isReadOnly()) {
            return response()->json(['success' => false, 'message' => 'Cannot add comments to completed request']);
        }

        $request->validate([
            'message' => 'required|string|max:5000',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt'
        ]);

        $comment = $procurementRequest->comments()->create([
            'id_user' => auth()->id(),
            'message' => $request->message,
            'is_system' => false
        ]);

        // Handle file attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('procurement/attachments', $fileName, 'public');

                $procurementRequest->attachments()->create([
                    'id_procurement_comment' => $comment->id_procurement_comment,
                    'file_name' => $fileName,
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'uploaded_by' => auth()->id()
                ]);
            }
        }

        // Load the comment with relationships for response
        $comment->load(['user', 'attachments']);

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'comment' => $this->formatCommentForResponse($comment)
        ]);
    }

    public function update(Request $request, ProcurementRequest $procurementRequest, ProcurementComment $comment)
    {
        if (!$comment->canBeEdited()) {
            return response()->json(['success' => false, 'message' => 'This comment cannot be edited']);
        }

        if ($comment->id_procurement_request !== $procurementRequest->id_procurement_request) {
            abort(404);
        }

        $request->validate([
            'message' => 'required|string|max:5000'
        ]);

        $comment->update([
            'message' => $request->message,
            'edited_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully',
            'comment' => $this->formatCommentForResponse($comment->fresh(['user', 'attachments']))
        ]);
    }

    public function destroy(ProcurementRequest $procurementRequest, ProcurementComment $comment)
    {
        if (!$comment->canBeEdited()) {
            return response()->json(['success' => false, 'message' => 'This comment cannot be deleted']);
        }

        if ($comment->id_procurement_request !== $procurementRequest->id_procurement_request) {
            abort(404);
        }

        // Delete associated attachments from storage
        foreach ($comment->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->path)) {
                Storage::disk('public')->delete($attachment->path);
            }
        }

        // Soft delete the comment (this will also handle replies due to cascade)
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }

    public function reply(Request $request, ProcurementRequest $procurementRequest, ProcurementComment $parentComment)
    {
        if ($procurementRequest->isReadOnly()) {
            return response()->json(['success' => false, 'message' => 'Cannot reply to comments in completed request']);
        }

        if ($parentComment->id_procurement_request !== $procurementRequest->id_procurement_request) {
            abort(404);
        }

        $request->validate([
            'message' => 'required|string|max:5000',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt'
        ]);

        $reply = $procurementRequest->comments()->create([
            'id_parent_comment' => $parentComment->id_procurement_comment,
            'id_user' => auth()->id(),
            'message' => $request->message,
            'is_system' => false
        ]);

        // Handle file attachments for reply
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('procurement/attachments', $fileName, 'public');

                $procurementRequest->attachments()->create([
                    'id_procurement_comment' => $reply->id_procurement_comment,
                    'file_name' => $fileName,
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'uploaded_by' => auth()->id()
                ]);
            }
        }

        // Load the reply with relationships for response
        $reply->load(['user', 'attachments']);

        return response()->json([
            'success' => true,
            'message' => 'Reply added successfully',
            'reply' => $this->formatCommentForResponse($reply)
        ]);
    }

    public function getThread(ProcurementRequest $procurementRequest, ProcurementComment $comment)
    {
        if ($comment->id_procurement_request !== $procurementRequest->id_procurement_request) {
            abort(404);
        }

        // Get the comment with all its nested replies
        $comment->load(['user', 'allReplies.user', 'attachments']);

        return response()->json([
            'comment' => $this->formatCommentForResponse($comment)
        ]);
    }

    public function markAsRead(ProcurementRequest $procurementRequest)
    {
        // Mark all comments in this request as read for the current user
        // This could be implemented with a pivot table or user preferences
        // For now, we'll just return success
        
        return response()->json([
            'success' => true,
            'message' => 'Comments marked as read'
        ]);
    }

    private function formatCommentForResponse(ProcurementComment $comment): array
    {
        $formatted = [
            'id' => $comment->id_procurement_comment,
            'message' => $comment->message,
            'is_system' => $comment->is_system,
            'created_at' => $comment->created_at,
            'edited_at' => $comment->edited_at,
            'is_edited' => $comment->isEdited(),
            'can_edit' => $comment->canBeEdited(),
            'depth_level' => $comment->getDepthLevel(),
            'user' => [
                'id' => $comment->user->id,
                'name' => $comment->user->name,
                'initials' => substr($comment->user->name, 0, 2)
            ],
            'attachments' => $comment->attachments->map(function ($attachment) {
                return [
                    'id' => $attachment->id_procurement_attachment,
                    'original_name' => $attachment->original_name,
                    'size_formatted' => $attachment->getFileSizeFormatted(),
                    'download_url' => $attachment->getDownloadUrl(),
                    'is_image' => $attachment->isImage()
                ];
            }),
            'replies' => []
        ];

        // Recursively format replies
        if ($comment->relationLoaded('allReplies')) {
            $formatted['replies'] = $comment->allReplies->map(function ($reply) {
                return $this->formatCommentForResponse($reply);
            });
        } elseif ($comment->relationLoaded('replies')) {
            $formatted['replies'] = $comment->replies->map(function ($reply) {
                return $this->formatCommentForResponse($reply);
            });
        }

        return $formatted;
    }
}