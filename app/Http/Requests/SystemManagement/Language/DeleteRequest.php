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
class DeleteRequest extends FormRequest
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
            'deleted_description' => 'required|string|min:3|max:1000',
        ];
    }

    // Get the error messages
    public function messages(): array
    {
        // Get current app locale
        $language = App::getLocale();

        if ($language === 'es') {
            return [
                'deleted_description.required' => 'El motivo de eliminación es obligatorio.',
                'deleted_description.min' => 'El motivo de eliminación debe tener al menos 3 caracteres.',
                'deleted_description.max' => 'El motivo de eliminación no puede superar los 1000 caracteres.',
            ];
        }

        return [
            'deleted_description.required' => 'The deletion reason is required.',
            'deleted_description.min' => 'The deletion reason must be at least 3 characters.',
            'deleted_description.max' => 'The deletion reason cannot exceed 1000 characters.',
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