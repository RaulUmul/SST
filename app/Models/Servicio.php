<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $table =  'sistec.servicio';
    protected $primaryKey = 'id_servicio';
    public $timestamps = false;
  
    public $guarded = [];

    // Verificar funcionamiento
    public function ticket(){
        return $this->belongsTo('App\Models\Ticket','id_servicio');
    }

    public function equipo(){
        return $this->belongsTo('App\Models\Equipos','id_servicio');
    }
    
}
