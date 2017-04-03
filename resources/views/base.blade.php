<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ecomert</title>
        <!-- css javascript 
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>-->
        <script src="{{ asset("js/jquery.min.js") }}"></script>
        <script src="{{ asset("js/bootstrap.min.js") }}"></script>
        
        <script src="{{ asset("js/modernizr.custom.js") }}"></script>
        
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet" >
        <link href="{{ asset('css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
        <!--Icons -->
        <link rel="stylesheet" href="{{ asset("css/font-awesome.css") }}" >
        <link rel="stylesheet" href="{{ asset("css/font-awesome.min.css") }}">
        <!-- token-->
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <script type="text/javascript">
        $.ajaxSetup({
           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
        </script>
    </head>
    <body>
        <!-- Meniu-->
        <div class="container">
            <!-- Descktop-->
            <div class="hidden-sm hidden-xs">
                <!-- Primul rind-->
                <div class="content sus"> 
                    <ul class="reglog">
                        <li class="first">
                            <a href="#">Cum cumpar?</a>
                        </li>
                        <li>
                            <a href="#">Despre noi</a>
                        </li>
                        <li>
                            <a href="#">Ajutor</a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/watch?v=1eZpP1IdA5g" target="_black">Video upload</a>
                        </li>
                        <li>
                            <a href="https://davidwalsh.name/css-flip" target="_black">Rotate image</a>
                        </li>
                        <li>
                            <a href="http://devartisans.com/articles/image-upload-laravel-5" target="_black">Video upload1</a>
                        </li>
                        <li>
                            <a href="http://global.reebok.com/Z82032.html" target="_black">Ex pro</a>
                        </li>
                        <li>
                            <a href="http://www.kipling.com.br/produto/mochila-clas-seoul-estampada-autumm-leaf-kipling-65726" target="_black">Example product1</a>
                        </li>
                        <li>
                            <a href="https://css-tricks.com/snippets/php/create-url-slug-from-post-title/" target="_black">URL from title</a>
                        </li>
                        <li>
                            <a href="https://xdorialife.com/products/defense-lux-iphone-7-case?variant=19947838149" target="_black">Example product2</a>
                        </li>
                        <li class="last">
                            <a href="{{URL("/test")}}">Test</a>
                        </li>
                        <!--Login si register form-->
                        <div class="pull-right">
                            @if(Session::has('nume') && Session::has('id'))
                                <a href="#">{{Session('nume')}}</a>
                                <a href="{{URL("/exit")}}">Exit</a>
                            @else
                                @include('partials.register')
                            @endif 
                        </div>
                    </ul>
                </div>
                <!-- Al doilea rind cu logo-->
                <div class="content row">
                    <!-- Logo-->
                    <div class="col-md-3">
                        <div class="col-md-5">
                            @include('partials.menu')
                        </div>
                        <div class="col-md-7">
                            <a href="{{URL("/")}}">
                                <h1 style="margin:0px;">Magazin</h1>
                            </a>
                        </div>
                    </div>
                    <!--Cauta -->
                    <div class="col-md-6">
                        <form class="form-cauta" action="{{URL("search")}}">
                            <input type="text" id="search" name="search" placeholder="Cauta" autocomplete="off"/>
                            <input type="submit" value="GO" id="cauta"/>
                        </form>
                    </div>
                    <!-- cos register-->
                    <div class="col-md-3">
                        <div class="content">
                            @include('partials.cos')
                        </div>
                    </div>
                </div> 
            </div>
        </div>
            
        <div class='container' style="border-top: 1px solid #ccc;margin-top: 10px;">
            <div class="row">
                @yield('content')
            </div>  
        </div>
        <div class="fullpageload" id="fullpageload">
            <div class="imgload">
                <img src="{{asset("img/system/spin.gif")}}"/>
            </div>
        </div>
        <footer style="height: 100px;">

        </footer>
    </body>
</html>