<?php

namespace App\Http\Requests\SystemManagement\Locales;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => 'sometimes|nullable|string|max:22|unique:locales,slug',
            'code' => 'required|string|max:10', // ej: es_PE
            'name' => 'required|string|max:255',
            'language_id' => 'required|exists:languages,id',
            'is_active' => 'boolean'
        ];
    }
}
