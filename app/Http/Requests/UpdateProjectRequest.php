<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_name' => 'required|string|max:255',
            'project_type' => 'nullable|string|max:255',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'nullable|string|max:50',
            'client_email' => 'nullable|email|max:255',
            'project_manager' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'target_delivery_date' => 'required|date|after_or_equal:start_date',
            'status' => 'nullable|string|max:50',
            'priority' => 'nullable|string|max:50',
            'quotation_file_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'total_cost' => 'nullable|string|max:100',
            'stack_frontend' => 'nullable|string|max:255',
            'stack_backend' => 'nullable|string|max:255',
            'stack_database' => 'nullable|string|max:255',
            'support_period' => 'nullable|string|max:255',
            'support_expiry' => 'nullable|date',
            'team_roles' => 'nullable|array',
            'team_members' => 'nullable|array',
            'team_responsibilities' => 'nullable|array',
            'milestone_names' => 'nullable|array',
            'milestone_amounts' => 'nullable|array',
            'milestone_dates' => 'nullable|array',
            'milestone_statuses' => 'nullable|array',
            'cred_titles' => 'nullable|array',
            'cred_usernames' => 'nullable|array',
            'cred_passwords' => 'nullable|array',
            'cred_notes' => 'nullable|array',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'project_name.required' => 'Project Name is required.',
            'client_name.required' => 'Client Name is required.',
            'start_date.required' => 'Project Start Date is required.',
            'target_delivery_date.required' => 'Target Delivery Date is required.',
            'target_delivery_date.after_or_equal' => 'Target Delivery Date cannot be earlier than Start Date.',
            'quotation_file_pdf.mimes' => 'Quotation file must be a PDF document.',
            'quotation_file_pdf.max' => 'Quotation PDF size must not exceed 10MB.',
        ];
    }
}
