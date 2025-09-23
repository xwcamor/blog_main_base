<?php

// Namespace
namespace App\Http\Requests\SystemManagement\Tenant;

// Use
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// Main class
class UpdateRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize(): bool
    {
        return true;
    }

    // Rules
    public function rules(): array
    {
        $tenant = $this->route('tenant');

        return [
            'name' => [ 'required', 'string', 'max:255',
                         Rule::unique('tenants', 'name')->ignore($tenant->id),  ],
            'logo' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ];
    }

    // Get the error messages
    public function messages(): array
    {
        return [
            'name.required' => __('tenants.name_required'),
            'name.unique' => __('tenants.name_unique'),
            'logo.max' => __('tenants.logo_max'),
            'is_active.required' => __('tenants.is_active_required'),
        ];
    }
}
