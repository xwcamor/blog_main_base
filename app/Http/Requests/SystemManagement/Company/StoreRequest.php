<?php

namespace App\Http\Requests\SystemManagement\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'ruc' => 'required|unique:companies,ruc|digits:11',
        ];
    }
}