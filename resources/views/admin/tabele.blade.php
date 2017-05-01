@extends("admin.base")
@section("content")
<style>
    .tabeleadmin span:hover{
        cursor: pointer;
        color:red;
    }
</style>
<div class="content">
    @if(!empty($tabele))
        <div class="table-responsive">
            <table class="table table-bordered tabeleadmin">
                <b>Tabele</b>
                <thead>
                    <tr>
                        <th class="titluid">ID : </th>
                        <th class="titluimagine">Image:</th>
                        <th>Nume : </th>
                        <th>Creat : </th>
                        <th style="width:  220px;">Setari : </th>
                    </tr>
                </thead>
                @foreach($tabele as $i)
                <tr id="t{{$i->id}}">
                    <td>{{$i->id}}</td>
                    <td class="hoverimage">
                        @if(\File::exists($i->item_image))
                            <img src="{{ asset($i->item_image) }}" class="img-responsive imaginetable"/>
                        @else
                            <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive imaginetable"/>
                        @endif
                    </td>
                    <td>{{$i->item_name}}</td>
                    <td>{{date('d/m/Y', strtotime($i->created_at))}}</td>
                    <td>
                        <a class="modifica" id="{{$i->id}}"> 
                            <span class="glyphicon glyphicon-cog"></span>
                            Modifica
                        </a>  
                    </td>
                </tr>
                <tr class="coloanedintabele" id="col{{$i->id}}">
                    <td colspan="5">
                        <span class="glyphicon glyphicon-remove pull-right" onclick="closeitems()"></span>
                        <form id="form{{$i->id}}" class="col-md-12">
                            <div class="specificationsGroup col-xs-12">
                                <p class='text-center'>Specificatii implicite</p>
                                <input type="text" value="Nume" class="col-xs-3 form-control" readonly>
                                <input type="text" value="Pret" class="col-xs-3 form-control" readonly>
                                <input type="text" value="Imagine" class="col-xs-3 form-control" readonly>
                            </div>
                        </form>
                        <div class="buttonsave">
                            <button class='btn btn-primary savecimp' onclick='salveaza()' data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Salveaza</button>
                            <button class='btn btn-default' id='addcimp' onclick='adaugagrup()'>Adauga un grup</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    {{$tabele->links()}}
    @else
        <h1>Nu sunt tabele</h1>
    @endif
</div>
<div class='full-page'>
</div>
<div class='comfirm-div'>
    <h3>Modifica sau sterge</h3>
    <input class="form-control" type="text" name="modordel" style="margin-bottom:10px;"/>
    <button class="btn btn-primary" id='yessave'>Salveaza</button>
    <button class="btn btn-default" onclick='closecomfirm()'>Anuleaza</button>
    <div class='dropdown pull-right'>
        <button class="btn btn-danger" data-toggle='dropdown'>
            <span class="glyphicon glyphicon-remove"></span>
            Sterge
        </button>
        <div class='dropdown-menu' style="margin: 0px;width: 100%; padding: 5px 15px;text-align: center;">
            Sigur doriti sa stergeti?<br>
            <a style="cursor: pointer;" id='yesdelete'>Da</a><br>
            <a style="cursor: pointer;" onclick="closecomfirm()">Nu</a>
        </div>
    </div>
</div>
<div class='comfirm-div1'>
    <h3>Adauga un grup</h3>
    <input class="form-control" type="text" name="addgroup" style="margin-bottom:10px;"/>
    <button class="btn btn-primary" onclick="insertgroup()">Salveaza</button>
    <button class="btn btn-default" onclick='closecomfirm()'>Anuleaza</button>
