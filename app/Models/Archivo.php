<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;
    protected $table =  'sistec.archivo';
    protected $primaryKey = 'id_archivo';
    public $timestamps = false;
    // public $autoincrement = false;
    // public $incrementing = false;
}
