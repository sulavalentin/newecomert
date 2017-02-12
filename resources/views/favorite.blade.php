@extends('base')
@section('content')
    @if(!empty($favorite) && count($favorite)>0)
        
    @else
        <h1 class='text-center'>Nu aveti produse favorite</h1>
    @endif
@endsection