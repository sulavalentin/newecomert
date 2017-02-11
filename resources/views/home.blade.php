@extends('base')
@section('content')
<style>
    .homekey{
        text-align: center;
        margin: 10px 0px 0px 0px;
    }
    .subhomekey{
        margin-top: 0px;
    }
    .col-md-12 {
        width: 100%;
        float:left;
        margin-top:10px;
    }
    .homeleft{
        float:left;
    }
    .homelistblock{
        padding-left:15px;
    }
    .homelistblock li{
        color:#333;
    }
    .homelistinline{
        padding-left:0px;
    }
    .homelistinline li{
        color:#333;
        float: left;
        margin-left: 20px;
    }
    .homelistinline li:hover{
        text-decoration: underline;
    }
</style>
@if(!empty($post))
    @foreach($post as $key=>$i)
        <div class="col-md-12" style="border:1px solid #ccc; padding-bottom: 10px;">
            @if(!empty($i) && count($i) >0)
            <h1 class='homekey'>{{$key}}</h1>
            <div class="col-md-12" style="padding: 0px;margin: 0px;">
                @foreach($i as $key1=>$i1)
                    <div class='col-md-12' style="border-top:1px solid #ccc; padding-top: 10px;">
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
                                            <a href="{{URL("sort=priceUp/[".$i2."]-".$key2."/page=1")}}">
                                                <li>{{$key2}}</li>
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
                                        <li class="col-lg-3 col-md-3 col-sm-4 col-xs-6"> 
                                            <div class="continut_product">
                                                <div class="continut_image">
                                                    <a href="{{URL("/product/".$k->id)}}">
                                                        @if(\File::exists($k->address))
                                                            <img  src="{{asset($k->address)}}" class="img-responsive"/>
                                                        @else
                                                            <img src="{{ asset('img/products/default.jpg') }}" class="img-responsive"/>
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a class="NumeProduct" href="{{URL("/product/".$k->id)}}">
                                                        <p>
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
                                                    <span class="icon-heart-empty love"></span>
                                                </p>
                                                <button class="addcart" name="addcart" prod="{{$k->id}}">
                                                    <span class="glyphicon glyphicon-shopping-cart"></span>
                                                    Adauga in cos
                                                </button>
                                            </div>
                                        </li>
                                        <?php $count++ ?>
                                        @if($count % 2==0)
                                            <div class="clearfix visible-xs"></div>
                                        @endif
                                        @if($count % 3==0)
                                            <div class="clearfix visible-sm"></div>
                                        @endif
                                        @if($count % 4==0)
                                            <div class="clearfix visible-md visible-lg"></div>
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
@endif
@endsection
