@extends('base')
@section('content')
    @if(!empty($succes) && $succes==true)
        <h1 class="text-center">Emailul a fost confirmat cu succes <br><br> Va multumim!</h1>
    @else
        <h1 class="text-center">Cererea eronata</h1>
    @endif
@endsection