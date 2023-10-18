<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8'],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'La :attribute es requerida',
            'password.min' => 'La :attribute debe de tener 8 caracteres minimo',
            'password.confirmed' => 'La :attribute no concuerda con la Contraseña de confirmación',
            'password_confirmation.required' => 'La :attribute es requerida'
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'Nueva Contraseña',
            'password_confirmation' => 'Contraseña de Confirmación'
        ];
    }
}
