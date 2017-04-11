@extends("admin.base")
@section("content")
<style>
.loadimage{
    opacity:0;
}
.imgprincipal{
    position:absolute;
}
.preview{
    width: 150px;
    height: 150px;
    margin:5px;
    cursor:pointer;
}
#upload{
    float:left;
    height: 150px;
}
#imagini{
    width: 100%;
    float: left;
    margin: 0px 0px 10px 0px;
}
.file {
    cursor:pointer;
}
#error{
    width: 100%;
    float: left;
    margin-top:5px;
    font-weight: bold;
}
/*TEST*/
.imgWrap {
    height:150px;
    width: 150px;
    float:left;
    margin:2px;
  }
.imgDescription {
    margin: -60px 0px 0px 95px;
    color: black;
    font-weight: bold;
    font-size: 20px;
    position: absolute;
    visibility: hidden;
}
.white{
    position:absolute;
    width:150px;
    height:150px;
    background-color: black;
    margin: -155px 0px 0px 5px;
    visibility: hidden;
    opacity: 0.7;
}
.imgWrap:hover .imgDescription{
    visibility: visible;
}
.imgWrap:hover .white{
    visibility: visible;
}
.setari{
    padding:0px;
    margin:0px;
}
.setari li{
    list-style-type: none;
    cursor:pointer;
}
.setari li:hover{
    background-color: #cfe8ec;
}
.dropdown-toggle{
    cursor:pointer;
}
.set{
    position: absolute;
    margin: -154px 0px 0px 6px;
    background-color: white;
}
.set span{
    padding: 5px;
}
.group_specification{
    font-weight: bold;
    font-size: 17px;
    margin: 0px;
    text-align:center;
}
</style>
<div class="col-md-12">
    @if(!empty($article["name"]))
        <div style="width: 100%;">
            <a href="#ModalAddMod" class="pull-right btn btn-primary" id="AddElement" data-toggle="modal">
                <span class="glyphicon glyphicon-plus"></span>
                Add Element
            </a>
        </div>
        <h1 class="text-center">
            {{$article["name"]}}
        </h1>
    @endif
    @if(!empty($article["products"]))
        @if(count($article["products"])>0)
        <div class="table-responsive">
            <table class="table table-bordered tabeleadmin" id="tabel">
                <thead>
                    <tr>
                        <th class="titluid">ID:</th>
                        <th class="titluimagine">Image:</th>
                        <th>Nume:</th>
                        <th>Pret(Lei)</th>
                        <th>Vizualizat:</th>
                        <th>Creat:</th>
                        <th style="width:  220px;">Setari:</th>
                    </tr>
                </thead>
                @foreach($article["products"] as $i)
                <tr id="{{$i->id}}">
                    <td>{{$i->id}}</td>
                    <td class="hoverimage">
                        @if(\File::exists($i->address))
                            <img src="{{ asset($i->address) }}" class="img-responsive imaginetable"/>
                        @else
                            <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive imaginetable"/>
                        @endif
                    </td>
                    <td id="name{{$i->id}}" >
                        <a href="{{URL("/product/".$i->id)}}" target="_blank">
                            {{$i->originalname}}{{$i->name}}
                        </a>
                    </td>
                    <td id="price{{$i->id}}">{{$i->price}}</td>
                    <td>{{$i->views}}</td>
                    <td>{{date('d/m/Y', strtotime($i->created_at))}}</td>
                    <td>
                        <a href="#ModalAddMod" class="modifica" id="moditem{{$i->id}}" data-toggle="modal"> 
                            <span class="glyphicon glyphicon-cog"></span>
                            Modifica
                        </a>  
                        <a class="sterge" id="delete{{$i->id}}"> 
                            <span class="glyphicon glyphicon-minus"></span>
                            Sterge
                        </a> 
                        <br>
                        <a href="{{URL('/admin/descriere/'.$i->id)}}"> 
                            <span class="glyphicon glyphicon-minus"></span>
                            Descriere
                        </a> 
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        @else
            <h1>Nu sunt produse</h1>
        @endif
    @else
        <h1>Nu exista asa tip de produse</h1>
    @endif
</div>

<div id="ModalAddMod" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="padding-bottom:0px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <form method="post" id="formsave">
                    <table class="table" id="tableModalAddMod">
                    </table>
                    <div style="position: relative;
                                left: 45%;
                                width: 100%;" id="loader">
                        <img src="{{asset("/img/system/spin.gif")}}" style="width:30px;"/>
                    </div>
                </form>
                
                <!-- Adaugare a imaginii-->
                <div id="imagini">
                    <p class="group_specification">
                        Imagini <br>
                        <img src="{{asset("/img/system/loadingreglog.gif")}}" class="loadimage"/>
                    </p>
                    <form id="upload" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label class="file">
                            <div class='imgWrap'>
                                <img src="{{asset("img/system/upload.png")}}" class="preview" />
                                <div class='white'></div>
                                <p class='imgDescription' style="font-size: 20px;color: white;width: 130px;margin-left: 45px;">
                                    Upload
                                </p>
                            </div>
                            <input type="file" name="file[]" multiple style="display:none;"><br>
                        </label>
                    </form>
                    <div id="raspuns">  
                    </div>
                    <div id="error" class="text-danger text-center">
                        
                    </div>
                </div>
                <!--End adaugare a imaginii -->
            </div>
            <div class="modal-footer">
                <button id="saveMod" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Salveaza</button>
                <button id="close" class="btn btn-default" data-dismiss="modal" onclick="deleteallimages()">Anuleaza</button>
            </div>
        </div>
    </div>
