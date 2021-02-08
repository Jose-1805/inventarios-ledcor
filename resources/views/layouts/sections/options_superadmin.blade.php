<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        Programación <span class="caret"></span>
    </a>

    <ul class="dropdown-menu" role="menu">
        <li class=""><a href="{{url('/programacion')}}">Programación</a></li>
        <li class=""><a href="{{url('/corte')}}">Listado de corte</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        Inventario <span class="caret"></span>
    </a>

    <ul class="dropdown-menu multi-level" role="menu">
        <li class=""><a href="{{url('/inventario/material')}}">Materiales</a></li>
        <li class=""><a href="{{url('/inventario/solicitudmaterial')}}">Solicitud de materiales</a></li>
        <li class="dropdown-submenu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Ingreso de materiales
            </a>

            <ul class="dropdown-menu" role="menu">
                <li class=""><a href="{{url('/inventario/ingresomaterial/laminarollo')}}">Lámina rollo (FC13)</a></li>
                <li class=""><a href="{{url('/inventario/ingresomaterial/laminaantesprocesar')}}">Lámina sin procesar (FC18)</a></li>
                <!--<li class=""><a href="{{url('/inventario/ingresomaterial/kardexperfileria')}}">Perfilería (FC22)</a></li>-->
                <li class=""><a href="{{url('/inventario/ingresomaterial/lamina')}}">Lámina(FC11)</a></li>
            </ul>
        </li>
        <li class="dropdown-submenu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Consumo de materiales
            </a>

            <ul class="dropdown-menu" role="menu">
                <li class=""><a href="{{url('/inventario/consumomaterial/laminarollo')}}">Lámina rollo (FC02)</a></li>
                <li class=""><a href="{{url('/inventario/consumomaterial/lamina')}}">Lámina (FC24)</a></li>
                <li class=""><a href="{{url('/inventario/consumomaterial/kardexretallamina')}}">Retal lámina (FC08)</a></li>
                <li class=""><a href="{{url('/inventario/consumomaterial/perfileria')}}">Perfilería (FC19)</a></li>
            </ul>
        </li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        Administración <span class="caret"></span>
    </a>

    <ul class="dropdown-menu" role="menu">
        <li class=""><a href="{{url('/operario')}}">Operarios</a></li>
        <li class=""><a href="{{url('/cliente')}}">Clientes</a></li>
        <li class=""><a href="{{url('/proyecto')}}">Proyectos</a></li>
        <li class=""><a href="{{url('/orden-compra')}}">Ordenes de compra</a></li>
        <li class=""><a href="{{url('/proveedor')}}">Proveedores</a></li>
        <li class=""><a href="{{url('/calculo')}}">Calculos</a></li>
        <li class=""><a href="{{url('/estado')}}">Estados</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        Reportes <span class="caret"></span>
    </a>

    <ul class="dropdown-menu" role="menu">
        <li class=""><a href="{{url('/reporte/material-disponible')}}">Material disponible</a></li>
        <li class=""><a href="{{url('/reporte/consumo-material-proyecto')}}">Consumo material x proy</a></li>
        <li class=""><a href="{{url('/reporte/comparacion-consumo-material')}}">Compar consumo material</a></li>
        <li class=""><a href="{{url('/reporte/proyectos-estado')}}">Proyectos estado</a></li>
        <li class=""><a href="{{url('/reporte/proyectos-vencimiento')}}">Proyectos prox vencim</a></li>
        <li class=""><a href="{{url('/reporte/material-bajo-stock')}}">Material bajo stock</a></li>
        <li class=""><a href="{{url('/reporte/retales-disp')}}">Retales disp</a></li>
        <li class=""><a href="{{url('/reporte/material-reproc')}}">Material reproc</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        Sistema <span class="caret"></span>
    </a>

    <ul class="dropdown-menu" role="menu">
        <li class=""><a href="{{url('/modulos-funciones')}}">Módulos & funciones</a></li>
        <li class=""><a href="{{url('/rol')}}">Roles</a></li>
        <li class=""><a href="{{url('/usuario')}}">Usuarios</a></li>
    </ul>
</li>