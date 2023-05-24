<?php

namespace App\Http\Requests\Actividad;

use Illuminate\Foundation\Http\FormRequest;

class ActividadesCreateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'nombre_actividad' => 'required|min:5',
            'abreviacion_actividad' => 'required|min:1',
        ];
    }
    public function messages()
    {
        return [
            'nombre_actividad.required' => 'Ingresa nombre de la actividad',
            'nombre_actividad.min' => 'El nombre de la actividad  debe contener más de 1 caracteres',

            'abreviacion_actividad.required' => 'Ingresa nombre de la abreviacion',
            'abreviacion_actividad.min' => 'El nombre de la abreviacion  debe contener más de 1 caracteres',
        ];
    }
}
