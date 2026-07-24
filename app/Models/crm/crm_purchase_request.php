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
        'term_of_payment',
        'down_payment',
        'dp_received_date',
        'principal_po_number',
        'brand',
        'packing_list',
        'item_list',
        'quantity',
        'selling_price',
        'supplier_price',
        'expected_delivery_date',
        'principal_delivery_date',
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
