<?php

namespace App\Http\Requests\Prueba;

use Illuminate\Foundation\Http\FormRequest;

class PruebaCreateRequest extends FormRequest
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
            'nombre_prueba' => 'required|min:5|unique:pruebas,nombre_prueba,',
            'abreviacion_prueba' => 'required|min:2|unique:pruebas,abreviacion_prueba,',
        ];
    }
    public function messages()
    {
        return [
            'nombre_prueba.required' => 'Ingresa nombre de la prueba',
            'nombre_prueba.min' => 'El nombre de la prueba  debe contener más de 5 caracteres',
            'nombre_prueba.unique' => 'El nombre de la prueba debe ser unico',

            'abreviacion_prueba.required' => 'Ingresa nombre de la abreviacion',
            'abreviacion_prueba.min' => 'El nombre de la abreviacion  debe contener más de 2 caracteres',
            'abreviacion_prueba.unique' => 'El nombre de la abreviacion debe ser unico',
        ];
    }
}
