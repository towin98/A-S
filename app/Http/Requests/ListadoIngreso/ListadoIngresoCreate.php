<?php

namespace App\Http\Requests\ListadoIngreso;

use Illuminate\Foundation\Http\FormRequest;

class ListadoIngresoCreate extends FormRequest
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
            'ingreso_id'=>'required',
            'unidad_medida_id'=>'required',
            'numero_extintor'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'ingreso_id.required'=>'Ingresa N° de referencia',

            'unidad_medida_id.required'=>'Seleccione unidad de medida',

            'numero_extintor.required'=>'Ingresa numero de extintor',
        ];
    }
}
