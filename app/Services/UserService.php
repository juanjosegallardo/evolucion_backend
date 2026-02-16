<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;
use App\Models\User;

class UserService
{
    /**
     * Create a new class instance.
     */


    
    public function __construct()
    {

    }   

    public function guardar(Request $request)
    {
        DB::transaction(function() use ($request) {

            $usuario = User::where("usuario",$request->usuario)->first();
            if($usuario)
            {
                throw new \Exception("Ya hay un usuario con este nombre de usuario registrado");
            }
                
            $user =  new User();
            $user->nombre = $request->nombre;
            $user->password= $request->password;
            $user->usuario =$request->usuario;
            $user->save();   
        });
    }

}