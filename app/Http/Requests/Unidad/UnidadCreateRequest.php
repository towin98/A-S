<?php

namespace App\Http\Requests\Unidad;

use Illuminate\Foundation\Http\FormRequest;

class UnidadCreateRequest extends FormRequest
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
            'unidad_medida' => 'required|min:2',
            'cantidad_medida'=> 'required|between:1,10',
            'sub_categoria_id'=> 'required',
        ];
    }
    public function messages()
    {
        return [
            'unidad_medida.required' => 'Ingresa nombre de la Unidad de medida',
            'unidad_medida.min' => 'El nombre de la unidad de medida  debe contener más de 2 caracteres',

            'cantidad_medida.required' => 'Ingresa la cantidad de medida',
            'cantidad_medida.between' => 'La cantidad debe ser mayor a 1',

            'sub_categoria_id.required' => 'Debe seleccionar una subCategoria a la que pertenece',
        ];
    }
}
