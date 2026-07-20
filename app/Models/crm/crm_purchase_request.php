<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crm_purchase_request extends Model
{
    use HasFactory;

    protected $table = 'crm_purchase_request';
    protected $primaryKey = 'id_purchase_request';
    protected $fillable = [
        'pr_number',
        'customer_name',
        'customer_po_number',
        'project_name',
        'item_list',
        'quantity',
        'selling_price',
        'supplier_price',
        'expected_delivery_date',
        'lead_time',
        'attachment_customer_po',
        'title',
        'requested_by',
        'department',
        'priority',
        'status',
        'notes',
        'updated_at',
        'created_at',
    ];
}
