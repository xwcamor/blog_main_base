<?php

namespace App\Http\Requests\SystemManagement\Locales;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $localeId = $this->route('locale')->id ?? null;

        return [
            'slug' => 'sometimes|string|max:22|unique:locales,slug,' . $localeId,
            'code' => 'sometimes|string|max:10',
            'name' => 'sometimes|string|max:255',
            'language_id' => 'sometimes|exists:languages,id',
            'is_active' => 'boolean'
        ];
    }
}
