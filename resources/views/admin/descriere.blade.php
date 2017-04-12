@extends("admin.base")
@section("content")
@if(!empty($article["product"]) && count($article["product"])>0)
<style>
    #raspuns button{
        margin-bottom:10px;
        float:right;
    }
    #raspuns div{
        border-bottom: 1px solid gray;
        margin-bottom: 10px;
        padding-bottom: 10px;
    }
    #upload{
        margin-top:15px;
    }
</style>
    <h1 class="calibri text-center">
        Adauga descriere produsului 
        <a href="{{URL('product/'.$article["product"]->id)}}" target="_blank" style="text-decoration: none;color:#f44336;">
            "{{$article["product"]->originalname}}{{$article["product"]->name}}"
        </a>.
    </h1>
    <div id="raspuns" class="content">
        @if(!empty($article["description"]) && count($article["description"])>0)
            @foreach($article["description"] as $i)
                <div  id='description{{$i->id}}'>
                    <button class='btn btn-danger' name='sterge' id='{{$i->id}}'>
                        <span class='glyphicon glyphicon-arrow-down'></span>
                        Sterge
                    </button>
                    <img src='{{asset($i->image)}}' class='img-responsive'/>
                </div>
            @endforeach
        @endif
    </div>
    <form id="upload" enctype="multipart/form-data" name="{{$article['id']}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label class="file">
            <a class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Se incarca" id="butonincarca">
                <span class='glyphicon glyphicon-upload'></span>
                Incarca imagini
            </a>
            <input type="file" name="file[]" multiple style="display:none;"><br>
        </label>
    </form>
    <p class="text-danger" id="error"></p>
    <div class="modal fade" id="comfirm_delete" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title text-center">Sterge imagine</h4>
            </div>
            <div class="modal-body text-center">
                <h3 class="calibri text-danger" style="margin: 0px 0px 15px 0px;">
                    Sigur doresti sa stergi aceasta imagine?
                </h3>
                <button class="btn btn-default" id="yesdelete">Da</button>
                <button class="btn btn-primary" data-dismiss="modal">Nu</button>
            </div>
          </div>
        </div>
    </div>
    <script>
    $(document).ready(function (e) {
        $("#yesdelete").on("click",function(){
            var id=$(this).attr("iddel");
            $.ajax({
                type:'post',
                url:"{{URL('/admin/deldescriere')}}",
                data:{
                    id:id
                },
                success:function(data){
                    $("#description"+data).remove();
                    $("#comfirm_delete").modal("hide");
                }
            });
        });
        $("body").on("click","button[name=sterge]",function(){
            var id=$(this).attr("id");
            $("#yesdelete").attr("iddel",id);
            $("#comfirm_delete").modal();
        });
        $('#upload').on('submit',(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("id",$("#upload").attr("name"));
            $("#error").text("");
            $(".loadimage").css("opacity","1");
            $("#butonincarca").button("loading");
            $.ajax({
                type:'POST',
                url: "{{URL('/admin/uploaddescriere')}}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    var eror=0;
                    $.each(data, function( index, value ) {
                        if(value.succes===true){
                            $("#raspuns").append("<div id='description"+value.id+"'>\n\
                                                    <button class='btn btn-danger' name='sterge' id='"+value.id+"'>\n\
                                                        <span class='glyphicon glyphicon-arrow-down'></span>\n\
                                                        Sterge\n\
                                                    </button>\n\
                                                    <img src='"+value.image+"' class='img-responsive'/>\n\
                                                </div>");
                        }else{
                            eror++;
                        }
                    });
                    $('#upload')[0].reset();
                    $("#butonincarca").button("reset");
                },
                error:function(){
                    $("#error").text("A aparut o eroare");
                    $("#butonincarca").button("reset");
                    $('#upload')[0].reset();
                }
            });
        }));
        $("#upload").on("change", function() {
            $("#upload").submit();
            $("input[name=file]").val("");
        });
    });
    </script>
@else
    <h1 class='calibri text-center'>Nu exista acest produs</h1>
@endif
@endsection