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
            'ingreso_id'                => 'required|numeric',
            'unidad_medida_id'          => 'required|numeric',
            'actividad'                 => 'required|numeric',
            'numero_extintor'           => 'required|numeric|min:1'
        ];
    }
    public function messages()
    {
        return [
            'ingreso_id.required'           => 'El id de ingreso es requerido.',
            'ingreso_id.numeric'            => 'El id de ingreso debe ser númerico.',
            'actividad.required'            => 'La Actividad es requerido.',
            'actividad.numeric'             => 'La Actividad debe ser númerico.',
            'unidad_medida_id.required'     => 'La Unidad de medida es requerido.',
            'unidad_medida_id.numeric'      => 'La Unidad de medida debe ser númerico.',
            'numero_extintor.required'      => 'El número de extintores es requerido.',
            'numero_extintor.min'           => 'El número de extintores debe ser mayor a 0.',
            'numero_extintor.numeric'       => 'El número de extintores debe ser númerico.',
        ];
    }
}
