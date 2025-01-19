<?php

namespace App\Models\monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monitoring_datalog extends Model
{
    use HasFactory;

    protected $table = 'monitoring_acuvim';
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
