<?php

namespace App\Http\Requests\CompanyManagement\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'ruc' => 'required|digits:11|unique:companies,ruc,' . $this->company->id,
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'num_doc' => 'nullable|string|max:255',  // <-- Añadido aquí
        ];
    }
}
