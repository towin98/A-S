<?php

namespace App\Http\Requests\Categoria;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaCreateRequest extends FormRequest
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
            'nombre_categoria' => 'required|min:5|unique:categorias,nombre_categoria',
        ];
    }
    public function messages()
    {
        return [
            'nombre_categoria.required' => 'Ingresa nombre de la categoria',
            'nombre_categoria.min' => 'El nombre de la categoria  debe contener más de 5 caracteres',
            'nombre_categoria.unique' => 'El nombre de la categoria  debe ser unico',
        ];
    }
}
