<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use App\Models\procurement\ProcurementRequest;
use App\Models\procurement\ProcurementComment;
use App\Models\procurement\ProcurementAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProcurementAttachmentController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array|max:10',
            'files.*' => 'file|max:20480|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar',
            'id_procurement_request' => 'required|exists:procurement_requests,id_procurement_request',
            'id_procurement_comment' => 'nullable|exists:procurement_comments,id_procurement_comment'
        ]);

        $procurementRequest = ProcurementRequest::findOrFail($request->id_procurement_request);
        
        if ($procurementRequest->isReadOnly()) {
            return response()->json([
                'success' => false, 
                'message' => 'Cannot upload files to completed request'
            ], 403);
        }

        // Verify comment belongs to request if specified
        if ($request->id_procurement_comment) {
            $comment = ProcurementComment::findOrFail($request->id_procurement_comment);
            if ($comment->id_procurement_request !== $procurementRequest->id_procurement_request) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid comment reference'
                ], 400);
            }
        }

        $uploadedFiles = [];

        try {
            foreach ($request->file('files') as $file) {
                // Generate unique filename
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Store file
                $path = $file->storeAs('procurement/attachments', $fileName, 'public');

                // Create attachment record
                $attachment = $procurementRequest->attachments()->create([
                    'id_procurement_comment' => $request->id_procurement_comment,
                    'file_name' => $fileName,
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'uploaded_by' => auth()->id()
                ]);

                $uploadedFiles[] = [
                    'id' => $attachment->id_procurement_attachment,
                    'original_name' => $attachment->original_name,
                    'size_formatted' => $attachment->getFileSizeFormatted(),
                    'download_url' => $attachment->getDownloadUrl(),
                    'is_image' => $attachment->isImage(),
                    'uploaded_at' => $attachment->created_at->format('M d, Y H:i')
                ];
            }

            // Create system comment about file upload
            $fileCount = count($uploadedFiles);
            $fileNames = collect($uploadedFiles)->pluck('original_name')->take(3)->implode(', ');
            $moreText = $fileCount > 3 ? ' and ' . ($fileCount - 3) . ' more' : '';
            
            $procurementRequest->comments()->create([
                'id_user' => auth()->id(),
                'message' => "Uploaded {$fileCount} file(s): {$fileNames}{$moreText}",
                'is_system' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => count($uploadedFiles) . ' file(s) uploaded successfully',
                'files' => $uploadedFiles
            ]);

        } catch (\Exception $e) {
            // Clean up any uploaded files if error occurs
            foreach ($uploadedFiles as $file) {
                $attachment = ProcurementAttachment::find($file['id']);
                if ($attachment) {
                    Storage::disk('public')->delete($attachment->path);
                    $attachment->delete();
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function download(ProcurementAttachment $attachment)
    {
        // Verify user has access to this attachment
        if (!$this->userCanAccessAttachment($attachment)) {
            abort(403, 'Access denied');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($attachment->path)) {
            abort(404, 'File not found');
        }

        // Get file contents
        $fileContent = Storage::disk('public')->get($attachment->path);
        
        return response($fileContent)
            ->header('Content-Type', $attachment->mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $attachment->original_name . '"')
            ->header('Content-Length', strlen($fileContent));
    }

    public function view(ProcurementAttachment $attachment)
    {
        // For inline viewing (images, PDFs)
        if (!$this->userCanAccessAttachment($attachment)) {
            abort(403, 'Access denied');
        }

        if (!Storage::disk('public')->exists($attachment->path)) {
            abort(404, 'File not found');
        }

        // Only allow inline viewing for images and PDFs
        if (!$attachment->isImage() && !$attachment->isPdf()) {
            return $this->download($attachment);
        }

        $fileContent = Storage::disk('public')->get($attachment->path);
        
        return response($fileContent)
            ->header('Content-Type', $attachment->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $attachment->original_name . '"');
    }

    public function destroy(ProcurementAttachment $attachment)
    {
        // Verify user has permission to delete
        if (!$this->userCanDeleteAttachment($attachment)) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied'
            ], 403);
        }

        $request = $attachment->request;
        
        if ($request->isReadOnly()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete files from completed request'
            ], 403);
        }

        $originalName = $attachment->original_name;

        // Delete file from storage
        if (Storage::disk('public')->exists($attachment->path)) {
            Storage::disk('public')->delete($attachment->path);
        }

        // Delete attachment record
        $attachment->delete();

        // Create system comment
        $request->comments()->create([
            'id_user' => auth()->id(),
            'message' => "File deleted: {$originalName}",
            'is_system' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully'
        ]);
    }

    public function getRequestAttachments(ProcurementRequest $request)
    {
        $attachments = $request->attachments()
                              ->with('uploadedBy')
                              ->whereNull('id_procurement_comment') // Only request-level attachments
                              ->orderBy('created_at', 'desc')
                              ->get();

        return response()->json([
            'attachments' => $attachments->map(function ($attachment) {
                return [
                    'id' => $attachment->id_procurement_attachment,
                    'original_name' => $attachment->original_name,
                    'size_formatted' => $attachment->getFileSizeFormatted(),
                    'mime_type' => $attachment->mime_type,
                    'is_image' => $attachment->isImage(),
                    'is_pdf' => $attachment->isPdf(),
                    'download_url' => $attachment->getDownloadUrl(),
                    'view_url' => route('procurement.attachments.view', $attachment->id_procurement_attachment),
                    'uploaded_by' => $attachment->uploadedBy->name,
                    'uploaded_at' => $attachment->created_at->format('M d, Y H:i'),
                    'can_delete' => $this->userCanDeleteAttachment($attachment)
                ];
            })
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'attachment_ids' => 'required|array',
            'attachment_ids.*' => 'integer|exists:procurement_attachments,id_procurement_attachment'
        ]);

        $attachments = ProcurementAttachment::whereIn('id_procurement_attachment', $request->attachment_ids)->get();
        $deletedCount = 0;
        $errors = [];

        foreach ($attachments as $attachment) {
            if (!$this->userCanDeleteAttachment($attachment)) {
                $errors[] = "Access denied for {$attachment->original_name}";
                continue;
            }

            if ($attachment->request->isReadOnly()) {
                $errors[] = "Cannot delete {$attachment->original_name} from completed request";
                continue;
            }

            // Delete file from storage
            if (Storage::disk('public')->exists($attachment->path)) {
                Storage::disk('public')->delete($attachment->path);
            }

            $attachment->delete();
            $deletedCount++;
        }

        $message = $deletedCount > 0 ? "{$deletedCount} file(s) deleted successfully" : "No files were deleted";
        if (!empty($errors)) {
            $message .= ". Errors: " . implode(', ', $errors);
        }

        return response()->json([
            'success' => $deletedCount > 0,
            'message' => $message,
            'deleted_count' => $deletedCount,
            'errors' => $errors
        ]);
    }

    private function userCanAccessAttachment(ProcurementAttachment $attachment): bool
    {
        $user = auth()->user();
        $request = $attachment->request;

        // Admin and managers can access all
        if (in_array($user->role, [1, 2])) {
            return true;
        }

        // Sales can access their own requests
        if (in_array($user->role, [4, 5]) && $request->id_user_sales === $user->id) {
            return true;
        }

        // Purchasing team can access approved requests
        if ($user->role === 6 && !in_array($request->status, ['draft', 'waiting_approval'])) {
            return true;
        }

        return false;
    }

    private function userCanDeleteAttachment(ProcurementAttachment $attachment): bool
    {
        $user = auth()->user();

        // Admin can delete anything
        if ($user->role === 1) {
            return true;
        }

        // User can delete their own uploads if request is editable
        if ($attachment->uploaded_by === $user->id && $attachment->request->canBeEdited()) {
            return true;
        }

        return false;
    }
}