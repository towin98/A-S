<?php

namespace App\Http\Requests\Recarga;

use Illuminate\Foundation\Http\FormRequest;

class RecargaCreate extends FormRequest
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
            'nro_tiquete_anterior'=>'required|min:1',
            'nro_tiquete_nuevo'=>'required|min:1',
            'nro_extintor'=>'required|min:1',
            'agente'=>'required|min:5',
            'usuario_recarga_id'=>'required',
            'ingreso_recarga_id'=>'required',
            'activida_recarga_id'=>'required',
            'cambio_parte_id'=>'required',
            'prueba_id'=>'required',
            'fuga_id'=>'required',
            'observacion'=>'required|min:5',

        ];
    }
    public function messages()
    {
        return [
            'nro_tiquete_anterior.required' => 'Ingresa numero de tiquete anterior',
            'nro_tiquete_anterior.min' => 'El numero de tiquete anterior debe contener más de 5 caracteres',

            'nro_tiquete_nuevo.required' => 'Ingresa numero de tiquete nuevo',
            'nro_tiquete_nuevo.min' => 'El numero de tiquete nuevo debe contener más de 5 caracteres',

            'nro_extintor.required' => 'Ingresa numero de extintor',
            'nro_extintor.min' => 'El numero de extintor debe contener más de 5 caracteres',

            'agente.required' => 'Ingresa agenter',
            'agente.min' => 'El agente debe contener más de 5 caracteres',

            'usuario_recarga_id.required' => 'Ingresa identificacion de usuario',

            'ingreso_recarga_id.required' => 'Ingresa la referencia del ingreso',

            'activida_recarga_id.required' => 'Ingresa la actividad',

            'cambio_parte_id.required' => 'Ingresa cambio de partes',
            
            'prueba_id.required' => 'Ingresa prueba',

            'fuga_id.required' => 'Ingresa fuga',

            'observacion.required' => 'Ingresa la observación',
            'observacion.min' => 'La observación debe contener más de 5 caracteres',
        ];
    }
}
