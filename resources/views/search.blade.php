@extends('base')
@section('content')
<div class='container'>
    <div class="row"> 
    @if(!empty($error))
        <div class="container">
            <h3 class="calibri text-center text-danger">Minim un caractere</h3>
        </div>
    @endif
    @if(!empty($post) && count($post)>0)
        @if(!empty($search))
            <div class="container">
                <h1 class="calibri text-center text-success"> Rezultatele pentru "{{$search}}" </h1>
            </div>
        @endif
        <ul class="allproducts list" id="products">
            @foreach($post as $i)
                <li class="col-lg-2 col-md-3 col-sm-4 col-xs-6"> 
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
        {{$post->links()}}
    @else
        <div class="container" style="border-top:1px solid #ccc;">
            <h1 class="calibri text-center text-danger"> Nu sa gasit asa produse "{{$search}}" </h1>
        </div>
    @endif
    </div>
</div>
    @include('partials.addcart')
    @include('partials.scriptcart')
@endsection
