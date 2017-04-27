@extends('base')
@section('content')
<div class='container'>
    <div class="row"> 
        <div class="urllink">
            <ul class="breadcrumb">
                <li><a href="{{URL("/")}}">Pagina principala</a></li>
                @if(!empty($link))
                    <li><a href="{{URL("/menu/".$link["0"]["address"])}}">{{$link["0"]["name"]}}</a></li>
                    <li><a href="{{URL("/submenu/".$link["1"]["address"])}}">{{$link["1"]["name"]}}</a></li>
                    <li class="active">{{$link["2"]["name"]}}</li>
                @endif
            </ul>
        </div>
        @if(!empty($produse) && count($produse)>0)
        <div class="content">
            <!--Sortarea include -->
            @include('partials.sortare')

            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="allproducts">
                <div class="content sortare_name">
                    @if(!empty($link))
                        <h1 class="calibri">{{$link["2"]["name"]}}</h1>
                    @endif
                    <div class="sortare_parametri">
                        @if(!empty($link))
                            <form id="sortare_parametri" class="form-inline">
                                <div class="form-group">
                                    <label for="price">Ordoneaza:</label>
                                    <select class="form-control" id="sortall">
                                        <option value="{{URL("sort=priceUp/[".$link[2]["address"]."]-".$link[2]["name"]."/page=1"."?".$url)}}">
                                            Pret crescator
                                        </option>
                                        <option value="{{URL("sort=priceDown/[".$link[2]["address"]."]-".$link[2]["name"]."/page=1"."?".$url)}}">
                                            Pret descrescator
                                        </option>
                                        <option value="{{URL("sort=nameUp/[".$link[2]["address"]."]-".$link[2]["name"]."/page=1"."?".$url)}}">
                                            Nume crescator
                                        </option>
                                        <option value="{{URL("sort=nameDown/[".$link[2]["address"]."]-".$link[2]["name"]."/page=1"."?".$url)}}">
                                            Nume descrescator
                                        </option>
                                        <option value="{{URL("sort=created/[".$link[2]["address"]."]-".$link[2]["name"]."/page=1"."?".$url)}}">
                                            Cele mai noi
                                        </option>
                                        <option value="{{URL("sort=popular/[".$link[2]["address"]."]-".$link[2]["name"]."/page=1"."?".$url)}}">
                                            Cele mai intrebate
                                        </option>
                                    </select>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
                <ul class="allproducts list" id="products">
                    @foreach($produse as $i)
                        <li class="col-lg-3 col-md-3 col-sm-4 col-xs-12"> 
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
                                        <p title="{{$i->originalname}}{{$i->name}}">
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
                                <button class="compare calibri" name="addcompare" prod="{{$i->id}}" title="Compara">
                                    <span class="glyphicon glyphicon-sort"></span>
                                </button>
                                <button class="compare previewbutton" prod="{{$i->id}}" name="peview" title="Preview">
                                    <span class="fa fa-eye"></span>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            @include('partials.paginare')
        </div>
        @include('partials.addcart')
        @include('partials.scriptcart')
        @else
            <h1>Nu sunt produse</h1>
        @endif
    </div>
</div>
    <script>
        $(document).ready(function() {
            $("#sortare").on("change", function() {
                $("#sortare").submit();
            });
            $("#sortall").on("change", function() {
                var url = $("#sortall").val();
                if (url) { 
                    window.location = url;
                }
                return false;
            });
        });
        /*Sortarea*/
        var link=window.location.pathname;
        link=link.split("/");
        for(var i=0;i<link.length;i++){
            var pozitia=link[i].indexOf("=");
            if(link[i].substring(0,pozitia)==="sort"){
                var select=link[i].substring(pozitia+1);
                var key="";
                switch(select){
                    case "priceUp":{key=0;  break;}
                    case "priceDown":{key=1;  break;}
                    case "nameUp":{key=2;  break;}
                    case "nameDown":{key=3; break;}
                    case "created":{key=4; break;}
                    case "popular":{key=5; break;}
                    default:key=false;
                }
                $("#sortall")[0].selectedIndex=key;
                break;
            }
        }
    </script>
@endsection
