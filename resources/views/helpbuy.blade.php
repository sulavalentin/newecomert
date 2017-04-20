@extends('base')
@section('content')
<style>
    .border{
        border-top:1px solid black;
    }
</style>
    <div class="content calibri">
        <h2 style="font-weight: bold;">Cum cumpar?</h2>
        <p>Pentru a cumpara un produs nu e nevoie sa aveti un cont tot ce trebuie sa faceti este:</p>
        <h2>Primul pas</h2>
        <p>V-a cautati si adaugati produsul dorit in cos apasand pe butonul <b>Adauga in cos</b></p>
        <img src="{{asset('img/helpbuy/buy1(1).jpg')}}" class="img-responsive border" />
        <h2>Pasul doi</h2>
        <p>Apasati pe butonul <b>Cos</b> pentru a vedea produsele adaugate</p>
        <img src="{{asset('img/helpbuy/buy1(2).jpg')}}" class="img-responsive border" />
        <h2>Pasul trei</h2>
        <p>Alegeti cantitatea si apasati pe butonul <b>Cumara</b></p>
        <img src="{{asset('img/helpbuy/bandicam2017-04-2016-58-07-983.jpg')}}" class="img-responsive border" />
        <h2>Pasul patru</h2>
        <p>Introduceti datele dumneavostra si apasati pe butonul <b>Finalizeaza comanda</b></p>
        <img src="{{asset('img/helpbuy/bandicam2017-04-2016-59-29-204.jpg')}}" class="img-responsive border" />
        <h2>Urmatorul pas</h2>
        <p>Peste ceva timp operatorul va va contacta</p>
        <img src="{{asset('img/helpbuy/buy1(4).jpg')}}" class="img-responsive border" />
    </div>
@endsection