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
        
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet" >
        <link href="{{ asset('css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/carousel.css') }}" rel="stylesheet" type="text/css">
        <!--Icons -->
        <link rel="stylesheet" href="{{ asset("css/font-awesome.css") }}" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
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
            <div class="">
                <!-- Primul rind-->
                <div class="content sus"> 
                    <ul class="reglog">
                        <li class="first hidden-sm hidden-xs">
                            <a href="{{URL('/helpbuy')}}">Cum cumpar?</a>
                        </li>
                        <li class="hidden-sm hidden-xs">
                            <a href="#">Contact</a>
                        </li>
                        <li class="hidden-sm hidden-xs last">
                            <a href="#">Despre noi</a>
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
                    <div class="col-md-3" style="padding-right: 0px;">
                        <div class="col-md-9 col-sm-12 col-xs-12" style="padding: 0px; margin-bottom:10px;">
                            <a href="{{URL("/")}}">
                                <?php
                                    $logo=  App\Logo::getInfo(); 
                                ?>
                                @if(!empty($logo["logo"]))
                                    <img src="{{ asset ( $logo["logo"]->valuevariable ) }}" class='img-responsive'>
                                @else
                                    home
                                @endif
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12" style="padding: 0px;">
                            @include('partials.menu')
                        </div>
                    </div>
                    <!--Cauta -->
                    <div class="col-md-6 col-sm-12 col-xs-12" style="margin-bottom:10px;">
                        <form class="form-cauta" action="{{URL("search")}}">
                            <input type="text" id="search" name="search" placeholder="Cauta" autocomplete="off"/>
                            <button type="submit" id="cauta">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
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
            
        <div class='container' style="border-top: 1px solid #ccc;">
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