<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Rol;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table =  'sistec.usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cui',
        'nombre',
        'apellidos',
        'password',
        'roles',
        'id_tipo_usuario'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
        // 'remember_token',
    ];


    protected $appends = ['rol'];

    public function getRolAttribute(){
        $descripcion = '';
        if(!empty($this->roles)){

            $ids = json_decode($this->roles);


            foreach($ids as $key => $id){
                $rol = Rol::where('id_rol',$id)->first();

            if($rol != null){
                $descripcion=
                $key==0
                  ? $rol->rol.'.'
                  : $descripcion.' '.$rol->rol.'.';
            }
        }

            // dd($descripcion);

            return $descripcion;
        }

    }

    public function hasRole($role){
        if(strpos($this->rol,$role) !== false)
            return true;
    }
    
}
