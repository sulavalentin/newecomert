@extends('base')
@section('content')
@include('partials.carosel')
<div class="container">
    <div class="row">
        <div class="col-md-3 hidden-sm hidden-xs">
            <style>
                .dropdown-submenu{position:relative;}
                .dropdown-submenu>.dropdown-menu{
                    top:0;
                    left:100%;
                    margin-top:-6px;
                    margin-left:-1px;
                    -webkit-border-radius:0 6px 6px 6px;
                    -moz-border-radius:0 6px 6px 6px;
                    border-radius:0 6px 6px 6px;}
                .dropdown-submenu:hover>.dropdown-menu{display:block;}
                .dropdown-submenu>a:after{display:block;
                      content:" ";
                      float:right;
                      width:0;
                      height:0;
                      border-color:transparent;
                      border-style:solid;
                      border-width:5px 0 5px 5px;
                      border-left-color:#e03c40;
                      margin-top:5px;
                      margin-right:-10px;}
                .dropdown-submenu:hover>a:after{
                    border-left-color:white; }
                .dropdown-submenu.pull-left{
                    float:none;}
                .dropdown-submenu.pull-left>.dropdown-menu{
                    left:-100%;
                    margin-left:10px;
                    -webkit-border-radius:6px 0 6px 6px;
                    -moz-border-radius:6px 0 6px 6px;
                    border-radius:6px 0 6px 6px;}
                .cpointer{
                    cursor: pointer;
                }
                .dropdown-menu>li>a:hover {
                    color: #fff;
                    text-decoration: none;
                    background-color: #357ebd;
                    background-image: -webkit-gradient(linear,left 0,left 100%,from(#428bca),to(#357ebd));
                    background-image: -webkit-linear-gradient(top,#428bca,0%,#357ebd,100%);
                    background-image: -moz-linear-gradient(top,#428bca 0,#357ebd 100%);
                    background-image: linear-gradient(to bottom,#428bca 0,#357ebd 100%);
                    background-repeat: repeat-x;
                    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff428bca',endColorstr='#ff357ebd',GradientType=0);

                }
            </style>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" 
                style=" display: block;
                        width: 100%;
                        height: 0px;
                        padding: 0px;
                        margin: 55px 0px 0px 0px;
                        z-index: 2; border: 1px;">
                @if(!empty(Session('menu')))
                    @foreach(Session('menu') as $i)
                        <li class="dropdown-submenu">
                            <a class="cpointer">{{$i->menu_name}}</a>
                            @if(!empty(Session('submenu')))
                                <ul class="dropdown-menu">
                                    @foreach(Session('submenu') as $j)
                                        @if($j->menu_id==$i->id)
                                            <li>
                                                <a href="{{URL("/submenu/".$j->id)}}">
                                                    <b>{{$j->submenu_name}}</b>
                                                </a>
                                            </li>
                                        @if(Session('items'))
                                                @foreach(Session('items') as $k)
                                                    @if($j->id==$k->submenu_id)
                                                    <li>
                                                        <a href="{{URL("sort=priceUp/[".$k->id."]-".$k->item_name."/page=1")}}">
                                                            {{$k->item_name}}
                                                        </a>
                                                    </li>
                                                @else
                                                    @continue;
                                                @endif
                                            @endforeach
                                        @endif
                                        @else
                                            @continue;
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                        <li class="divider"></li>
                    @endforeach
                @endif  
            </ul>
        </div>
        <div class="col-md-9">
            <!--Cele mai populare -->
            @if(!empty($populars) && count($populars)>0)
            <div class="col-md-12 text-center">
                <h3>Cele intrebate produse</h3>
            </div>
            <div class="carousel slide" id="myCarousel1" name='carousel1'>
                <div class="carousel-inner allproducts" style='float:none;'>
                        <?php $nr=0;?>
                        @foreach($populars as $k)
                            <div 
                                <?php 
                                    if($nr==0){
                                        echo "class='item active'";
                                        $nr++;
                                    }else{
                                        echo "class='item'";
                                    }
                                ?>
                                name='item1'
                                >
                                <li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> 
                                    <div class="continut_product">
                                        <div class="continut_image">
                                            <a href="{{URL("/product/".$k->id)}}">
                                                @if(\File::exists($k->address))
                                                    <img  src="{{asset($k->address)}}" class="img-responsive"/>
                                                @else
                                                    <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive"/>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="name">
                                            <a class="NumeProduct" href="{{URL("/product/".$k->id)}}">
                                                <p title="{{$k->originalname}}{{$k->name}}">
                                                    {{$k->originalname}}{{$k->name}}
                                                </p>
                                            </a>
                                        </div>
                                        <p class="price calibri">
                                            {{number_format(floor($k->price), 0, '.', ' ')}}
                                            <sup class="price_dec">
                                                ,{{str_replace("0.","",(string)number_format(round($k->price - (int)$k->price,2),2))}}
                                            </sup>
                                            <span>Lei</span>
                                        </p>
                                        <button class="addcart" name="addcart" prod="{{$k->id}}">
                                            <span class="glyphicon glyphicon-shopping-cart"></span>
                                            Adauga in cos
                                        </button>
                                        <button class="favorite calibri" name="addfavorite" prod="{{$k->id}}">
                                            @if(is_null($k->idfavorite))
                                                <span class="icon-heart-empty"></span>
                                            @else
                                                <span class="icon-heart"></span>
                                            @endif
                                            Adauga la favorite
                                        </button>
                                        <button class="compare calibri" name="addcompare" prod="{{$k->id}}" title="Compara">
                                            <span class="glyphicon glyphicon-sort"></span>
                                        </button>
                                        <button class="compare previewbutton" prod="{{$k->id}}" name="peview" title="Preview">
                                            <span class="fa fa-eye"></span>
                                        </button>
                                    </div>
                                </li>
                            </div>
                        @endforeach
                </div>
                <a class="left carousel-control" href="#myCarousel1" data-slide="prev" style='color: black;'>
                    <i class="glyphicon glyphicon-chevron-left"></i>
                </a>
                <a class="right carousel-control" href="#myCarousel1" data-slide="next" style='color: black;'>
                    <i class="glyphicon glyphicon-chevron-right"></i>
                </a>
            </div>
            <script>
                $('#myCarousel1').carousel({
                    interval: 4000
                });

            $('div[name=carousel1] div[name=item1]').each(function(){
                var next = $(this).next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }
                next.children(':first-child').clone().appendTo($(this));

                for (var i=0;i<2;i++) {
                    next=next.next();
                    if (!next.length) {
                        next = $(this).siblings(':first');
                    }
                    next.children(':first-child').clone().appendTo($(this));
                }
            });
            </script>
            @endif
        </div>
        <div class="clearfix"></div>
        <!-- cele mai noi-->
        @if(!empty($newproducts) && count($newproducts)>0)
            <div class="col-md-12 text-center">
                <h3>Cele mai noi produse</h3>
            </div>
            <div class="carousel slide" id="myCarousel" name='carousel'>
                <div class="carousel-inner allproducts" style='float:none;'>
                        <?php $nr=0;?>
                        @foreach($newproducts as $k)
                            <div 
                                <?php 
                                    if($nr==0){
                                        echo "class='item active'";
                                        $nr++;
                                    }else{
                                        echo "class='item'";
                                    }
                                ?>
                                name='item'
                                >
                                <li class="col-lg-2 col-md-4 col-sm-6 col-xs-12"> 
                                    <div class="continut_product">
                                        <div class="continut_image">
                                            <a href="{{URL("/product/".$k->id)}}">
                                                @if(\File::exists($k->address))
                                                    <img  src="{{asset($k->address)}}" class="img-responsive"/>
                                                @else
                                                    <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive"/>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="name">
                                            <a class="NumeProduct" href="{{URL("/product/".$k->id)}}">
                                                <p title="{{$k->originalname}}{{$k->name}}">
                                                    {{$k->originalname}}{{$k->name}}
                                                </p>
                                            </a>
                                        </div>
                                        <p class="price calibri">
                                            {{number_format(floor($k->price), 0, '.', ' ')}}
                                            <sup class="price_dec">
                                                ,{{str_replace("0.","",(string)number_format(round($k->price - (int)$k->price,2),2))}}
                                            </sup>
                                            <span>Lei</span>
                                        </p>
                                        <button class="addcart" name="addcart" prod="{{$k->id}}">
                                            <span class="glyphicon glyphicon-shopping-cart"></span>
                                            Adauga in cos
                                        </button>
                                        <button class="favorite calibri" name="addfavorite" prod="{{$k->id}}">
                                            @if(is_null($k->idfavorite))
                                                <span class="icon-heart-empty"></span>
                                            @else
                                                <span class="icon-heart"></span>
                                            @endif
                                            Adauga la favorite
                                        </button>
                                        <button class="compare calibri" name="addcompare" prod="{{$k->id}}" title="Compara">
                                            <span class="glyphicon glyphicon-sort"></span>
                                        </button>
                                        <button class="compare previewbutton" prod="{{$k->id}}" name="peview" title="Preview">
                                            <span class="fa fa-eye"></span>
                                        </button>
                                    </div>
                                </li>
                            </div>
                        @endforeach
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev" style='color: black;'>
                    <i class="glyphicon glyphicon-chevron-left"></i>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next" style='color: black;'>
                    <i class="glyphicon glyphicon-chevron-right"></i>
                </a>
            </div>
            <script>
                $('#myCarousel').carousel({
                    interval: 4000
                });

            $('div[name=carousel] div[name=item]').each(function(){
                var next = $(this).next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }
                next.children(':first-child').clone().appendTo($(this));

                for (var i=0;i<4;i++) {
                    next=next.next();
                    if (!next.length) {
                        next = $(this).siblings(':first');
                    }
                    next.children(':first-child').clone().appendTo($(this));
                }
            });
            </script>

        @endif
    </div>
</div>
    @include('partials.addcart')
    @include('partials.scriptcart')
@endsection
