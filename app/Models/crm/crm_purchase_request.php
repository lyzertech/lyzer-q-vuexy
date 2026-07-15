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
