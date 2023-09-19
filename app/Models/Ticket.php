<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table =  'sistec.ticket';
    protected $primaryKey = 'id_ticket';
    public $timestamps = false;
  
    public $guarded = [];

    public function servicios(){
        return $this->hasMany('App\Models\Servicio','id_ticket');
    }
}
