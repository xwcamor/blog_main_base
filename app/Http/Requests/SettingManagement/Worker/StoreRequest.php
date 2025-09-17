<?php

namespace App\Http\Requests\SettingManagement\Worker;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'num_doc' => 'required|unique:workers,num_doc|digits:8',
        ];
    }
}
        