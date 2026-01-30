<?php

namespace App\Models\techvault;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngineeringWiki extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'customer_name',
        'category',
        'brand',
        'device_type',
        'model',
        'serial_number',
        'firmware_version',
        'hardware_version',
        'symptom',
        'symptom_file',
        'symptom_image',
        'root_cause',
        'root_cause_file',
        'root_cause_image',
        'solution',
        'solution_file',
        'solution_image',
        'action_taken',
        'action_taken_file',
        'action_taken_image',
        'status',
        'priority',
        'reference_doc',
        'created_by',
        'updated_by',
    ];
}
