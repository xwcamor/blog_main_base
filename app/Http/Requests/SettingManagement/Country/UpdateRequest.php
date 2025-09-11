<?php

// Namespace
namespace App\Http\Requests\SettingManagement\Country;

// Use Illuminates
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// Main class
class UpdateRequest extends FormRequest
{
    // Authorize
    public function authorize(): bool
    {
        // Allow request
        return true;
    }

    // Rules
    public function rules(): array
    {
        // Capture model for Route Model Binding
        $country = $this->route('country'); 
       
        // Validations
        return [
            'name' => [ 'required', 'string', 'max:255',
                         Rule::unique('countries', 'name')->ignore($country->id),  ],
            'is_active' => 'required|boolean',
        ];
    }
    
    // Messages
    public function messages(): array
    {
        // Validation Messages
        return [
            'name.max' => 'El nombre debe tener como máximo 255 caracteres.',
            'name.unique' => 'El nombre ya está registrado.',
            'is_active.required' => 'El estado es obligatorio.',
            'is_active.boolean'  => 'El estado debe ser verdadero o falso.',            
        ];
    }

}