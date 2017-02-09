@extends('base')
@section('content')
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
        <div class="sortare col-lg-3 col-md-3 col-sm-12 col-xs-12">
            @if(!empty($link))
                <form id="sortare" action="{{URL("sort=".$link["sort"]."/[".$link["2"]["address"]."]-".$link["2"]["name"]."/page=1")}}">
                    @if(!empty($sortare["selected"]) && !empty($link))
                        <p><b>Filtre alese:</b></p>
                        @foreach($sortare["selected"] as $key => $sort)
                                <p style="color:gray;margin-top: 10px;"><b>{{$key}}</b></p>
                                @foreach($sort as $i)
                                    <label for="sort{{$i->value}}" class="noselect sortlabel">
                                        <input type="checkbox" id="sort{{$i->value}}" 
                                               class="compara" 
                                               value="{{$i->idspec}}" 
                                               name="{{$i->id}}"
                                               checked/>
                                        <span>{{$i->value}}</span>
                                    </label>
                                    <br>
                                @endforeach
                        @endforeach
                        <hr style="margin: 10px 0px;">
                    @endif
                    @if(!empty($sortare["noselected"]))
                        @foreach($sortare["noselected"] as $key => $sort)
                            <div class="sort_group">
                               <p><b>{{$key}}</b></p>
                               @foreach($sort as $i)
                                   <label for="sort{{$i->value}}" class="noselect sortlabel">
                                        <input type="checkbox" id="sort{{$i->value}}" 
                                               class="compara" 
                                               value="{{$i->idspec}}" 
                                               name="{{$i->id}}"/>
                                        <span>{{$i->value}}</span>
                                    </label>
                                   <br>
                               @endforeach
                            </div>
                        @endforeach
                    @endif
                </form>
            @endif
        </div>
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
                <?php $count=0 ?>
                @foreach($produse as $i)
                    <li class="col-lg-3 col-md-3 col-sm-4 col-xs-6"> 
                        <div class="continut_product">
                            <div class="continut_image">
                                <a href="{{URL("/product/".$i->id)}}">
                                    @if(\File::exists($i->address))
                                        <img  src="{{asset($i->address)}}" class="img-responsive"/>
                                    @else
                                        <img src="{{ asset('img/products/default.jpg') }}" class="img-responsive"/>
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
                                <span class="icon-heart-empty love"></span>
                            </p>
                            <button class="addcart" name="addcart" prod="{{$i->id}}">
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
        @include('partials.paginare')
    </div>
    @include('partials.addcart')
    @else
        <h1>Nu sunt produse</h1>
    @endif
    <script>
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
                    default:key=false;
                }
                $("#sortall")[0].selectedIndex=key;
                break;
            }
        }
        $(window).on("load", function() {
            $("#products").height($("#products").height());
        });
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
            $("button[name=addcart]").on("click",function(){
                $("#fullpageload").show();
                var idprod=$(this).attr("prod");
                $("button[name=addcart]").prop('disabled', true);
                $.ajax({  
                    type: 'POST',  
                    url: "{{URL('/addcart')}}", 
                    data: 
                        { 
                          id:idprod
                        },
                    success: function(data) {
                        $("button[name=addcart]").removeAttr('disabled');
                        $("#carcount").html(data[0]);
                        $("#nameCart").html(data[1].originalname+data[1].name);
                        $("#imgcart").attr("src","{{asset('/')}}"+data[1].address);
                        $("#fullpageload").hide();
                        $("#cosAdded").modal();
                        
                    }
                });
            });
        });
    </script>
@endsection
