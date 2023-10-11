<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsuariosController extends Controller
{
    //
    public function index(){
        return view('admon.index');
    }

    public function buscar(Request $request){

        $rules = [
            'cui'=>'required | min:13 | max:13'
        ];
        $mensajes = [
            'cui.required'=>'CUI Requerido',
            'cui.min'=>'Ingrese numero de CUI valido',
            'cui.max'=>'Ingrese numero de CUI valido'
        ];

        $validator = Validator::make($request->all(),$rules,$mensajes);

        if($validator->fails()){
            $result = $validator->errors();
            return  response()->json($result,500);
        }

        $roles = Rol::all();

        // Hay que hacer consulta a la tabla de usuario.
        $usuario = User::where('cui',"[$request->cui]");
        if($usuario->exists()){
            return response()->json(['roles'=>$roles,'usuario'=>$usuario->first()],200);
        }else if($usuario->doesntExist()){
            return response()->json(['El usuario no ha sido registrado en el sistema'],500);
        }


    }


    public function update_roles(Request $request){
        // Aqui vamos a verificar que roles se le asigno al usuario.
        // return $request;
        $roles=[];
        if($request->administrador == 'on'){
            array_push($roles,2) ;///COMO VALIDAMO ESTA MADRE PEZ...
        }else{
            unset($roles[2]);
        }
        if($request->operador == 'on'){
            array_push($roles,3);
        }else{
            unset($roles[3]);
        }

        if($request->administrador == 'off' && $request->operador == 'off')
            $roles = null;
        // $roles = ['administrador'=>$request->administrador,'operador'=>$request->operador];
        // $roles = self::resolveRoles($roles);

        $usuario = User::find($request->id_usuario);
        $usuario->roles = $roles;
        $usuario->save();

        return back()->with('success','Roles asignados correctamente');

    }

    // static  function resolveRoles($roles){
    //     $resultado[];
    //     foreach ($roles as $key => $value) {
    //         if($value )
    //     }
    //     return $request;
    // }

    public function restablecerKey(Request $request){
        $user = User::find($request->id_user);
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success','Contraseña restablecida');
    }

    
}
