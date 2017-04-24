@extends('base')
@section('content')
<div class='container'>
    <div class="row">
        @if(!empty($succes) && $succes==true)
            <h1 class="text-center">Emailul a fost confirmat cu succes <br><br> Va multumim!</h1>
        @else
            <h1 class="text-center">Cererea eronata</h1>
        @endif
    </div>
</div>
@endsection