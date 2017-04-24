@extends('base')
@section('content')
<div class='container'>
    <div class="row"> 
    @if(!empty($favorite) && count($favorite)>0)
        @foreach($favorite as $i)
            <div class="col-md-6">
                <div class="favoriteclass">
                    <div class="col-xs-5 imagefavorite">
                        <a href="{{URL("product/".$i->id)}}">
                            @if(\File::exists($i->address))
                                <img src="{{ asset($i->address) }}" class="img-responsive"/>
                            @else
                                <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive"/>
                            @endif
                        </a>
                    </div>
                    <div class="col-xs-7 contentfavorite">
                        <a href="{{URL("product/".$i->id)}}">
                            <p class="favoritename">{{$i->originalname}}{{$i->name}}</p>
                        </a>
                        <p class="favoriteadaugat">
                            Adaugat:
                            {{date('d/m/Y', strtotime($i->created_at))}}
                        </p>
                        <p class="pretfavorite calibri">
                            <span>
                                {{number_format(floor($i->price), 0, '.', ' ')}}
                                <sup class="price_dec">
                                    ,{{str_replace("0.","",(string)number_format(round($i->price - (int)$i->price,2),2))}}
                                </sup>
                                Lei
                            </span>
                        </p>
                        <p class="text-right" style="margin-bottom: 0px;">
                            <button class="btn btn-xs addcart" name="addcart" prod="{{$i->id}}">
                                <span class="glyphicon glyphicon-shopping-cart"></span>
                                Adauga in cos
                            </button>
                            <a class="btn btn-default btn-sm" style="margin-top:5px;" name="deletefavorite" favorite="{{$i->favorite_id}}">
                                <span class="glyphicon glyphicon-remove text-danger"></span>
                                Sterge
                            </a>
                        </p>
                        
                    </div>
                </div>
            </div>
        @endforeach
        @include('partials.addcart')
        @include('partials.scriptcart')
        <script>
            $("a[name=deletefavorite]").on("click",function(){
                var id=$(this).attr("favorite");
                $.ajax({
                    type:"post",
                    url:"{{URL('deletefavorite')}}",
                    data:{
                        id:id
                    },
                    success:function(){
                        location.reload();
                    }
                });
            });
        </script>
    @else
        <h1 class='text-center'>Nu aveti produse favorite</h1>
    @endif
    </div>
</div>
@endsection