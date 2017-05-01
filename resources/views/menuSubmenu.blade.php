@extends('base')
@section('content')
<div class='container'>
    <div class="row"> 
    @if(!empty($name))
        <h1 class="text-center">{{$name}}</h1>
    @endif
    @if(!empty($response))
        @foreach($response as $i)
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <a href="{{URL("submenu/".$i->id)}}" class="name_submenu">
                    @if(\File::exists($i->submenu_image))
                        <img src="{{ asset('img/system/spin.gif') }}" originalsrc="{{asset($i->submenu_image)}}" class="img-responsive"/>
                    @else
                        <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive"/>
                    @endif
                    <h3 class="text-center">{{$i->submenu_name}}</h3>
                </a>
            </div>
        @endforeach
    @endif
    </div>
</div>
@endsection