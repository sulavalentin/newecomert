@extends('base')
@section('content')
<div class='container'>
    <div class="row">
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
                                <li class="col-lg-2 col-md-2 col-sm-4 col-xs-12"> 
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
                    <form method="post" style="margin-top:20px;" id="formcomentarii">
                        <div class="form-group">
                            <label>Numele:</label>
                            @if(!empty(session("nume")))
                                <input type="text" name="nume" value="{{session("nume")}}" class="form-control"/>
                            @else
                                <input type="text" name="nume" class="form-control"/>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Comentariu:</label>
                            <textarea name="comentariu" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control" value="Adauga"/>
                        </div>
                    </form>
                    <div class="content calibri" id="allcoments">
                        @if(!empty($comentarii) && count($comentarii)>0)
                            @foreach($comentarii as $coment)
                                <div class='coments'>
                                    <p class='Nume_coment'>{{$coment->nume}}</p>
                                    <span>{{$coment->comentariu}}</span>
                                    <p class='data_coment'>{{date('d-m-Y', strtotime($coment->created_at))}}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @include('partials.addcart')
            @include('partials.scriptcart')
            <script>
                var id="{{$item[0]->id}}";
            </script>
            @else
                <h1 class="text-center">Nu exista acest produs</h1>
            @endif
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#list_images li img').hover(function () {
            $("#default").attr("src",$(this).attr("src"));
        });
        $("#formcomentarii").on("submit",function(e){
            e.preventDefault();
            $("input[name=nume]").css("border-color","#ccc");
            $("textarea[name=comentariu]").css("border-color","#ccc");
            var trecut=true;
            var nume=$("input[name=nume]").val();
            nume=nume.replace(/  +/g, ' ');
            var comentariu=$("textarea[name=comentariu]").val();
            comentariu=comentariu.replace(/  +/g, ' ');
            if(comentariu.length<3){
                $("textarea[name=comentariu]").css("border-color","red");
                $("textarea[name=comentariu]").focus();
                trecut=false;
            }
            if(nume.length<3){
                $("input[name=nume]").css("border-color","red");
                $("input[name=nume]").focus();
                trecut=false;
            }
            if(trecut===true){
                $.ajax({
                    type:"post",
                    url:"{{URL('addcomentariu')}}",
                    data:{
                        id:id,
                        nume:nume,
                        comentariu:comentariu
                    },
                    success:function(data){
                        $("#allcoments").prepend("<div class='coments'>\n\
                                                    <p class='Nume_coment'>"+data.nume+"</p>\n\
                                                    <span>"+data.comentariu+"</span>\n\
                                                    <p class='data_coment'>"+data.created_at+"</p>\n\
                                                </div>");
                        $("textarea[name=comentariu]").val("");
                    }
                });
            }
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