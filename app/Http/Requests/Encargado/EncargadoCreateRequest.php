<?php

namespace App\Http\Requests\Encargado;

use Illuminate\Foundation\Http\FormRequest;

class EncargadoCreateRequest extends FormRequest
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
            'nombre_encargado' => 'required|min:5|alpha',
            'numero_celular' => 'required|min:5',
            'email' => 'required|min:5',
            'direccion' => 'required|min:5',
            'numero_serial' => 'required|min:2',
        ];
    }
    public function messages()
    {
        return [

            'nombre_encargado.required' => 'Ingresa nombre y apellido',
            'nombre_encargado.min' => 'El nombre y apellido debe contener más de 5 caracteres',

            'numero_celular.required' => 'Ingresa N° de contacto',
            'numero_celular.min' => 'El N° de contacto debe contener más de 5 caracteres',

            'email.required' => 'Ingresa email',
            'email.min' => 'El email debe contener más de 5 caracteres',

            'direccion.required' => 'Ingresa dirección',
            'direccion.min' => 'La dirección debe contener más de 5 caracteres',

            'numero_serial.required' => 'Ingresa N° serial',
            'numero_serial.min' => 'El N° serial debe contener más de 2 caracteres',
        ];
    }
}
