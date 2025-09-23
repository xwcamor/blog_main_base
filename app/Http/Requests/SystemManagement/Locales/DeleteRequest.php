<?php

namespace App\Http\Requests\SystemManagement\Locales;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deleted_by' => 'nullable|integer|exists:users,id',
            'deleted_description' => 'nullable|string'
        ];
    }
}
