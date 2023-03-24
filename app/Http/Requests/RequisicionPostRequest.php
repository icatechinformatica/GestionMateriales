<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequisicionPostRequest extends FormRequest
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
            //
            'fechaRequisicion' => ['required'],
        ];
    }

    public function messages(){
        return [
            'fechaRequisicion.required' => 'La :attribute es obligatorio',
        ];
    }

    public function attributes()
    {
        return [
            'fechaRequisicion' => 'Fecha de Requisición',
        ];
    }
}
