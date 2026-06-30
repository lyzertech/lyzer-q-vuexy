<?php

namespace App\Models\procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class ProcurementComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'procurement_comments';
    protected $primaryKey = 'id_procurement_comment';

    protected $fillable = [
        'id_procurement_request',
        'id_parent_comment',
        'id_user',
        'message',
        'is_system',
        'edited_at'
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'edited_at' => 'datetime',
    ];

    // Relationships
    public function request()
    {
        return $this->belongsTo(ProcurementRequest::class, 'id_procurement_request', 'id_procurement_request');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'id_parent_comment', 'id_procurement_comment');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'id_parent_comment', 'id_procurement_comment');
    }

    public function allReplies()
    {
        return $this->replies()->with('allReplies');
    }

    public function attachments()
    {
        return $this->hasMany(ProcurementAttachment::class, 'id_procurement_comment', 'id_procurement_comment');
    }

    // Scopes
    public function scopeRootComments($query)
    {
        return $query->whereNull('id_parent_comment');
    }

    public function scopeSystemComments($query)
    {
        return $query->where('is_system', true);
    }

    public function scopeUserComments($query)
    {
        return $query->where('is_system', false);
    }

    public function scopeByRequest($query, $requestId)
    {
        return $query->where('id_procurement_request', $requestId);
    }

    // Helper methods
    public function isEdited(): bool
    {
        return !is_null($this->edited_at);
    }

    public function canBeEdited(): bool
    {
        return !$this->is_system && 
               $this->request && 
               $this->request->canBeEdited();
    }

    public function getDepthLevel(): int
    {
        $depth = 0;
        $parent = $this->parent;
        
        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }
        
        return $depth;
    }

    public function hasReplies(): bool
    {
        return $this->replies()->count() > 0;
    }

    public function getTotalRepliesCount(): int
    {
        $count = $this->replies()->count();
        foreach ($this->replies as $reply) {
            $count += $reply->getTotalRepliesCount();
        }
        return $count;
    }
}