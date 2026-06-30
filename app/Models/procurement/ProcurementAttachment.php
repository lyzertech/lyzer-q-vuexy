<?php

namespace App\Models\procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProcurementAttachment extends Model
{
    use HasFactory;

    protected $table = 'procurement_attachments';
    protected $primaryKey = 'id_procurement_attachment';

    protected $fillable = [
        'id_procurement_request',
        'id_procurement_comment',
        'file_name',
        'original_name',
        'path',
        'mime_type',
        'size',
        'uploaded_by'
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    // Relationships
    public function request()
    {
        return $this->belongsTo(ProcurementRequest::class, 'id_procurement_request', 'id_procurement_request');
    }

    public function comment()
    {
        return $this->belongsTo(ProcurementComment::class, 'id_procurement_comment', 'id_procurement_comment');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }

    // Helper Methods
    public function getFileSizeFormatted(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function isImage(): bool
    {
        return strpos($this->mime_type, 'image/') === 0;
    }

    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }

    public function getFileExtension(): string
    {
        return pathinfo($this->original_name, PATHINFO_EXTENSION);
    }

    public function getDownloadUrl(): string
    {
        return route('procurement.attachments.download', $this->id_procurement_attachment);
    }

    // Scopes
    public function scopeByRequest($query, $requestId)
    {
        return $query->where('id_procurement_request', $requestId);
    }

    public function scopeByComment($query, $commentId)
    {
        return $query->where('id_procurement_comment', $commentId);
    }

    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    public function scopeDocuments($query)
    {
        return $query->where('mime_type', 'not like', 'image/%');
    }
}