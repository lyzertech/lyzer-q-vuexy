<?php

namespace App\Models\procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProcurementPurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 'procurement_purchase_orders';
    protected $primaryKey = 'id_purchase_order';

    protected $fillable = [
        'id_procurement_request',
        'id_supplier',
        'po_number',
        'po_date',
        'status',
        'total_amount',
        'notes',
        'created_by'
    ];

    protected $casts = [
        'po_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function request()
    {
        return $this->belongsTo(ProcurementRequest::class, 'id_procurement_request', 'id_procurement_request');
    }

    public function supplier()
    {
        return $this->belongsTo(ProcurementSupplier::class, 'id_supplier', 'id_supplier');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Business Logic
    public function canBeEdited(): bool
    {
        return !in_array($this->status, ['completed', 'cancelled']);
    }

    public function isReadOnly(): bool
    {
        return in_array($this->status, ['completed', 'cancelled']);
    }

    // Auto-generate PO number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->po_number)) {
                $model->po_number = self::generatePoNumber();
            }
        });
    }

    private static function generatePoNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        $lastPo = self::whereYear('created_at', $year)
                     ->whereMonth('created_at', $month)
                     ->orderBy('id_purchase_order', 'desc')
                     ->first();
        
        $sequence = $lastPo ? 
            (int)substr($lastPo->po_number, -4) + 1 : 1;
        
        return 'PO-' . $year . $month . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeBySupplier($query, $supplierId)
    {
        return $query->where('id_supplier', $supplierId);
    }

    public function scopeByRequest($query, $requestId)
    {
        return $query->where('id_procurement_request', $requestId);
    }
}