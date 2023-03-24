<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
            'textmemorandum' => ['required', 'max:3072', 'mimes:doc,docx,pdf']
        ];
    }

    public function messages(){
        return [
            'textmemorandum.required' => 'El :attribute es obligatorio',
            'textmemorandum.max' => 'El :attribute no puede ser mayor a 3MB',
            'textmemorandum.mimes' => 'Sólo se permiten documentos tipos PDF y Word para el :attribute'
        ];
    }

    public function attributes(){
        return [
            'textmemorandum' => 'Memorandum'
        ];
    }
}
