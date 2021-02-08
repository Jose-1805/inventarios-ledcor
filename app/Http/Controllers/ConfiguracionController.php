<?php

namespace InventariosLedcor\Http\Controllers;

use InventariosLedcor\Http\Requests\CambioPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Zend\Diactoros\Request;

class ConfiguracionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index()
    {
        return view('configuracion/index');
    }

    public function cambiarPassword(CambioPasswordRequest $request){
        $user = Auth::user();
        if(Hash::check($request->input('password_old'),$user->password)){
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return ['success'=>true];
        }else{
            return response(['error'=>['La contraseña antigua es incorrecta']],422);
        }
    }

}
