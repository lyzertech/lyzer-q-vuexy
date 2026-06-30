<?php

namespace App\Models\procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class ProcurementRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'procurement_requests';
    protected $primaryKey = 'id_procurement_request';

    protected $fillable = [
        'request_number',
        'id_user_sales',
        'id_customer',
        'title',
        'description',
        'priority',
        'status',
        'requested_date',
        'expected_date',
        'completed_at',
        'ack_manager',
        'ack_director',
        'ack_presdir',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'requested_date' => 'date',
        'expected_date' => 'date',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function salesUser()
    {
        return $this->belongsTo(User::class, 'id_user_sales', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(ProcurementCustomer::class, 'id_customer', 'id_customer');
    }

    public function items()
    {
        return $this->hasMany(ProcurementItem::class, 'id_procurement_request', 'id_procurement_request');
    }

    public function comments()
    {
        return $this->hasMany(ProcurementComment::class, 'id_procurement_request', 'id_procurement_request');
    }

    public function attachments()
    {
        return $this->hasMany(ProcurementAttachment::class, 'id_procurement_request', 'id_procurement_request');
    }

    public function statusHistories()
    {
        return $this->hasMany(ProcurementStatusHistory::class, 'id_procurement_request', 'id_procurement_request');
    }

    public function purchaseOrders()
    {
        return $this->hasMany(ProcurementPurchaseOrder::class, 'id_procurement_request', 'id_procurement_request');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    // Business Logic Methods
    public function canBeEdited(): bool
    {
        return !in_array($this->status, ['completed', 'cancelled']);
    }

    public function isReadOnly(): bool
    {
        return in_array($this->status, ['completed', 'cancelled']);
    }

    public function getTotalItemsCount(): int
    {
        return $this->items()->count();
    }

    public function getDeliveredItemsCount(): int
    {
        return $this->items()->where('status', 'delivered')->count();
    }

    public function isAllItemsDelivered(): bool
    {
        return $this->getTotalItemsCount() > 0 && 
               $this->getTotalItemsCount() === $this->getDeliveredItemsCount();
    }

    public function getProgressPercentage(): float
    {
        $total = $this->getTotalItemsCount();
        if ($total === 0) return 0;
        
        return round(($this->getDeliveredItemsCount() / $total) * 100, 2);
    }

    // Auto-generate request number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->request_number)) {
                $model->request_number = self::generateRequestNumber();
            }
        });
    }

    private static function generateRequestNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        $lastRequest = self::whereYear('created_at', $year)
                          ->whereMonth('created_at', $month)
                          ->orderBy('id_procurement_request', 'desc')
                          ->first();
        
        $sequence = $lastRequest ? 
            (int)substr($lastRequest->request_number, -4) + 1 : 1;
        
        return 'PRQ-' . $year . $month . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeBySales($query, $salesId)
    {
        return $query->where('id_user_sales', $salesId);
    }

    public function scopeOverdue($query)
    {
        return $query->where('expected_date', '<', now())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }
}