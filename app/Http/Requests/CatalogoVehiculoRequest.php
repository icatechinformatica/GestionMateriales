<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatalogoVehiculoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //retorna la validación
            'marca_editar' => ['required'],
            'placas_editar' => ['required'],
            'color_editar' => ['required'],
            'numero_motor_editar' => ['required'],
            'tipo_editar' => ['required'],
            'numero_serie_editar' => ['required'],
            'resguardante_editar' => ['required'],
            'numero_economico_editar' => ['required'],
        ];
    }

    public function messages(){
        return [
            'marca_editar.required' => 'La :attribute es requerida',
            'placas_editar.required' => 'La :attribute es requerida',
            'color_editar.required' => 'El :attribute es requerido',
            'numero_motor_editar.required' => 'El :attribute es requerido',
            'tipo_editar.required' => 'El :attribute es requerido',
            'numero_serie_editar.required' => 'El :attribute es requerido',
            'resguardante_editar.requiered' => 'El :attribute es requerido',
            'numero_economico_editar.required' => 'El :attribute es requerido',
        ];
    }

    public function attributes(){
        return [
            'marca_editar' => 'Marca',
            'placas_editar' => 'Placa',
            'color_editar' => 'Color',
            'numero_motor_editar' => 'Número de Motor',
            'tipo_editar' => 'Tipo',
            'numero_serie_editar' => 'Número de Serie',
            'resguardante_editar' => 'Resguardante',
            'numero_economico_editar' => 'Número Económico',
        ];
    }
}
