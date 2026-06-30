<?php

namespace App\Models\procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcurementSupplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'procurement_suppliers';
    protected $primaryKey = 'id_supplier';

    protected $fillable = [
        'supplier_name',
        'contact_person',
        'email',
        'phone',
        'address',
        'status'
    ];

    // Relationships
    public function purchaseOrders()
    {
        return $this->hasMany(ProcurementPurchaseOrder::class, 'id_supplier', 'id_supplier');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}