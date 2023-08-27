<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacturaRequest extends FormRequest
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
            // validaciones
            'folio_fiscal' => ['required'],
            'certificado_emisor' => ['required'],
            'certificado_sat' => ['required'],
            'tipo_comprobante' => ['required'],
            'fecha_emision' => ['required'],
            'fecha_certificacion' => ['required'],
        ];
    }

    public function messages(){
        return [
            'folio_fiscal.required' => 'el :attribute es requerido',
            'certificado_emisor.required' => 'el :attribute es requerido',
            'certificado_sat.required' => 'el :attribute es requerido',
            'tipo_comprobante.required' => 'el :attribute es requerido',
            'fecha_emision.required' => 'la :attribute es requerida',
            'fecha_emision.date_format' => 'la :attribute debe de tener el formato Y-m-d H:i:s',
            'fecha_certificacion.required' => 'la :attribute es requerida',
            'fecha_certificacion.date_format' => 'la :attribute debe de tener el formato Y-m-d H:i:s',
        ];
    }

    public function attributes(){
        return [
            'folio_fiscal' => 'Folio Fiscal UUID',
            'certificado_emisor' => 'No. Certificado del Emisor',
            'certificado_sat' => 'No. Certificado del SAT',
            'tipo_comprobante' => 'Tipo de Comprobante',
            'fecha_emision' => 'Fecha de Emisión',
            'fecha_certificacion' => 'Fecha de Certificación',
        ];
    }
}
