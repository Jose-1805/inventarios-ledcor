<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * ARCHIVOS DEL SISTEMA
 */
Route::get('/archivo/{path}',function ($path){
    $path = storage_path() .'/'. str_replace('-','/', $path);
    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::group(['middleware' => 'auth'], function () {
    /**
     * MODULOS Y FUNCIONES
     */
    Route::group(['prefix' => 'modulos-funciones'],function (){
        Route::get('/', 'ModulosFuncionesController@index');
        Route::post('/vista-modulos', 'ModulosFuncionesController@vistaModulos');
        Route::post('/vista-funciones', 'ModulosFuncionesController@vistaFunciones');
        Route::post('/actualizar-relacion', 'ModulosFuncionesController@actualizarRelacion');
        Route::post('/nuevo-modulo', 'ModulosFuncionesController@nuevoModulo');
        Route::post('/nueva-funcion', 'ModulosFuncionesController@nuevaFuncion');
        Route::post('form-modulo', 'ModulosFuncionesController@formModulo');
        Route::post('editar-modulo', 'ModulosFuncionesController@editarModulo');
        Route::post('form-funcion', 'ModulosFuncionesController@formFuncion');
        Route::post('editar-funcion', 'ModulosFuncionesController@editarFuncion');
    });

    /**
     * ROLES DEL SISTEMA
     */
    Route::group(['prefix' => 'rol'],function (){
        Route::get('/', 'RolController@index');
        Route::post('vista-roles', 'RolController@vistaRoles');
        Route::post('vista-privilegios', 'RolController@vistaPrivilegios');
        Route::post('crear', 'RolController@crear');
        Route::post('form', 'RolController@form');
        Route::post('editar', 'RolController@editar');
    });

    /**
     * USUARIOS DEL SISTEMA
     */
    Route::group(['prefix' => 'usuario'],function (){
        Route::get('/', 'UsuarioController@index');
        Route::get('/lista', 'UsuarioController@lista');
        Route::get('/create', 'UsuarioController@create');
        Route::post('/store', 'UsuarioController@store');
        Route::get('/edit/{id}', 'UsuarioController@edit');
        Route::post('/update', 'UsuarioController@update');
        Route::post('/delete', 'UsuarioController@delete');
    });

    /**
     * CONFIGURACION DEL SISTEMA
     */
    Route::group(['prefix' => 'configuracion'],function (){
        Route::get('/', 'ConfiguracionController@index');
        Route::post('/cambiar-password', 'ConfiguracionController@cambiarPassword');
    });

    /**
     * OPERARIOS DEL SISTEMA
     */
    Route::group(['prefix' => 'operario'],function (){
        Route::get('/', 'OperarioController@index');
        Route::get('/lista', 'OperarioController@lista');
        Route::get('/create', 'OperarioController@create');
        Route::post('/store', 'OperarioController@store');
        Route::get('/edit/{id}', 'OperarioController@edit');
        Route::post('/update', 'OperarioController@update');
        Route::post('/delete', 'OperarioController@delete');
    });

    /**
     * CLIENTES DEL SISTEMA
     */
    Route::group(['prefix' => 'cliente'],function (){
        Route::get('/', 'ClienteController@index');
        Route::get('/lista', 'ClienteController@lista');
        Route::get('/create', 'ClienteController@create');
        Route::post('/store', 'ClienteController@store');
        Route::get('/edit/{id}', 'ClienteController@edit');
        Route::post('/update', 'ClienteController@update');
        Route::post('/delete', 'ClienteController@delete');
    });

    /**
     * PROYECTOS DEL SISTEMA
     */
    Route::group(['prefix' => 'proyecto'],function (){
        Route::get('/', 'ProyectoController@index');
        Route::get('/lista', 'ProyectoController@lista');
        Route::get('/create', 'ProyectoController@create');
        Route::post('/store', 'ProyectoController@store');
        Route::get('/edit/{id}', 'ProyectoController@edit');
        Route::post('/update', 'ProyectoController@update');
        Route::post('/delete', 'ProyectoController@delete');
    });

    /**
     * ORDENES DE COMPRA DEL SISTEMA
     */
    Route::group(['prefix' => 'orden-compra'],function (){
        Route::get('/', 'OrdenCompraController@index');
        Route::get('/lista', 'OrdenCompraController@lista');
        Route::get('/create', 'OrdenCompraController@create');
        Route::post('/store', 'OrdenCompraController@store');
        Route::get('/edit/{id}', 'OrdenCompraController@edit');
        Route::post('/update', 'OrdenCompraController@update');
        Route::post('/delete', 'OrdenCompraController@delete');
    });

    /**
     * PROVEEDORES DEL SISTEMA
     */
    Route::group(['prefix' => 'proveedor'],function (){
        Route::get('/', 'ProveedorController@index');
        Route::get('/lista', 'ProveedorController@lista');
        Route::get('/create', 'ProveedorController@create');
        Route::post('/store', 'ProveedorController@store');
        Route::get('/edit/{id}', 'ProveedorController@edit');
        Route::post('/update', 'ProveedorController@update');
        Route::post('/delete', 'ProveedorController@delete');
    });


    /**
     * AGRUPACIÓN DE INVENTARIO
     */
    Route::group(['prefix'=>'inventario'],function (){
        Route::get('/',function (){return redirect()->back();});
        Route::resource('/material', 'MaterialController');
        Route::get('/material-lista', 'MaterialController@lista');
        Route::post('/material-select-familia', 'MaterialController@getSelectFamilia');
        Route::post('/material/delete', 'MaterialController@delete');

        Route::resource('/solicitudmaterial', 'SolicitudMaterialController');
        Route::group(['prefix'=>'solicitudmaterial'],function (){
            Route::post('/delete', 'SolicitudMaterialController@delete');
            Route::post('/delete-detalle', 'SolicitudMaterialController@deleteDetalle');
            Route::post('/store-solicitud', 'SolicitudMaterialController@storeSolicitud');
            Route::post('/update-solicitud', 'SolicitudMaterialController@updateSolicitud');
            Route::post('/form-editar', 'SolicitudMaterialController@formEditar');
            Route::post('/form-detalle', 'SolicitudMaterialController@formDetalle');
            Route::post('/save-detalle', 'SolicitudMaterialController@saveDetalle');
            Route::get('/detalle/{id}', 'SolicitudMaterialController@detalle');
            Route::get('/mail/{id}', 'SolicitudMaterialController@mail');
            Route::post('/send-mail', 'SolicitudMaterialController@sendMail');
            Route::post('/get-select', 'SolicitudMaterialController@getSelect');
            Route::post('/set-cantidad-entregada', 'SolicitudMaterialController@setCantidadEntregada');
        });
        Route::get('/solicitudmaterial-lista', 'SolicitudMaterialController@lista');
        Route::get('/solicitudmaterial-lista-detalle', 'SolicitudMaterialController@listaDetalle');


        Route::group(['prefix'=>'ingresomaterial'],function (){
            Route::get('/',function (){return redirect()->back();});
            Route::resource('/laminarollo', 'InventarioLaminaRolloController');
            Route::get('/laminarollo-lista', 'InventarioLaminaRolloController@lista');
            Route::post('/laminarollo/delete', 'InventarioLaminaRolloController@delete');

            Route::resource('/laminaantesprocesar', 'LaminaAntesProcesarController');
            Route::get('/laminaantesprocesar-lista', 'LaminaAntesProcesarController@lista');
            Route::post('/laminaantesprocesar/delete', 'LaminaAntesProcesarController@delete');

            /*Route::resource('/kardexperfileria', 'KardexPerfileriaController');
            Route::get('/kardexperfileria-lista', 'KardexPerfileriaController@lista');
            Route::post('/kardexperfileria/delete', 'KardexPerfileriaController@delete');*/


            Route::resource('/lamina', 'InventarioLaminaController');
            Route::get('/lamina-lista', 'InventarioLaminaController@lista');
            Route::post('/lamina/delete', 'InventarioLaminaController@delete');
        });

        Route::group(['prefix'=>'consumomaterial'],function (){
            Route::get('/',function (){return redirect()->back();});

            Route::resource('/laminarollo', 'ConsumoLaminaRolloController');
            Route::get('/laminarollo-lista', 'ConsumoLaminaRolloController@lista');
            Route::post('/laminarollo/delete', 'ConsumoLaminaRolloController@delete');

            Route::resource('/lamina', 'ConsumoDiarioLaminaController');
            Route::get('/lamina-lista', 'ConsumoDiarioLaminaController@lista');
            Route::post('/lamina/delete', 'ConsumoDiarioLaminaController@delete');
            Route::post('/lamina/select-consecutivo-retal', 'ConsumoDiarioLaminaController@getSelectConsecutivoRetal');

            Route::resource('/kardexretallamina', 'ConsumoKardexRetalLaminaController');
            Route::get('/kardexretallamina-lista', 'ConsumoKardexRetalLaminaController@lista');
            Route::post('/kardexretallamina/delete', 'ConsumoKardexRetalLaminaController@delete');

            Route::resource('/perfileria', 'ConsumoPerfileriaController');
            Route::get('/perfileria-lista', 'ConsumoPerfileriaController@lista');
            Route::post('/perfileria/delete', 'ConsumoPerfileriaController@delete');
        });
    });

    Route::resource('programacion','ProgramacionController');
    Route::get('programacion-lista','ProgramacionController@lista');
    Route::get('programacion-formato-importacion','ProgramacionController@formatoImportacion');
    Route::group(['prefix'=>'programacion'],function (){
        Route::post('/delete', 'ProgramacionController@delete');
        Route::post('/copiar','ProgramacionController@copiar');
        Route::post('/anexos','ProgramacionController@anexos');
        Route::post('/store-anexo','ProgramacionController@storeAnexo');
        Route::post('/importar','ProgramacionController@importar');
        Route::post('/store-seguimiento','ProgramacionController@storeSeguimiento');
    });

    Route::resource('corte','CorteController');
    Route::get('/corte-lista','CorteController@lista');
    Route::get('/corte-lista-detalle','CorteController@listaDetalle');
    Route::post('/corte-form-detalle-manual','CorteController@formDetalleManual');
    Route::group(['prefix'=>'corte'],function (){
        Route::post('/delete', 'CorteController@delete');
        Route::post('/delete-detalle-manual', 'CorteController@deleteDetalleManual');
        Route::post('/store-detalle-manual', 'CorteController@storeDetalleManual');
        Route::post('/vista-imprimir-documentos', 'CorteController@vistaImprimirDocumentos');
        Route::get('/certificado-calidad/{corte}', 'CorteController@certificadoCalidad');
        Route::get('/registro-hermeticidad/{corte}', 'CorteController@registroHermeticidad');
        Route::get('/liberacion-tanque/{corte}', 'CorteController@liberacionTanque');
        Route::get('/liberacion-mdt/{corte}', 'CorteController@liberacionMdt');
        Route::post('/data-programacion', 'CorteController@dataProgramacion');
    });

    Route::resource('calculo','CalculoController');
    Route::get('/calculo-lista','CalculoController@lista');
    Route::get('/calculo-lista-detalle','CalculoController@listaDetalle');
    Route::post('/calculo-form-detalle-manual','CalculoController@formDetalleManual');
    Route::group(['prefix'=>'calculo'],function (){
        Route::post('/delete', 'CalculoController@delete');
        Route::post('/delete-detalle-manual', 'CalculoController@deleteDetalleManual');
        Route::post('/store-detalle-manual', 'CalculoController@storeDetalleManual');
    });

    Route::resource('estado','EstadoController');
    Route::get('/estado-lista','EstadoController@lista');
});