</div>
<script>
    var table='{{$article["id"]}}';
    var id=0;
    var idsterge=0;
</script>
<div class="modal fade" id="comfirm_delete" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center">Sterge produs</h4>
        </div>
        <div class="modal-body text-center">
            <h2 class="calibri" style="margin: 0px 0px 15px 0px;">Sigur doriti sa stergeti acest produs?</h2>
            <button class="btn btn-default" id="yesdelete">Da</button>
            <button class="btn btn-primary" data-dismiss="modal">Nu</button>
        </div>
      </div>
    </div>
</div>
<!--Script pentru adaugare a imaginii-->
<script>
var form=document.getElementById("upload");
$(document).ready(function (e) {
    $('#upload').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("id",id);
        $("#error").text("");
        $(".loadimage").css("opacity","1");
        $.ajax({
            type:'POST',
            url: "{{URL('/admin/upload')}}",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                var eror=0;
                $.each(data, function( index, value ) {
                    if(value.succes===true){
                        $("#raspuns").append("<div class='imgWrap' id='im"+value.id+"'>\n\
                                            <img src='"+value.image+"' class='preview'/>\n\
                                            <div class='white'></div> \n\
                                            <div class='dropdown set'>\n\
                                                <span class='dropdown-toggle glyphicon glyphicon-pencil' data-toggle='dropdown'></span>\n\
                                                <div class='dropdown-menu'>\n\
                                                    <ul class='setari'>\n\
                                                        <li onclick='defaultimage("+value.id+")'>Seteaza principala</li>\n\
                                                        <li onclick='sterge("+value.id+")'>Sterge</li>\n\
                                                    </ul>\n\
                                                </div>\n\
                                            </div>\n\
                                        </div>");
                    }else{
                        eror++;
                    }
                });
                if(eror>0){
                    $("#error").text(eror+" imagini sau incarcat");
                }
                $(".loadimage").css("opacity","0");
                $('#upload')[0].reset();
            },
            error:function(){
                $(".loadimage").css("opacity","0");
                $("#error").text("A aparut o eroare");
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
<!-- Endscript pentru adaugare a imaginii-->
<script>
    function lfade(){
        $("#loader").fadeIn();
        $("#upload").hide();
        $(".modal-footer").hide();
    }
    function lhide(){
        $("#loader").hide();
        $(".modal-footer").fadeIn();
        $("#upload").fadeIn();
    }
    $("body").on("click","#AddElement" ,function(){
        $("#tableModalAddMod").html("");
        $("#saveMod").attr("id","addMod");
        id=-1;
        $("#raspuns").html("");
        lfade();
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/admin/getoneadd')}}", 
            data: 
                {
                  table:table
                },
            success: function(data) {
                $("#tableModalAddMod").append("<tr>\n\
                                                <td class='text-center' colspan=3><b>Produs nou</b></td>\n\
                                            </tr>");
                oneitem(data);
                lhide();
            }
        });
    });
    $("body").on("click",".modifica" ,function() {
        id=$(this).attr("id").replace('moditem','');
        $("#addMod").attr("id","saveMod");
        $("#tableModalAddMod").html("");
        $("#raspuns").html("");
        lfade();
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/admin/getoneitem')}}", 
            data: 
                { element:id,
                  table:table
                },
            success: function(data) {
                $("#tableModalAddMod").append("<tr>\n\
                                                <td><b>Id:</b></td>\n\
                                                <td>#"+data[0][1]+"</td>\n\
                                                <td></td>\n\
                                            </tr>");
                oneitem(data); 
                lhide(); 
            }
        });
        
    });
    $("body").on("click","#saveMod , #addMod" ,function() {
        var rowidcontrol=[];
        var rowid=[];
        var rowvalue=[];
        var obligat=[];
        var name="";
        var istrue=true;
        $("form#formsave :input").each(function(){
            rowidcontrol.push($(this).attr("name").replace("spec",""));
            rowid.push($(this).attr("name"));
            rowvalue.push($(this).val());
            if($(this).attr("ob")==='1' || $(this).attr("ob2")==='1'){
                obligat.push("1");
            }else{
                obligat.push("0");
            }
            if($(this).attr("ob")==='1'){
                name+=" , "+$(this).val();
            }
        });
        for (var i = 0; i < 2; i++) {
            if(rowvalue[i].length===0 || rowvalue[i].length>rowlength){
                $("#"+rowid[i]).removeClass("has-success").addClass("has-error");
                $("#"+rowid[i]+" span").removeClass("glyphicon-ok").addClass("glyphicon-remove");
                $("#"+rowid[i]+" input").focus();
                istrue=false;
            }else{
                $("#"+rowid[i]).removeClass("has-error").addClass("has-success");
                $("#"+rowid[i]+" span").removeClass("glyphicon-remove").addClass("glyphicon-ok");
            }
        }
        for (var i = 2; i < rowid.length; i++) {
            var rowlength=250;
            if(rowvalue[i].length>rowlength || (obligat[i]==='1' && rowvalue[i].length===0)){
                $("#"+rowid[i]).removeClass("has-success").addClass("has-error");
                $("#"+rowid[i]+" span").removeClass("glyphicon-ok").addClass("glyphicon-remove");
                $("#"+rowid[i]+" input").focus();
                istrue=false;
            }else{
                $("#"+rowid[i]).removeClass("has-error").addClass("has-success");
                $("#"+rowid[i]+" span").removeClass("glyphicon-remove").addClass("glyphicon-ok");
            }
        }
        if($(this).attr("id")==="saveMod"){
            var url="{{URL('/admin/modificaItem')}}";
        }else{
            var url="{{URL('/admin/addItem')}}";
        }
        if(istrue===true){
           $("#saveMod").button("loading");
           $("#addMod").button("loading");
           $.ajax({  
                type: 'POST',  
                url: url, 
                data: 
                    { id:id,
                      table:table,
                      rowid:rowidcontrol,
                      rowvalue:rowvalue,
                      name:name
                    },
                success: function() {
                    location.reload();
                    $("#close").click();
                    $("#addMod").button("reset");
                    $("#saveMod").button("reset");
                }
            });
        }
    });
    $("body").on("click",".sterge" ,function() {
        idsterge=$(this).attr("id").replace('delete','');
        $("#comfirm_delete").modal();
        $("#yesdelete").attr("name",$(this).attr("id").replace('delete',''));
    });
    $("body").on("click","#yesdelete" ,function(){
         $.ajax({  
            type: 'POST',  
            url: "{{URL('/admin/deleteItem')}}", 
            data: 
                { id:$(this).attr("name")
                },
            success: function() {
                location.reload();
            }
        });
    });
    function sterge(ida){
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/admin/deleteImage')}}", 
            data: 
                { id:ida,
                  item_id:id
                },
            success: function(data) {
                $("#im"+data).fadeOut(500);
            }
        });
    }
    function deleteallimages(){
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/admin/deleteAllImages')}}", 
            data: 
                {
                  id:id
                },
            success: function() {
            }
        });
    }
    function defaultimage(ida){
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/admin/defaultImage')}}", 
            data: 
                { id:ida,
                  table:table,
                  item_id:id
                },
            success: function() {
            }
        });
    }
    function oneitem(data){
        /*Afisam toate elementele*/
        for(var i=1;i<3;i++){
                $("#tableModalAddMod").append("<tr>\n\
                               <td><b>"+data[i][0]+":</b></td>\n\
                               <td class='form-group has-feedback' id='row"+i+"'>\n\
                                   <input type='text' class='form-control' value='"+data[i][1]+"' name='row"+i+"'/>\n\
                                   <span class='glyphicon form-control-feedback'></span>\n\
                                   </td>\n\
                           </tr>");
        }
        $.each(data[3], function( index, value ) {
            $("#tableModalAddMod").append("<tr><td colspan='2' class='text-center'>"+index+"</td></tr>");
            $.each(value, function( index, value ) {
                $("#tableModalAddMod").append("<tr>\n\
                               <td><b>"+value.specification_name+":</b></td>\n\
                               <td class='form-group has-feedback' id='spec"+value.id+"'>\n\
                                   <input type='text' class='form-control' name='spec"+value.id+"' ob='"+value.addname+"' ob2='"+value.addsearch+"'/>\n\
                                   <span class='glyphicon form-control-feedback'></span>\n\
                                   </td>\n\
                           </tr>");
            });
        });
        $.each(data[4], function( index, value ) {
            $("input[name=spec"+value.specification_id+"]").val(value.value); 
        });
        /*Facem ca pretu sa se introduca doar cifre*/
        $("input[name=row2]").attr("type","number");
        /*Adaugam imaginile pe ultima linie is imaginile si contine un array cu toate imaginile lui*/
        for(var i=data.length-1;i<data.length;i++){
            for(var j=0;j<data[i][1].length;j++){
                $("#raspuns").append("<div class='imgWrap' id='im"+data[i][1][j].id+"'>\n\
                                        <img src='"+data[i][0]+data[i][1][j].address+"' class='preview'/>\n\
                                        <div class='white'></div> \n\
                                        <div class='dropdown set'>\n\
                                            <span class='dropdown-toggle glyphicon glyphicon-pencil' data-toggle='dropdown'></span>\n\
                                            <div class='dropdown-menu'>\n\
                                                <ul class='setari'>\n\
                                                    <li onclick='defaultimage("+data[i][1][j].id+")'>Seteaza principala</li>\n\
                                                    <li onclick='sterge("+data[i][1][j].id+")'>Sterge</li>\n\
                                                </ul>\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>");
            }
        }
    }
    
    function closecomfirm(){
        $(".comfirm-div,.full-page").fadeOut();
    }
</script>
@endsection