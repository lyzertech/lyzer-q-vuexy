<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class crm_visit_report extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'crm_visit_report';
    protected $primaryKey = 'id_visit_report';
    protected $fillable = [
        'customer_name', // Name of the customer
        'sales', // Name of the sales
        'location', // Location of the customer
        'contact_person', // Person to meet at the customer site
        'contact_number', // Contact number of the person
        'visit_date', // Date of the visit
        'visit_time', // Time of the visit
        'purpose', // Purpose of the visit
        'notes', // Notes from the visit
        'customer_feedback', // Feedback from the customer
        'next_steps', // Next actions after the visit
        'follow_up_date', // Date for follow-up actions
        'status', // Visit status (e.g., Planned, Completed)
        'ack_manager', // Visit status (e.g., Planned, Completed)
        'ack_director', // Visit status (e.g., Planned, Completed)
        'ack_presdir', // Visit status (e.g., Planned, Completed)
        'image', // Path to an uploaded image or document
        'updated_at',
        'created_at'
    ];
}
