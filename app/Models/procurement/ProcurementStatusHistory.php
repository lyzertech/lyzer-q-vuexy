<?php

namespace App\Models\procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProcurementStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'procurement_status_histories';
    protected $primaryKey = 'id_status_history';

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    protected $fillable = [
        'id_procurement_request',
        'id_procurement_item',
        'old_status',
        'new_status',
        'note',
        'changed_by'
    ];

    // Relationships
    public function request()
    {
        return $this->belongsTo(ProcurementRequest::class, 'id_procurement_request', 'id_procurement_request');
    }

    public function item()
    {
        return $this->belongsTo(ProcurementItem::class, 'id_procurement_item', 'id_procurement_item');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by', 'id');
    }

    // Helper Methods
    public function isRequestLevelChange(): bool
    {
        return is_null($this->id_procurement_item);
    }

    public function isItemLevelChange(): bool
    {
        return !is_null($this->id_procurement_item);
    }

    public function getEntityName(): string
    {
        if ($this->isRequestLevelChange()) {
            return 'Request #' . $this->request->request_number;
        } else {
            return 'Item: ' . $this->item->product_name;
        }
    }

    public function getStatusChangeDescription(): string
    {
        $description = $this->old_status ? 
            "Changed from {$this->old_status} to {$this->new_status}" : 
            "Set to {$this->new_status}";
            
        if ($this->note) {
            $description .= " - {$this->note}";
        }
        
        return $description;
    }

    // Scopes
    public function scopeRequestHistory($query)
    {
        return $query->whereNull('id_procurement_item');
    }

    public function scopeItemHistory($query)
    {
        return $query->whereNotNull('id_procurement_item');
    }

    public function scopeByRequest($query, $requestId)
    {
        return $query->where('id_procurement_request', $requestId);
    }

    public function scopeByItem($query, $itemId)
    {
        return $query->where('id_procurement_item', $itemId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('new_status', $status);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('changed_by', $userId);
    }

    public function scopeRecentChanges($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Static methods for reporting
    public static function getRequestTimeline($requestId)
    {
        return self::with(['changedBy', 'item'])
                  ->where('id_procurement_request', $requestId)
                  ->orderBy('created_at', 'asc')
                  ->get();
    }

    public static function getUserActivity($userId, $days = 30)
    {
        return self::with(['request', 'item'])
                  ->where('changed_by', $userId)
                  ->where('created_at', '>=', now()->subDays($days))
                  ->orderBy('created_at', 'desc')
                  ->get();
    }

    public static function getStatusTransitionReport($fromStatus, $toStatus = null)
    {
        $query = self::with(['request', 'item', 'changedBy'])
                    ->where('old_status', $fromStatus);
                    
        if ($toStatus) {
            $query->where('new_status', $toStatus);
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }
}