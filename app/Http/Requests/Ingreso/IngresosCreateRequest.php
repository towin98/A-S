<?php

namespace App\Http\Requests\Ingreso;

use Illuminate\Foundation\Http\FormRequest;

class IngresosCreateRequest extends FormRequest
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
            'fecha_recepcion' => 'required|date',
            'fecha_entrega' => 'required|date',
            'numero_referencia' => 'required|numeric|min:1',
            'encargado_id' => 'required|numeric|min:1',
            'usuario_id' => 'required|numeric|min:1',
            'numero_total_extintor' => 'required|numeric|min:1',
            'estado' => 'required',
        ];
    }
    public function messages()
    {
        return [

            'fecha_recepcion' => 'required|date',
            'fecha_entrega' => 'required|date',
            'numero_referencia' => 'required|numeric|min:1',
            'encargado_id' => 'required|numeric|min:1',
            'usuario_id' => 'required|numeric|min:1',
            'numero_total_extintor' => 'required|numeric|min:1',
            'estado' => 'required',


            'fecha_recepcion.required' => 'La fecha de ingreso es obligatoria',
            'fecha_recepcion.date' => 'El formato de la fecha no es correcto',

            'fecha_entrega.required' => 'La fecha de entrega es obligatoria',
            'fecha_entrega.date' => 'El formato de la fecha no es correcto',

            'numero_referencia.required' => 'Ingresa numero de referencia',
            'numero_referencia.min' => 'El numero de referencia  debe contener más de 1 caracteres',

            'encargado_id.required' => 'Ingresa seleccionar el campo de  encargado',
            'encargado_id.min' => 'El campo encargado  debe contener más de 1 caracteres',

            'usuario_id.required' => 'Ingresa nombre del usuario',
            'usuario_id.min' => 'El campo de usuario  debe contener más de 1 caracteres',

            'numero_total_extintor.required' => 'Ingresa numero de extintores',
            'numero_total_extintor.min' => 'El numero de extintores  debe contener más de 1 caracteres',
        ];
    }
}
