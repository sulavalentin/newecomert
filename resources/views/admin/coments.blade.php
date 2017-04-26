@extends("admin.base")
@section("content")
    @if(!empty($post) && count($post)>0)
        <table class="table table-bordered">
            <tr>
                <th>Nume</th>
                <th>Produs</th>
                <th>Comentariu</th>
                <th>Setari</th>
            </tr>
            @foreach($post as $i)
            <tr idcom="{{$i->id}}">
                <td>
                    @if($i->new==1)
                    <button class="btn btn-xs btn-danger">Nou</button>
                    @endif
                    {{$i->nume}}
                </td>
                <td>
                    <a href="{{URL('product/'.$i->product_id)}}" target="_blank">
                        @if(\File::exists($i->address))
                            <img src="{{ asset($i->address) }}" class="img-responsive comentimage"/>
                        @else
                            <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive comentimage"/>
                        @endif
                        {{$i->originalname}}{{$i->name}}
                    </a>
                </td>
                <td>
                    {{$i->comentariu}}
                </td>
                <td>
                    <button class="btn btn-danger btn-xs" iddel="{{$i->id}}" name="sterge">
                        Sterge
                    </button>
                </td>
            </tr>
            @endforeach
        </table>
        {{$post->links()}}
        <div class="modal fade" id="comfirm_delete" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center">Sterge comentariu</h4>
                    </div>
                    <div class="modal-body text-center">
                        <h2 class="calibri" style="margin: 0px 0px 15px 0px;">Sigur doriti sa stergeti acest comentariu?</h2>
                        <button class="btn btn-default" id="yesdelete">Da</button>
                        <button class="btn btn-primary" data-dismiss="modal">Nu</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $('button[name=sterge]').on("click",function () {
                    var id=$(this).attr("iddel");
                    $("#yesdelete").attr("iddelete",id);
                    $("#comfirm_delete").modal();
                });
                $("#yesdelete").on("click",function(){
                    $.ajax({  
                        type: 'POST',  
                        url: "{{URL('/admin/deletecoment')}}", 
                        data: 
                            { 
                                id:$(this).attr("iddelete")
                            },
                        success: function() {
                            location.reload();
                        }
                    });
                });
            });
        </script>
    @else
        <h1 class="calibri text-center">Nu sunt comentarii</h1>
    @endif
@endsection