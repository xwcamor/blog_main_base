<?php

namespace App\Http\Requests\SettingManagement\Worker;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'num_doc' => 'required|digits:8|unique:workers,num_doc,' . $this->worker->id,
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ];
    }

    
}
