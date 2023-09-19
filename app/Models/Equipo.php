<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    protected $table =  'sistec.equipo';
    protected $primaryKey = 'id_equipo';
    public $timestamps = false;
    //public $autoincrement = false;
    //public $incrementing = false;
  
    public $guarded = [];

    public function servicios(){
        return $this->hasMany('App\Models\Servicio','id_equipo');
    }


}
