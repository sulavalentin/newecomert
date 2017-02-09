@extends('base')
@section('content')
<style>
    .ops{
        font-size:600%;
    }
    .eror-image{
        width: 300px;
        margin:0 auto;
    }
    .eror-image img{
        width: 100%;
    }
</style>
    <h1 class="ops text-center">Error 404</h1>
    <hr style="border-bottom:1px solid black;">
    <h1 class="text-center">Woops. Aceasta pagina nu exista</h1>
    <div class="eror-image">
        <img src="{{asset("img/system/Eror.png")}}"/>
    </div>
@endsection
