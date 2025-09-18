<?php

// Namespace
namespace App\Http\Requests\SettingManagement\Language;

// Use
use Illuminate\Foundation\Http\FormRequest;

// Main class
class DeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'deleted_description' => 'required|string|min:3|max:1000',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'deleted_description.required' => __('languages.deleted_description_required'),
            'deleted_description.min' => __('languages.deleted_description_min'),
            'deleted_description.max' => __('languages.deleted_description_max'),
        ];
    }
}