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
                            <img src="{{ asset('img/products/default.jpg') }}" class="img-responsive" id="default"/>
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
                    <button class="favorite calibri">
                        <span class="icon-heart-empty"></span>
                        Adauga la favorite
                    </button>
                    <br>
                    <label for="compara" style="cursor: pointer;" class="noselect">
                        <input type="checkbox" id="compara" class="compara"/>
                        <span>Compara</span>
                    </label>
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
        @if(!empty($asemanatoare) && count($asemanatoare)>0)
            <div class="col-md-12 produse_asemanatoare">
                <p><b>Produse asemanatoare</b></p>
                <ul class="allproducts list">
                    <?php $count=0 ?>
                    @foreach($asemanatoare as $i)
                        <li class="col-lg-2 col-md-2 col-sm-4 col-xs-6"> 
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
                        @if($count % 6==0)
                            <div class="clearfix visible-md visible-lg"></div>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-xs-12 info">
            <h1>Descriere</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lorem fermentum, consequat massa commodo, rutrum augue. Pellentesque et fermentum nisi, ac rutrum arcu. Phasellus vestibulum volutpat massa ut aliquet. Cras ullamcorper eros leo, id semper ipsum ornare a. Nullam pharetra posuere nulla, at maximus diam maximus sit amet. Praesent at rutrum lorem, in euismod nisl. Donec ut laoreet felis. Nunc scelerisque condimentum posuere. Nulla vel justo volutpat, laoreet orci vel, tincidunt mi. Donec eu felis nec elit ullamcorper ornare eget at nisl. Aenean pharetra dui mi, quis facilisis lorem aliquam id. Integer magna ipsum, laoreet a ultrices sed, tempus a elit. Duis volutpat metus dui, sed euismod mauris accumsan sed. Aenean id mauris vitae purus porttitor maximus. Vestibulum quis lorem nulla. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                Vestibulum scelerisque, dui in lobortis malesuada, diam mi faucibus augue, id porttitor ante ante a magna. Nullam mattis quam non arcu tincidunt tincidunt in vitae ante. In hac habitasse platea dictumst. Donec augue velit, egestas in leo nec, elementum viverra lectus. Sed viverra sed metus et ultrices. Quisque sed interdum risus, at ultrices ex. Pellentesque nec est ac ex sodales condimentum. Sed fringilla a ante ultrices suscipit. Nunc rutrum congue eleifend. Suspendisse viverra consectetur mauris a dignissim.
                Pellentesque porttitor quam sed vulputate porta. Donec lacinia nibh urna, a facilisis est placerat in. Curabitur mattis, dui vel laoreet eleifend, eros diam auctor metus, et posuere ligula ante at ante. Pellentesque vel massa pharetra, suscipit dolor ac, laoreet nisi. Aenean ac consectetur ante, in consectetur ante. Maecenas gravida neque sit amet erat semper placerat. Nullam blandit pharetra tortor, sit amet volutpat ipsum auctor sed. Morbi pretium maximus neque, et imperdiet tellus placerat nec. In turpis turpis, consectetur at lacinia sagittis, dapibus eget massa. Maecenas quis turpis et metus feugiat semper. Pellentesque tincidunt ante ipsum, non ullamcorper nisl mattis non. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce eget leo eu felis cursus porttitor ac a mauris. Nulla finibus, nibh eu facilisis tempor, ex ipsum interdum risus, nec fringilla ante metus nec sapien. Quisque eu varius lectus. Nunc id volutpat elit.
                Nulla facilisi. Nam tristique lorem quis sapien volutpat, at tristique sapien congue. Suspendisse id nisl non turpis varius elementum. Integer luctus eros at odio ornare, at vehicula est semper. Aenean vehicula turpis sed euismod lacinia. Proin sed diam finibus, convallis enim ut, vestibulum lacus. Nunc dapibus tortor vitae feugiat posuere. Maecenas commodo orci et nulla egestas, at vehicula est mollis.
                Fusce sit amet metus pulvinar, mollis ligula non, condimentum turpis. Mauris at nulla molestie, consectetur odio id, luctus nisl. Ut dui tellus, ultrices sed dui eu, gravida viverra nunc. Praesent sagittis tempor elit at blandit. Curabitur viverra diam eget mi semper, tempor luctus ipsum feugiat. Nunc a congue erat, non venenatis turpis. Proin pretium vestibulum elit in dictum. Cras suscipit, neque sit amet dictum iaculis, est lacus consectetur diam, et molestie purus magna id nunc.</p>
        </div>
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
    @else
        <h1 class="text-center">Nu exista acest produs</h1>
    @endif
    <script>
        $(document).ready(function(){
            $('#list_images li img').click(function () {
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
        $("button[name=addcart]").on("click",function(){
                var idprod=$(this).attr("prod");
                $("button[name=addcart]").prop('disabled', true);
                $("#fullpageload").show();
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
    </script>
@endsection