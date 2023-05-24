<?php

namespace App\Http\Requests\CambioParte;

use Illuminate\Foundation\Http\FormRequest;

class CambioPartesCreateRequest extends FormRequest
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
            'nombre_parte_cambio' => 'required|min:5|unique:cambio_parte_extintor,nombre_parte_cambio',
            'referencia' => 'required|min:1',
        ];
    }
    public function messages()
    {
        return [
            'nombre_parte_cambio.required' => 'Ingresa nombre de la parte de cambio',
            'nombre_parte_cambio.min' => 'El nombre de la parte de cambio  debe contener más de 1 caracteres',
            'nombre_parte_cambio.unique' => 'El nombre de la parte debe ser unico',

            'referencia.required' => 'Ingresa nombre de la abreviacion',
            'referencia.min' => 'El nombre de la abreviacion  debe contener más de 1 caracteres',
        ];
    }
}
