<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function create(){
        return view('equipos.create');
    }
}
