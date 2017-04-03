@extends('base')
@section('content')
    @if(!empty($post) && count($post)>0)
        {{dd($post)}}
    @else
        <h1 class="text-center calibri">Nu s-a gasit acest produs</h1>
    @endif
@endsection
