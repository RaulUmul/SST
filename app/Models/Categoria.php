<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table =  'sistec.categoria';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;
    public $autoincrement = false;
    public $incrementing = false;


    public function items(){
        return $this->hasMany('\App\Models\Item','id_categoria');
    }
}
