@extends("admin.base")
@section("content")
    <div class="col-md-6">
        <label class="text-info">Adresa pe care doriti sa duca imaginea: (1200x400px 3x1)</label> 
        <input type="text" name="link" class="form-control" placeholder="Link" style="margin-bottom: 10px;"/>
        <label class="text-info">Imaginea</label>
        <form id="upload" enctype="multipart/form-data" style="width: 100%;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <label class="file" style="margin-bottom: 0px;">
                <input type="file" name="file">
            </label>
            <p id="error" class="text-danger"></p>
            <button class="btn btn-primary" id="saveslideshow" name="save" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Se adauga">
                Adauga
            </button>
        </form>
    </div>
        <div class="col-md-12">
            <div class="row" id="sliders">
                @if(!empty($slideshow) && count($slideshow)>0)
                    @foreach($slideshow as $i)
                        <div class="col-md-12 imageslideshow" id="slide{{$i->id}}">
                            <p>
                                <a href="{{$i->link}}" target="_blank">
                                    {{$i->link}}
                                </a>
                                <button class="btn btn-danger btn-sm" id="{{$i->id}}" name="delslideshow" style="float:right; margin-bottom:10px;">
                                    <span class="glyphicon glyphicon-arrow-down"></span>
                                    Sterge
                                </button>
                            </p>
                            <img class="img-responsive" src="{{asset($i->image)}}" />
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="modal fade" id="comfirm_delete_slideshow" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title text-center">Sterge slideshow</h4>
                </div>
                <div class="modal-body text-center">
                    <h2 class="calibri" style="margin: 0px 0px 15px 0px;">Sigur doriti sa stergeti acest slideshow?</h2>
                    <button class="btn btn-default" id="yesdelete">Da</button>
                    <button class="btn btn-primary" data-dismiss="modal">Nu</button>
                </div>
              </div>
            </div>
        </div>
    
    
    <script>
        $("body").on("click","button[name=delslideshow]",function(){
            var id=$(this).attr("id");
            $("#yesdelete").attr("iddel",id);
            $("#comfirm_delete_slideshow").modal();
        });
        $("#yesdelete").on("click",function(){
            var id=$(this).attr("iddel");
            $.ajax({
                type:'post',
                url:"{{URL('/admin/delslideshow')}}",
                data:{
                    id:id
                },
                success:function(data){
                    $("#slide"+data).remove();
                    $("#comfirm_delete_slideshow").modal("hide");
                }
            });
        });
        $("#upload").on("submit",function(e){
            e.preventDefault();
            var nume=$("input[name=link]").val();
            var formData = new FormData(this);
            formData.append("link",nume);
            $("#error").html("");
            $("input[name=link]").css("border-color","#ccc");
            var asset="{{asset('/')}}";
            if(nume.length>0 && nume.length<230){
                $("#saveslideshow").button("loading");
                $.ajax({
                    type:'POST',
                    url: "{{URL('/admin/addslideshow')}}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        if(data.succes===true){
                            $("#upload")[0].reset();
                            $("input[name=link]").val("");
                            $("#sliders").prepend("<div class='col-md-12 imageslideshow' id='slide"+data.link.id+"'>\n\
                                                        <p>\n\
                                                            <a href='"+data.link.link+"' target='_blank'>\n\
                                                                "+data.link.link+"\n\
                                                            </a>\n\
                                                            <button class='btn btn-danger btn-sm' id='"+data.link.id+"' name='delslideshow' style='float:right; margin-bottom:10px;'>\n\
                                                                <span class='glyphicon glyphicon-arrow-down'></span>\n\
                                                                Sterge\n\
                                                            </button>\n\
                                                        </p>\n\
                                                        <img class='img-responsive' src='"+asset+data.link.image+"' />\n\
                                                    </div>");
                        }else{
                            $("#error").html("A aparut o eroare la incarcare");
                        }
                        $("#saveslideshow").button("reset");
                    },
                    error:function(){
                        $("#error").html("A aparut o eroare la incarcare");
                        $("#saveslideshow").button("reset");
                    }
                });
            }else{
                $("input[name=link]").css("border-color","red");
                $("input[name=link]").focus();
            }
        });
    </script>
@endsection