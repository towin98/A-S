<?php

namespace App;

use App\Models\Hocol;
use App\Models\Ingreso;
use App\Models\Recarga;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'apellido', 'cargo', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    #Llaves foraneas
    public function IngresoUsuario()
    {
        //RELACION CON INGRESO
        return $this->hasMany(Ingreso::class, 'usuario_id', 'id');
    }
    public function UsuarioRecarga()
    {
        //RELACION CON RECARGA
        return $this->hasMany(Recarga::class, 'usuario_recarga_id', 'id');
    }
    public function hocolRegistroColaborador()
    {
        //RELACION CON RECARGA
        return $this->hasMany(Hocol::class, 'id_colaborador', 'id');
    }
}
