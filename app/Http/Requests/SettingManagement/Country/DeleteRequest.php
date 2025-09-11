<?php

namespace App\Http\Requests\SettingManagement\Country;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    // Autoriza la solicitud
    public function authorize(): bool
    {
        return true;
    }

    // Reglas de validación
    public function rules(): array
    {
        return [
            'deleted_description' => 'required|string|max:500',
        ];
    }

    // Mensajes personalizados
    public function messages(): array
    {
        return [
            'deleted_description.required' => 'Debe ingresar un motivo de eliminación.',
            'deleted_description.string'   => 'El motivo debe ser una cadena de texto válida.',
            'deleted_description.max'      => 'El motivo debe tener como máximo 500 caracteres.',
        ];
    }
}
