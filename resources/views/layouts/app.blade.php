<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
@section('css')
    <!-- Styles -->
        <link href="{{asset('css/helpers.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('bootstrap-3.3.7-dist/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">

        <link href="{{asset('DataTables-1.10.15/media/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/global.css')}}" rel="stylesheet" type="text/css">

        <link href="{{url('kartik_v_bootstrap_fileinput/css/fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css" />
    @show
</head>
<body id="body">
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            @include('layouts.sections.nav_bar')
        </nav>

        <div class="container">
            <div class="row padding-left-20 padding-right-20">
                <div class="col-xs-12">
                    <ol class="breadcrumb hide" style="margin-bottom: -50px;" id="breadcrump">
                    </ol>
                </div>
            </div>
        </div>

        @yield('content')
    </div>

    <div id="modal-eliminar-elemento-lista" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Eliminar</h4>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar este elemento?</p>
                    <div class="row text-right">
                        <div class="col-xs-12">
                            <a class="btn btn-sm btn-primary" data-dismiss="modal">No</a>
                            <a class="btn btn-sm btn-danger" id="btn-ok-eliminar-elemento-lista">Si</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="general_url" value="{{url('/')}}">
    <input type="hidden" id="general_token" value="{{csrf_token()}}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(function () {
            var home = "<li><a href='"+window.location.origin+"/home' class=''>Inicio</a></li>";

            var path = window.location.pathname;
            path = path.substr(1,path.length);
            var links = "";
            var lastUrl = window.location.origin;

            var excepciones = {login:'login',password:'password',public:'public',home:'home'};
            var mostrar_breadcrump = true;
            if(path.length > 0) {
                for (var i = 0; i < path.split("/").length; i++) {
                    if(excepciones[path.split("/")[i]] != undefined && i == 0){
                        mostrar_breadcrump = false;
                    }
                    if(path.split('/')[(i+1)] && $.isNumeric(path.split('/')[(i+1)])){
                        links += "<li><a href='"+lastUrl+"/"+path.split('/')[i]+"/"+path.split('/')[(i+1)]+"' class=''>"+path.split('/')[i].replace("-"," ")+"</a></li>";
                        break;
                    }else {
                        if(path.split('/')[i] != "home") {
                            var get="";
                            if((i+1) == path.split("/").length)
                                get = window.location.search;
                            links += "<li><a href='" + lastUrl + "/" + path.split('/')[i] +  get +  "' class=''>" + path.split('/')[i].replace("-"," ") + "</a></li>";
                            lastUrl = lastUrl + "/" + path.split('/')[i];
                        }
                    }
                }
            }

            if(links.length && mostrar_breadcrump) {
                $("#breadcrump").html(home + links);
                $("#breadcrump").removeClass("hide");
            }
        })
    </script>
    @section('js')
        <script src="https://use.fontawesome.com/a8d29b5cc4.js"></script>
        <script src="{{asset('js/blockUi.js')}}"></script>
        <script src="{{asset('js/global.js')}}"></script>
        <script src="{{asset('js/params.js')}}"></script>
        <script src="{{asset('DataTables-1.10.15/media/js/jquery.dataTables.js')}}"></script>
        <script src="{{url('kartik_v_bootstrap_fileinput/js/plugins/piexif.min.js')}}" type="text/javascript"></script>
        <script src="{{url('kartik_v_bootstrap_fileinput/js/plugins/sortable.min.js')}}" type="text/javascript"></script>
        <script src="{{url('kartik_v_bootstrap_fileinput/js/plugins/purify.min.js')}}" type="text/javascript"></script>
        <script src="{{url('kartik_v_bootstrap_fileinput/js/fileinput.min.js')}}"></script>
        <script src="{{url('kartik_v_bootstrap_fileinput/js/locales/es.js')}}"></script>
    @show
</body>
</html>
