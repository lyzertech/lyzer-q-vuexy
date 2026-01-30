<?php

namespace App\Http\Requests\content\digitize\techvault;

use Illuminate\Foundation\Http\FormRequest;

class EngineeringWikiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'customer_name' => 'nullable|string|max:255',
            'category' => 'required|in:issue,update,note',
            'brand' => 'required|string|max:255',
            'device_type' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'firmware_version' => 'nullable|string|max:255',
            'hardware_version' => 'nullable|string|max:255',
            'symptom' => 'nullable|string',
            'symptom_file' => 'nullable|file|max:10240',
            'symptom_image' => 'nullable|image|max:5120',
            'root_cause' => 'nullable|string',
            'root_cause_file' => 'nullable|file|max:10240',
            'root_cause_image' => 'nullable|image|max:5120',
            'solution' => 'nullable|string',
            'solution_file' => 'nullable|file|max:10240',
            'solution_image' => 'nullable|image|max:5120',
            'action_taken' => 'nullable|string',
            'action_taken_file' => 'nullable|file|max:10240',
            'action_taken_image' => 'nullable|image|max:5120',
            'status' => 'required|in:open,monitoring,solved,closed',
            'priority' => 'required|in:low,medium,high,critical',
            'reference_doc' => 'nullable|string|max:255',
        ];
    }
}
