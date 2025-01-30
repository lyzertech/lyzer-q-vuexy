<?php

namespace App\Models\monitoring;

use Illuminate\Database\Eloquent\Model;

class monitoring_device extends Model
{
    protected $table = 'monitoring_devices';
    protected $primaryKey = 'id_device';
    protected $fillable = [
        'facility',
        'device_name',
        'device_model',
        'device_serial',
        'location',
        'updated_at',
        'created_at'
    ];
}
