<?php

namespace App\Models\procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcurementCustomer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'procurement_customers';
    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'customer_name',
        'contact_person',
        'email',
        'phone',
        'address',
        'status'
    ];

    // Relationships
    public function procurementRequests()
    {
        return $this->hasMany(ProcurementRequest::class, 'id_customer', 'id_customer');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}