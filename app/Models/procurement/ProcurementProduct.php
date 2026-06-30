<?php

namespace App\Models\procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcurementProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'procurement_products';
    protected $primaryKey = 'id_product';

    protected $fillable = [
        'product_code',
        'product_name',
        'description',
        'unit',
        'category',
        'status'
    ];

    // Relationships
    public function procurementItems()
    {
        return $this->hasMany(ProcurementItem::class, 'id_product', 'id_product');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}