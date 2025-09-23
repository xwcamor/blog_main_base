<?php

// Namespace
namespace App\Http\Requests\SystemManagement\Region;

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
                         Rule::unique('regions', 'name'),  ],
        ];
    }

    // Get the error messages
    public function messages(): array
    {
        return [
            'name.required' => __('regions.name_required'),
            'name.unique' => __('regions.name_unique'),
        ];
    }
}
