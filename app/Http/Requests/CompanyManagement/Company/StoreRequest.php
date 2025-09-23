<?php

namespace App\Http\Requests\CompanyManagement\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'name'    => [
                'required',
                'string',
                'max:255',
                Rule::unique('companies', 'name'),
            ],
            'num_doc' => [
                'required',
                'string',
                'max:20',
                Rule::unique('companies', 'num_doc'),
            ],
           
        ];
    }

    // Mensajes de error
    public function messages(): array
    {
        return [
            'name.required'    => __('companies.name_required'),
            'name.unique'      => __('companies.name_unique'),
            'num_doc.required' => __('companies.num_doc_required'),
            'num_doc.unique'   => __('companies.num_doc_unique'),
            'is_active.required' => __('companies.is_active_required'),
        ];
    }
}
