<?php

// Namespace
namespace App\Http\Requests\SystemManagement\Language;

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
        $language = $this->route('language');

        return [
            'name' => [ 'required', 'string', 'max:255',
                         Rule::unique('languages', 'name')->ignore($language->id),  ],
            'iso_code' => 'required|string|max:10|regex:/^[a-z]{2}(_[A-Z]{2})?$/',
            'is_active' => 'required|boolean',
        ];
    }

    // Get the error messages 
    public function messages(): array
    {
        return [
            'name.required' => __('languages.name_required'),
            'name.unique' => __('languages.name_unique'),
            'iso_code.required' => __('languages.iso_code_required'),
            'iso_code.regex'    => __('languages.iso_code_regex'),            
            'is_active.required' => __('languages.is_active_required'),
        ];
    }
}