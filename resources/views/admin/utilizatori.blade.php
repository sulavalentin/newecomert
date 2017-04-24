@extends("admin.base")
@section("content")
    @if(!empty($post) && count($post)>0)
    <table class="table table-bordered">
        <tr>
            <th>Nume</th>
            <th>Email</th>
            <th>Inregistrat</th>
            <th>Activ</th>
        </tr>
        @foreach($post as $i)
        <tr>
            <td>{{$i->name}}</td>
            <td>{{$i->email}}</td>
            <td>{{$i->created_at}}</td>
            <td>
                @if($i->confirmed==1)
                    Activ
                @else
                    Neactiv
                @endif
            </td>
        </tr>
        @endforeach
    </table>
    {{$post->links()}}
    @else
        <h1 class="text-center calibri">Nu sunt utilizatori</h1>
    @endif
@endsection