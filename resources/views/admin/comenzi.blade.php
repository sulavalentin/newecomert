@extends("admin.base")
@section("content")
<div class="content">
    @if(!empty($comenzi) && count($comenzi)>0)
        @foreach($comenzi as $i)
            
        @endforeach
    @else
    <h1 class="text-center calibri">Nu sunt comenzi pe aceasta pagina</h1>
    @endif
</div>
@endsection