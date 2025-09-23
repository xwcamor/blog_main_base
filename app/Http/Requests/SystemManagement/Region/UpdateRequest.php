<?php

// Namespace
namespace App\Http\Requests\SystemManagement\Region;

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
        $region = $this->route('region');

        return [
            'name' => [ 'required', 'string', 'max:255',
                         Rule::unique('regions', 'name')->ignore($region->id),  ],
            'is_active' => 'required|boolean',
        ];
    }

    // Get the error messages
    public function messages(): array
    {
        return [
            'name.required' => __('regions.name_required'),
            'name.unique' => __('regions.name_unique'),
            'is_active.required' => __('regions.is_active_required'),
        ];
    }
}
