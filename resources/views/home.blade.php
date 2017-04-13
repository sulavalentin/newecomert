@extends('base')
@section('content')

@include('partials.carosel')

@if(!empty($post))
    @foreach($post as $key=>$i)
        <div class="col-md-12" style="padding-bottom: 10px; margin: 10px 0px 0px 0px;box-shadow: 1px 1px 5px grey;">
            @if(!empty($i) && count($i) >0)
            <h1 class='homekey calibri'>{{$key}}</h1>
            <div class="col-md-12" style="padding: 0px;margin:0px;">
                @foreach($i as $key1=>$i1)
                    <div class='col-md-12' style="border-top: 3px solid #808080; padding-top: 10px;margin-top:10px;">
                        @if(!empty($i1[0]))
                            <div class="col-md-3 homeleft">
                        @else
                            <div class="col-md-12 homeleft" style='margin-top:0px;'>
                        @endif
                            <h3 class='subhomekey'>{{$key1}}</h3>
                            @if(!empty($i1) && count($i1) >0)
                                <ul <?php 
                                        if(!empty($i1[0]))
                                        {
                                            echo"class='homelistblock'";
                                        }else{
                                            echo"class='homelistinline'";
                                        }
                                    ?>
                                >
                                    @foreach($i1 as $key2=>$i2)
                                        @if($key2!==0)
                                            <a href="{{URL("sort=priceUp/[".$i2["id"]."]-".$key2."/page=1")}}">
                                                <li>{{$key2}} ({{$i2["count"]}})</li>
                                            </a>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @if(!empty($i1[0]))
                            <div class='col-md-9'>
                                <ul class="allproducts list" id="products">
                                    <?php $count=0 ?>
                                    @foreach($i1[0] as $k)
                                        <li class="col-lg-3 col-md-3 col-sm-4 col-xs-12"> 
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
                                        <?php $count++ ?>
                                        @if($count % 2==0)
                                            <div class="clearfix visible-xs "></div>
                                        @endif
                                        @if($count % 4==0)
                                            <div class="clearfix visible-sm visible-md visible-lg"></div>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    @endforeach
    
    @include('partials.addcart')
    @include('partials.scriptcart')
@endif

@endsection
