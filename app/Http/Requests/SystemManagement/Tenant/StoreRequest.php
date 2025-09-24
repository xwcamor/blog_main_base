<?php

// Namespace
namespace App\Http\Requests\SystemManagement\Tenant;

// Use
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// Main class
class StoreRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize(): bool
    {
        return true;
    }

    // Rules
    public function rules(): array
    {
        return [
            'name' => [ 'required', 'string', 'max:255',
                         Rule::unique('tenants', 'name'),  ],
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    // Get the error messages
    public function messages(): array
    {
        return [
            'name.required' => __('tenants.name_required'),
            'name.unique'   => __('tenants.name_unique'),
            'logo.image'    => __('tenants.logo_image'),
            'logo.mimes'    => __('tenants.logo_mimes'),
            'logo.max'      => __('tenants.logo_max'),
        ];
    }
}