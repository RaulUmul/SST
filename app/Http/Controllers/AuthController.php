<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    //
    public function login(Request $request){
        // Ahora toca loguear a la aplicacion...

        $rules = [
            'cui' => 'required | min:13 | max: 13',
            'password' => 'required'
        ];

        $mensajes = [
            'cui.required' => 'Ingrese su No. de DPI/CUI',
            'cui.min' => 'DPI debe tener 13 digitos minimo',
            'cui.max' => 'DPI debe tener 13 digitos maximo',
            'password.required' => 'Ingrese contraseña'
        ];

        $validator = Validator::make($request->all(),$rules,$mensajes);

        if($validator->fails()){
          $result = $validator->errors();
          return back()->withErrors($result)->withInput();
        }

        // Cual seria la logica?
        // La app deberia estar solo dentro de la red de la Institucion....
        // Los usuarios pueden registrarse? o solo los administradores pueden agregar a los tecnicos.
        $credenciales = [
            'cui->0' => $request->cui,
            'password'=>$request->password
        ];

        $remember = ($request->has('remember') ? true : false);

        if(Auth::attempt($credenciales,$remember)){
            $request->session()->regenerate();
            return redirect()->route('sistec.index');
        }else{
            return back()->withErrors(['usuario'=>'Usuario o contraseña no validas.']);
        }


    }

    public function logout(){
        \Auth::logout(); 
        \Session::flush(); 
        return redirect()->route('login.index');
    }

    public function registro(Request $request){

        // Realizamos las validaciones, todos los campos son obligatorios.

        $rules = [
            'nombres' => 'required',
            'apellidos' => 'required',
            'cui' => 'required | min:13 | max: 13',
            'password' => 'required'
        ];

        $mensajes = [
            'nombres.required' => 'Ingrese nombres completos',
            'apellidos.required' => 'Ingrese apellidos',
            'cui.required' => 'Ingrese su No. de DPI/CUI',
            'cui.min' => 'DPI debe tener 13 digitos minimo',
            'cui.max' => 'DPI debe tener 13 digitos maximo',
            'password.required' => 'Ingrese contraseña'
        ];

        $validator = Validator::make($request->all(),$rules,$mensajes);

        if($validator->fails()){
          $result = $validator->errors();
          return back()->withErrors($result)->withInput();
        }


        // Verificamos que usuario segun -> CUI. no exista en la DB
        $usuario = User::where('cui',"[$request->cui]");

        if($usuario->exists()){
          return back()->withErrors(['usuario'=>'Este usuario ya esta registrado, porfavor inicia sesion.']);
        }else if($usuario->doesntExist()){

            // Creamos el array de cui.
            $cui = array(json_decode($request->cui));
            // Creamos nuevo usuario.
            $usuario = new User();
            $usuario->cui = json_encode($cui);
            $usuario->nombres = ucfirst(strtolower($request->nombres));
            $usuario->apellidos = ucfirst(strtolower($request->apellidos));
            $usuario->password = Hash::make($request->password);
            $usuario->id_tipo_usuario = 25; //Automatizar.
            $usuario->save();

            return redirect()->route('login.index')->with('success','Registrado satisfactoriamente');
        }

        
    }

}
