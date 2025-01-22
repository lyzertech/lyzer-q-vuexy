<?php

namespace App\Models\monitoring;

use Illuminate\Database\Eloquent\Model;

class monitoring_facility extends Model
{
    protected $table = 'monitoring_facility';
    protected $primaryKey = 'id_facility';
    protected $fillable = [
        'organization',
        'facilities',
        'type',
        'description',
        'street_address',
        'city',
        'province',
        'country',
        'postal_code',
        'timezone',
        'updated_at',
        'created_at'
    ];
}
