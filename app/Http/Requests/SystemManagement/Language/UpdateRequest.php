<?php

// Namespace
namespace App\Http\Requests\SystemManagement\Language;

// Use
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;

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
        // Get current app locale
        $language = App::getLocale();

        if ($language === 'es') {
            return [
                'name.required' => 'El campo nombre es obligatorio.',
                'name.unique' => 'Este idioma ya existe.',
                'iso_code.required' => 'El código ISO es obligatorio.',
                'iso_code.regex' => 'El código ISO debe tener un formato válido (ej. es, en, pt_BR).',
                'is_active.required' => 'El campo estado es obligatorio.',
            ];
        }

        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'This language name already exists.',
            'iso_code.required' => 'The ISO code is required.',
            'iso_code.regex' => 'The ISO code must be a valid format (e.g. es, en, pt_BR).',
            'is_active.required' => 'The status field is required.',
        ];
    }

    // Override failed validation to return 400 status code
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'meta' => [
                'id' => auth()->id(),
                'responsible' => auth()->user()->name,
            ],
            'error' => 'Bad Request',
            'message' => 'Validation failed',
            'details' => $validator->errors()
        ], 400));
    }
}