<?php

namespace App\Http\Requests\CompanyManagement\Company;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    // Autorizar request
    public function authorize(): bool
    {
        return true;
    }

    // Reglas de validación
    public function rules(): array
    {
        return [
            'deleted_description' => 'required|string|min:3|max:1000',
        ];
    }

    // Mensajes de error
    public function messages(): array
    {
        return [
            'deleted_description.required' => __('companies.deleted_description_required'),
            'deleted_description.min'      => __('companies.deleted_description_min'),
            'deleted_description.max'      => __('companies.deleted_description_max'),
        ];
    }
}
