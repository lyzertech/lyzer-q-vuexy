<?php

namespace App\Models\procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProcurementArrivalHistory extends Model
{
    use HasFactory;

    protected $table = 'procurement_arrival_histories';
    protected $primaryKey = 'id_arrival_history';

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    protected $fillable = [
        'id_procurement_item',
        'qty',
        'arrival_date',
        'warehouse',
        'note',
        'created_by'
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'arrival_date' => 'date',
    ];

    // Relationships
    public function item()
    {
        return $this->belongsTo(ProcurementItem::class, 'id_procurement_item', 'id_procurement_item');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Helper Methods
    public function getRequest()
    {
        return $this->item->request ?? null;
    }

    public function getProductName(): string
    {
        return $this->item->product_name ?? 'Unknown Product';
    }

    // Scopes
    public function scopeByItem($query, $itemId)
    {
        return $query->where('id_procurement_item', $itemId);
    }

    public function scopeByWarehouse($query, $warehouse)
    {
        return $query->where('warehouse', $warehouse);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('arrival_date', [$startDate, $endDate]);
    }

    public function scopeRecentArrivals($query, $days = 7)
    {
        return $query->where('arrival_date', '>=', now()->subDays($days));
    }

    // Static methods for aggregation
    public static function getTotalArrivedQty($itemId): float
    {
        return self::where('id_procurement_item', $itemId)->sum('qty');
    }

    public static function getArrivalsByDateRange($startDate, $endDate)
    {
        return self::with(['item.request', 'createdBy'])
                  ->whereBetween('arrival_date', [$startDate, $endDate])
                  ->orderBy('arrival_date', 'desc')
                  ->get();
    }
}