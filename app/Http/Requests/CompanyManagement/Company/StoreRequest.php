<?php

namespace App\Http\Requests\CompanyManagement\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'ruc' => 'required|unique:companies,ruc|digits:11',
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'num_doc' => 'nullable|string|max:255',
        ];
    }
}