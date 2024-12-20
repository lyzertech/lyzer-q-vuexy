<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crm_customer extends Model
{
    use HasFactory;

    protected $table = 'crm_customer';
    protected $primaryKey = 'id_customer';
    protected $fillable = [
        'name',
        'email',
        'sales',
        'area',
        'address',
        'phonenumber',
        'mobilephone',
        'company',
        'position',
        'status',
        'updated_at',
        'created_at'
    ];
}
