<?php

namespace InventariosLedcor\Http\Middleware;

use Closure;
use InventariosLedcor\Models\Modulo;
use Illuminate\Support\Facades\Auth;

class PermisoModulos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  $identificador -> numero entero identificador del modulo
     * @param  \Closure  $privilegio_superadministrador -> (true -> continua si es superadministrador)
     * @return mixed
     */
    public function handle($request, Closure $next, $identificador, $privilegio_superadministrador = false)
    {
        $modulo = Modulo::where("identificador",$identificador)->first();
        if(($modulo && $modulo->estado == 'Activo')) {
            //dd(Auth::user()->tieneModulo($identificador));
            if (Auth::user()->tieneModulo($identificador))
                return $next($request);

            if ($privilegio_superadministrador) {
                if (Auth::user()->esSuperadministrador())
                return $next($request);
            }
        }


        if($request->ajax())
            return response("No autorizado",401);

        return redirect("/");
    }
}
