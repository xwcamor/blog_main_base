<?php

// Namespace
namespace App\Http\Requests\SystemManagement\SystemModule;

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
                         Rule::unique('system_modules', 'name'),  ],
            'permission_key' => [ 'required', 'string', 'max:255',
                         Rule::unique('system_modules', 'permission_key'),  ],
        ];
    }

    // Get the error messages 
    public function messages(): array
    {
        return [
            'name.required' => __('system_modules.name_required'),
            'name.unique' => __('system_modules.name_unique'),
            'permission_key.required' => __('system_modules.permission_key_required'),
            'permission_key.unique' => __('system_modules.permission_key_unique'),
        ];
    }
}