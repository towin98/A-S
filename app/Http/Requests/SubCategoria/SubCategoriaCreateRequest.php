<?php

namespace App\Http\Requests\SubCategoria;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoriaCreateRequest extends FormRequest
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
            'nombre_subCategoria' => 'required|min:2',
            'abreviacion' => 'required',
            'categoria_id' => 'required|min:1',
        ];
    }
    public function messages()
    {
        return [
            'nombre_subCategoria.required' => 'Ingresa nombre de la subCategoria',
            'nombre_subCategoria.min' => 'El nombre de la subcategoria  debe contener más de 2 caracteres',
            'abreviacion.required' => 'Debe asignar una abreviacion para esta subCategoria',
            'categoria_id.required' => 'Por favor seleccionar la categoria a la que pertenece',
            'categoria_id.min' => 'El campo categoria debe asignar a la categoria que pertenece',
        ];
    }
}
