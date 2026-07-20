<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crm_inquiry extends Model
{
    use HasFactory;

    protected $table = 'crm_inquiry';
    protected $primaryKey = 'id_inquiry';
    protected $fillable = [
        'inquiry_number',
        'title',
        'pic_sales',
        'priority',
        'status',
        'price_information',
        'product_type',
        'lead_time',
        'moq',
        'availability_status',
        'shipping_terms',
        'validity_period',
        'notes',
        'updated_at',
        'created_at',
    ];
}
