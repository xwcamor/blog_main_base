<?php

namespace App\Http\Requests\CompanyManagement\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    // Autorizar request
    public function authorize(): bool
    {
        return true;
    }

    // Reglas de validación
    public function rules(): array
    {
        $company = $this->route('company');

        return [
            'name'    => [
                'required',
                'string',
                'max:255',
                Rule::unique('companies', 'name')->ignore($company->id),
            ],
            'num_doc' => [
                'required',
                'string',
                'min:8',
                'max:11',
                Rule::unique('companies', 'num_doc')->ignore($company->id),
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