</div>
<script>
    var mod=0;
    function adaugagrup(){
        $(".full-page , .comfirm-div1").fadeIn(200);
    }
    function insertgroup(){
        var value=$("input[name=addgroup]").val();
        if(value.length>0 && value.length<100){
            $.ajax({  
                type: 'POST',  
                url: "{{URL('/admin/addGroup')}}", 
                data:{
                    table:mod,
                    value:value
                },
                success: function(data) {
                    closecomfirm();
                    var button="<a name='addSpecification' onclick='adaugaspec("+data+")' id='add_"+data+"'>+ Adauga specificatie</a>";
                    $("#col"+mod+" td form").append("<div class='specificationsGroup col-xs-12 adaugat' id='divspec"+data+"'>\n\
                                            <p class='text-center'><span id='group"+data+"'>"+value+"</span>\
                                                <span class='glyphicon glyphicon-cog' onclick='ModOrDel("+data+")'></span>\n\
                                            </p>\n\
                                            "+button+"</div>");
                    $("input[name=addgroup]").css("border-color","#ccc");
                }
            });
        }else{
            $("input[name=addgroup]").css("border-color","red");
        }
    }
    $("body").on("click",".modifica" ,function() {
        $(".tabeleadmin tr td .nuseapasa").removeClass( "nuseapasa" ).addClass( "modifica" );
        $(this).removeClass( "modifica" ).addClass( "nuseapasa" );
        $("#t"+mod).removeClass("activeadmin");
        $(".coloanedintabele").css("display","none");
        mod=$(this).attr("id").replace('mod','');
        $(".adaugat").remove();
        $("#fullpageload").show();
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/admin/getTabele')}}", 
            data: 
                { id:$(this).attr('id')
                },
            success: function(data) {
                $.each(data, function( index, value ) {
                    adaugcol(index,value);
                });
                $("#col"+mod).fadeIn(500);
                $("#t"+mod).addClass("activeadmin");
                $("#fullpageload").hide();
            },
            error:function(){
                $("#fullpageload").hide();
            }
        });
    });
    function adaugcol(index,value){
        var specifications="";
        var group=0;
        var c=document.forms["form"+mod].getElementsByTagName("input").length;
        $.each(value, function(i,v) {
            if(v.id!==null){
                specifications+="<div id='div"+c+"'>\n\
                                    <input class='col-xs-3 form-control' type='text' value='"+v.specification_name+"' group='"+v.group_id+"' addname='"+v.addname+"' addsearch='"+v.addsearch+"' id='"+v.id+"'/>";
                if(v.addname===0){
                    specifications+="<a class='btn btn-primary' onclick='adaugaLaNume("+v.id+")' id='addname"+v.id+"'>Adauga la nume</a>";
                    
                }else{
                    specifications+="<a class='btn btn-default' onclick='adaugaLaNume("+v.id+")' id='addname"+v.id+"'>Scoate de la nume</a>";
                }
                if(v.addsearch===0){
                    specifications+="<a class='btn btn-info' onclick='adaugaLaCautare("+v.id+")' id='addsearch"+v.id+"'>Adauga la sortare</a>";
                }else{
                    specifications+="<a class='btn btn-default' onclick='adaugaLaCautare("+v.id+")' id='addsearch"+v.id+"'>Scoate de la sortare</a>";
                }
                                    
                     specifications+="<span class='btn btn-danger glyphicon glyphicon-remove remove' id='remove"+c+"'></span>\n\
                                </div>";
                c++;
            }
            group=v.group;
        });
        var button="<a name='addSpecification' onclick='adaugaspec("+group+")' id='add_"+group+"'>+ Adauga specificatie</a>";
        $("#col"+mod+" td form").append("<div class='specificationsGroup col-xs-12 adaugat' id='divspec"+group+"'>\n\
                                            <p class='text-center'><span id='group"+group+"'>"+index+"</span>\
                                                <span class='glyphicon glyphicon-cog' onclick='ModOrDel("+group+")'></span>\n\
                                            </p>\n\
                                            "+specifications+button+"</div>");
        
    }
    function adaugaLaNume(id){
        var name=$("#"+id);
        if(name.attr("addname")==='0'){
           name.attr("addname","1");
           $("#addname"+id).removeClass("btn-primary").addClass("btn-default");
           $("#addname"+id).html("Scoate de la nume");
        }else{
            name.attr("addname","0");
            $("#addname"+id).removeClass("btn-default").addClass("btn-primary");
            $("#addname"+id).html("Adauga la nume");
        }
    }
    function adaugaLaCautare(id){
        var name=$("#"+id);
        if(name.attr("addsearch")==='0'){
           name.attr("addsearch","1");
           $("#addsearch"+id).removeClass("btn-info").addClass("btn-default");
           $("#addsearch"+id).html("Scoate de la sortare");
        }else{
            name.attr("addsearch","0");
            $("#addsearch"+id).removeClass("btn-default").addClass("btn-info");
            $("#addsearch"+id).html("Adauga la sortare");
        }
    }
    $("body").on("click",".remove" ,function() {
        var id=$(this).attr("id").replace('remove','')
        $("#div"+id+" input").attr("name","delete");
        $("#div"+id+" input , #div"+id+" span , #div"+id+" .btn").slideUp(300);
        $("#div"+id).append("<a onclick='anuleaza("+id+")' id='anuleaza"+id+"'>Anuleaza</a>");
    });
    function anuleaza(id){
        $("#anuleaza"+id).remove();
        $("#div"+id+" input").removeAttr("name");
        $("#div"+id+" input , #div"+id+" span , #div"+id+" .btn").slideDown(300);
    }
    function closeitems(){
        $("#t"+mod).removeClass("activeadmin");
        $(".adaugat").remove();
        $(".coloanedintabele").css("display","none");
        $(".tabeleadmin tr td .nuseapasa").removeClass( "nuseapasa" ).addClass( "modifica" );
    }
    function adaugaspec(id){
        var c=document.forms["form"+mod].getElementsByTagName("input").length;
        $("#add_"+id).remove();
        $("#divspec"+id).append("<div id='div"+c+"' style='display:none'>\n\
                                    <input class='col-xs-3 form-control' type='text' group='"+id+"' id='new'/>\n\
                                    <span class='btn btn-danger glyphicon glyphicon-remove remove' id='remove"+c+"'></span>\n\
                                </div>");
        var button="<a name='addSpecification' onclick='adaugaspec("+id+")' id='add_"+id+"'>+ Adauga specificatie</a>";
        $("#divspec"+id).append(button);
        $("#div"+c).slideDown(300);
    }
    function salveaza(){
        $(".savecimp").button("loading");
        var id=[];
        var name=[];
        var group_id=[];
        var update=[];
        var addname=[];
        var addsearch=[];
        var send=true;
        $("#form"+mod+" :input").each(function(){
            if($(this).attr("name")!=="delete"){
                if($(this).val()>250 || $(this).val()<=0){
                    $(this).css("border-color","red");
                    $(this).focus();
                    send=false;
                }else{
                    $(this).css("border-color","#ccc");
                }
            }
            id.push($(this).attr("id"));
            group_id.push($(this).attr("group"));
            update.push($(this).val());
            name.push($(this).attr("name"));
            addname.push($(this).attr("addname"));
            addsearch.push($(this).attr("addsearch"));
        });
        if(send){
            $.ajax({  
                type: 'POST',  
                url: "{{URL('/admin/saveTable')}}", 
                data:{
                    table:mod,
                    id:id,
                    group_id:group_id,
                    update:update,
                    name:name,
                    addname:addname,
                    addsearch:addsearch
                },
                success: function() {
                    $.ajax({  
                        type: 'POST',  
                        url: "{{URL('/admin/getTabele')}}", 
                        data: 
                            { id:mod
                            },
                        success: function(data) {
                            $(".adaugat").remove();
                            $.each(data, function( index, value ) {
                                adaugcol(index,value);
                            });
                            $("#col"+mod).fadeIn(500);
                            $("#t"+mod).addClass("activeadmin");
                            $(".savecimp").button("reset");
                        }
                    });
                }
            });
        }else{
            $(".savecimp").button("reset");
        }
    }
    function ModOrDel(id){
        var s=$("#group"+id).html();
        $("input[name=modordel]").val(s);
        $("#yessave").attr("onclick","savecol("+id+")");
        $("#yesdelete").attr("onclick","deletecol("+id+")");
        $(".full-page , .comfirm-div").fadeIn(200);
    }
    function deletecol(id){
        $.ajax({  
                type: 'POST',  
                url: "{{URL('/admin/deleteColoana')}}", 
                data:{
                    id:id
                },
                success: function() {
                    $("#divspec"+id).remove();
                    closecomfirm();
                }
            });
    }
    function savecol(id){
        var value=$("input[name=modordel]").val();
        if(value.length>0 && value.length<100){
        $.ajax({  
                type: 'POST',  
                url: "{{URL('/admin/modificaColoana')}}", 
                data:{
                    id:id,
                    value:value
                    
                },
                success: function(data) {
                    $("#group"+id).html(data);
                    closecomfirm();
                    $("input[name=modordel]").css("border-color","#ccc");
                }
            });
        }else{
            $("input[name=modordel]").css("border-color","red");
        }
    }
    function closecomfirm(){
        $(".full-page , .comfirm-div , .comfirm-div1").fadeOut(200);
    }
</script>
@endsection
