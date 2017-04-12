@extends('base')
@section('content')
    @if(!empty($item[0]))
    <style>
        #addinname{
            margin: 10px; 
            font-size: 15px;
        }
        #addinname p{
            margin:0px;
        }
    </style>
    <script>
        function addinname(a,b){
            $("#addinname").append("<p>"+a+": "+b+"</p>");
        }
    </script>
    <div class="urllink">
        <ul class="breadcrumb">
            <li><a href="{{URL("/")}}">Pagina principala</a></li>
                <li><a href="{{URL("/menu/".$link["0"]["address"])}}">{{$link["0"]["name"]}}</a></li>
                <li><a href="{{URL("/submenu/".$link["1"]["address"])}}">{{$link["1"]["name"]}}</a></li>
                <li><a href="{{URL("sort=priceUp/[".$link[2]["address"]."]-".$link[2]["name"]."/page=1")}}">{{$link[2]["name"]}}</a></li>
        </ul>
    </div>
    <div class="content ProducteImagine">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 itemborder">
            <!-- Imagini slide-->
            <div class="item_imagine">
                @if(!empty($images))
                    <div class="image-preview">
                        @if(\File::exists($item[0]->address))
                            <img src="{{ asset($item[0]->address) }}" class="img-responsive" id="default"/>
                        @else
                            <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive" id="default"/>
                        @endif
                    </div>
                    @if(count($images)>1)
                        <div class="content_images">
                            <ul class="list_images" id="list_images">
                                @foreach($images as $i)
                                    @if(\File::exists($i->address))
                                    <li>
                                        <img src="{{ asset($i->address) }}" class="img-responsive"/>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 continut">
            <h4 class="itemName calibri">
                {{$item[0]->originalname}}{{$item[0]->name}}
            </h4>
            <div class="pretEtc">
                <div class="pret_Produs calibri"> 
                    <span>
                        {{number_format(floor($item[0]->price), 0, '.', ' ')}}
                        <sup class="price_dec">
                            ,{{str_replace("0.","",(string)number_format(round($item[0]->price - (int)$item[0]->price,2),2))}}
                        </sup>
                        Lei
                    </span>
                </div>  
                <div class="item_margin">
                    <button class="btn_add calibri" name="addcart" prod="{{$item[0]->id}}">
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                        Adauga in cos
                    </button>
                    <br>
                    <button class="favorite calibri" name="addfavorite" prod="{{$item[0]->id}}">
                        @if(is_null($item[0]->idfavorite))
                            <span class="icon-heart-empty"></span>
                        @else
                            <span class="icon-heart"></span>
                        @endif
                        Adauga la favorite
                    </button>
                    <br>
                    <button class="compare calibri" name="addcompare" prod="{{$item[0]->id}}">
                        <span class="glyphicon glyphicon-sort"></span>
                        Compara
                    </button>
                </div>
           </div>
            <div id="addinname" class="calibri">
                
            </div>
        </div>
        @if(!empty($item[1]))
            <div class="col-lg-12 detalii" id="detalii">
                <h1 class="text-center calibri" style="margin: 0px 0px 15px 0px;">Caracteristici</h1>
                    @foreach($item[1] as $key => $spec)
                        <div class="desSearch" name="desSearch">
                            <div class="specification">
                                <p class="denumire">{{$key}}</p>
                                <div class="spec_value">
                                   @foreach($spec as $i)
                                        <div style="width:100%; float:left">
                                            <p class="value_spec">{{$i->specification_name}}:</p>
                                            <p class="value_spec">{{$i->value}}</p> 
                                        </div>
                                        @if($i->addsearch==1 || $i->addname==1)
                                            <script>
                                                addinname("{{$i->specification_name}}","{{$i->value}}");
                                            </script>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div> 
                    @endforeach        

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="left" style="float:left">

                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="right" style="float:right">

                </div>
            </div>
        @endif
        <div class="col-xs-12 info">
            @if(!empty($descriere) && count($descriere)>0)
                @foreach($descriere as $img)
                    <img class="img-responsive" src="{{asset($img->image)}}"/>
                @endforeach
            @endif
        </div>
        @if(!empty($asemanatoare) && count($asemanatoare)>0)
            <div class="col-md-12 produse_asemanatoare">
                <p><b>Produse asemanatoare</b></p>
                <ul class="allproducts list">
                    @foreach($asemanatoare as $i)
                        <li class="col-lg-2 col-md-2 col-sm-4 col-xs-6"> 
                            <div class="continut_product">
                                <div class="continut_image">
                                    <a href="{{URL("/product/".$i->id)}}">
                                        @if(\File::exists($i->address))
                                            <img  src="{{asset($i->address)}}" class="img-responsive"/>
                                        @else
                                            <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive"/>
                                        @endif
                                    </a>
                                </div>
                                <div class="name">
                                    <a class="NumeProduct" href="{{URL("/product/".$i->id)}}">
                                        <p>
                                            {{$i->originalname}}{{$i->name}}
                                        </p>
                                    </a>
                                </div>
                                <p class="price calibri">
                                    {{number_format(floor($i->price), 0, '.', ' ')}}
                                    <sup class="price_dec">
                                        ,{{str_replace("0.","",(string)number_format(round($i->price - (int)$i->price,2),2))}}
                                    </sup>
                                    <span>Lei</span>
                                </p>
                                <button class="addcart" name="addcart" prod="{{$i->id}}">
                                    <span class="glyphicon glyphicon-shopping-cart"></span>
                                    Adauga in cos
                                </button>
                                <button class="favorite calibri" name="addfavorite" prod="{{$i->id}}">
                                    @if(is_null($i->idfavorite))
                                        <span class="icon-heart-empty"></span>
                                    @else
                                        <span class="icon-heart"></span>
                                    @endif
                                    Adauga la favorite
                                </button>
                                <button class="compare calibri" name="addcompare" prod="{{$i->id}}">
                                    <span class="glyphicon glyphicon-sort"></span>
                                    Compara
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!--Comentarii -->
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 des_coments">
            <form method="post" style="margin-top:20px;">
                <textarea name="comentariu"></textarea>
                <input type="submit" >
            </form>
            <div class="coments"  >
                <p class="Nume_coment">Nume</p>
                <span>Pe măsură ce trece timpul, rețelele sunt  cele ce ne conectează. Oamenii comunică online  s-ar  ce  conectează. Oamenii comunică online oriunde s-ar afla. Conversațiile din sala de clasă se răspândesc prin mesaje instant din sesiuni de chat, iar dezbaterile online continuă la școală. Noi servicii sunt dezvoltate în fiecare zi pentru a profita de rețele.</span>
                <p class="data_coment">03.10.2016</p>
            </div>
             <div class="coments"  >
                <p class="Nume_coment">Nume</p>
                <span>Pe măsură ce trece timpul, rețelele sunt  cele ce ne conectează. Oamenii comunică online  s-ar  ce  conectează. Oamenii comunică online oriunde s-ar afla. Conversațiile din sala de clasă se răspândesc prin mesaje instant din sesiuni de chat, iar dezbaterile online continuă la școală. Noi servicii sunt dezvoltate în fiecare zi pentru a profita de rețele.</span>
                <p class="data_coment">03.10.2016</p>
            </div>
        </div>
    </div>
    @include('partials.addcart')
    @include('partials.scriptcart')
    @else
        <h1 class="text-center">Nu exista acest produs</h1>
    @endif
    <script>
        $(document).ready(function(){
            $('#list_images li img').hover(function () {
                $("#default").attr("src",$(this).attr("src"));
            });
        });
        $('div [name=desSearch]').each(function(i,e) {
            if($("#left").height()<=$("#right").height()){
                $("#left").append($(this));
            }else{
                $("#right").append($(this));
                height=0;
            }
        });
    </script>
@endsection