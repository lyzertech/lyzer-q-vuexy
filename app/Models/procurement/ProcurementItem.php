<?php

namespace App\Models\procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementItem extends Model
{
    use HasFactory;

    protected $table = 'procurement_items';
    protected $primaryKey = 'id_procurement_item';

    protected $fillable = [
        'id_procurement_request',
        'id_product',
        'product_name',
        'specification',
        'requested_qty',
        'arrived_qty',
        'delivered_qty',
        'unit',
        'status',
        'remarks'
    ];

    protected $casts = [
        'requested_qty' => 'decimal:2',
        'arrived_qty' => 'decimal:2',
        'delivered_qty' => 'decimal:2',
    ];

    // Relationships
    public function request()
    {
        return $this->belongsTo(ProcurementRequest::class, 'id_procurement_request', 'id_procurement_request');
    }

    public function product()
    {
        return $this->belongsTo(ProcurementProduct::class, 'id_product', 'id_product');
    }

    public function arrivalHistories()
    {
        return $this->hasMany(ProcurementArrivalHistory::class, 'id_procurement_item', 'id_procurement_item');
    }

    public function statusHistories()
    {
        return $this->hasMany(ProcurementStatusHistory::class, 'id_procurement_item', 'id_procurement_item');
    }

    // Computed Properties
    public function getRemainingQtyAttribute(): float
    {
        return $this->requested_qty - $this->arrived_qty;
    }

    public function getCompletionPercentageAttribute(): float
    {
        if ($this->requested_qty == 0) return 0;
        return round(($this->arrived_qty / $this->requested_qty) * 100, 2);
    }

    // Business Logic
    public function canReceiveArrival(): bool
    {
        return $this->remaining_qty > 0 && 
               !in_array($this->status, ['delivered', 'cancelled']);
    }

    public function recordArrival(float $qty, string $warehouse = null, string $note = null, int $userId = null): bool
    {
        if (!$this->canReceiveArrival() || $qty > $this->remaining_qty) {
            return false;
        }

        // Create arrival history
        $this->arrivalHistories()->create([
            'qty' => $qty,
            'arrival_date' => now()->format('Y-m-d'),
            'warehouse' => $warehouse,
            'note' => $note,
            'created_by' => $userId ?? auth()->id()
        ]);

        // Update arrived quantity
        $this->arrived_qty += $qty;

        // Update status based on arrival
        if ($this->remaining_qty <= 0) {
            $this->status = 'arrival';
        } else {
            $this->status = 'partial_arrival';
        }

        return $this->save();
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByRequest($query, $requestId)
    {
        return $query->where('id_procurement_request', $requestId);
    }

    public function scopePendingArrival($query)
    {
        return $query->where('status', '!=', 'delivered')
                    ->where('status', '!=', 'cancelled')
                    ->whereRaw('arrived_qty < requested_qty');
    }
}