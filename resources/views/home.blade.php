@extends('base')
@section('content')

@include('partials.carosel')
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
                            <button class="compare calibri" name="addcompare" prod="{{$k->id}}">
                                <span class="glyphicon glyphicon-sort"></span>
                                Compara
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
                            <button class="compare calibri" name="addcompare" prod="{{$k->id}}">
                                <span class="glyphicon glyphicon-sort"></span>
                                Compara
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
    @include('partials.addcart')
    @include('partials.scriptcart')
@endsection
