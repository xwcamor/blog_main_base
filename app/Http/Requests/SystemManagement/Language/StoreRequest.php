<?php

// Namespace
namespace App\Http\Requests\SystemManagement\Language;

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
                         Rule::unique('languages', 'name'),  ],
            'iso_code' => 'required|string|max:10|regex:/^[a-z]{2}(_[A-Z]{2})?$/',
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
        ];
    }
}