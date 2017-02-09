@extends("admin.base")
@section("content")
@if(!empty($menu))
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <p class="menuexpand text-center">
        <b>Meniu</b><br>
        <a href="#" onclick="inpand()">
            <span class="glyphicon glyphicon-minus"></span>
            Meniu
        </a>
        <a href="#" onclick="expanditems()">
            <span class="glyphicon glyphicon-star"></span>
            Sub meniu
        </a>
        <a href="#" onclick="expand()">
            <span class="glyphicon glyphicon-zoom-in"></span>
            Toate
        </a>
    </p>
    <p class="text-center adaugamenu">
        <span onclick="inchideDeschide('formaddmenu')">
            <b class="glyphicon glyphicon-plus"></b>
            Adauga meniu
        </span>
    </p>
    <ol class="list_menu">
        @foreach($menu["menu"] as $i)
            <li id="{{$i->id}}" class="lmenu">
                {{$i->menu_name}}
                <span class="pull-right">
                    <span class="glyphicon glyphicon-plus addmenu" id="add{{$i->id}}"></span>
                    <span class="glyphicon glyphicon-pencil modmenu" id="mod{{$i->id}}"></span>
                    <span class="glyphicon glyphicon-remove"></span>
                </span>
            </li> 
            <ol id="menu{{$i->id}}" class="list_submenu">
                @foreach($menu["submenu"] as $j)
                    @if($i->id==$j->menu_id)
                        <li id="{{$j->id}}" class="lsubmenu">
                            {{$j->submenu_name}}
                            <span class="pull-right">
                                <span class="glyphicon glyphicon-plus additem" id="addsub{{$j->id}}"></span>
                                <span class="glyphicon glyphicon-pencil modsubmenu" id="mod{{$j->id}}"></span>
                                <span class="glyphicon glyphicon-remove"></span>
                            </span>
                        </li>
                        <ol id="submenu{{$j->id}}" class="list_items">
                            @foreach($menu["items"] as $k)
                                @if($j->id==$k->submenu_id)
                                    <li>
                                        {{$k->item_name}}
                                        <span class="pull-right">
                                            <span class="glyphicon glyphicon-pencil moditem" id="mod{{$k->id}}"></span>
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </span>
                                    </li>
                                @else
                                    @continue
                                @endif
                            @endforeach
                        </ol>
                    @else
                        @continue
                    @endif
                @endforeach
            </ol>
        @endforeach
     </ol>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <form class="form-horizontal" name="formaddmenu">
        <h2 class="text-center" style="padding:0px;margin:0px;">Adauga menu</h2>
        <div class="form-group">
            <label class="control-label col-sm-3">Nume:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="nameadd">
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Adauga</button>
            </div>
        </div>
    </form>
    <form class="form-horizontal" name="formaddsubmenu">
        <h2 class="text-center" style="padding:0px;margin:0px;">Adauga submenu</h2>
        <div class="form-group">
            <label class="control-label col-sm-3">Nume:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="nameSubadd">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Meniu parinte:</label>
            <div class="col-sm-9">
                <select class="form-control" name="parinteSubadd">
                    @foreach($menu["menu"] as $i)
                        <option value="{{$i->id}}">{{$i->menu_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <p name="erorimage" class="text-danger text-center"></p>
            <label class="control-label col-sm-3">Imagine:</label>
            <div class="col-sm-9">
                <img src="" id="imageview" class="img-responsive" style="width: 250px;"/>
                <input type="file" name="imageSubadd"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Activ:</label>
            <div class="col-sm-9">
                <select class="form-control" name="activSubadd">
                    <option value="1">Activat</option>
                    <option value="0">Dezactivat</option>
                </select>
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Adauga</button>
            </div>
        </div>
    </form>
    <form class="form-horizontal" name="formadditem">
        <h2 class="text-center" style="padding:0px;margin:0px;">Adauga item</h2>
        <div class="form-group">
            <label class="control-label col-sm-3">Nume:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="nameitemadd">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">SubMeniu:</label>
            <div class="col-sm-9">
                <select class="form-control" name="subparinteItemadd">
                    @foreach($menu["submenu"] as $i)
                        <option value="{{$i->id}}" name="{{$i->menu_id}}">{{$i->submenu_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <p name="erorimage" class="text-danger text-center"></p>
            <label class="control-label col-sm-3">Imagine:</label>
            <div class="col-sm-9">
                <img src="" id="imageviewitem" class="img-responsive" style="width: 250px;"/>
                <input type="file" name="imageItemadd"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Activ:</label>
            <div class="col-sm-9">
                <select class="form-control" name="activItemadd">
                    <option value="1">Activat</option>
                    <option value="0">Dezactivat</option>
                </select>
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Adauga</button>
            </div>
        </div>
    </form>
    <form class="form-horizontal" name="formmenu">
        <h2 class="text-center" style="padding:0px;margin:0px;">Setari menu</h2>
        <div class="form-group">
            <label class="control-label col-sm-3">Nume:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Salveaza</button>
            </div>
        </div>
    </form>
    <form class="form-horizontal" name="formsubmenu">
        <h2 class="text-center" style="padding:0px;margin:0px;">Setari submenu</h2>
        <div class="form-group">
            <label class="control-label col-sm-3">Nume:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="nameSub">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Meniu parinte:</label>
            <div class="col-sm-9">
                <select class="form-control" name="parinteSub">
                    @foreach($menu["menu"] as $i)
                        <option value="{{$i->id}}">{{$i->menu_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <p name="erorimage" class="text-danger text-center"></p>
            <label class="control-label col-sm-3">Imagine:</label>
            <div class="col-sm-9">
                <img src="" id="imageviewer" class="img-responsive" style="width: 250px;"/>
                <input type="file" name="imageSub"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Activ:</label>
            <div class="col-sm-9">
                <select class="form-control" name="activSub">
                    <option value="1">Activat</option>
                    <option value="0">Dezactivat</option>
                </select>
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Salveaza</button>
            </div>
        </div>
    </form>
    <form class="form-horizontal" name="formitemsmenu">
        <h2 class="text-center" style="padding:0px;margin:0px;">Setari iteme</h2>
        <div class="form-group">
            <label class="control-label col-sm-3">Nume:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="nameItem">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Meniu parinte:</label>
            <div class="col-sm-9">
                <select class="form-control" name="parinteItem">
                    @foreach($menu["menu"] as $i)
                        <option value="{{$i->id}}">{{$i->menu_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">SubMeniu:</label>
            <div class="col-sm-9">
                <select class="form-control" name="subparinteItem">
                    @foreach($menu["submenu"] as $i)
                        <option value="{{$i->id}}" name="{{$i->menu_id}}">{{$i->submenu_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <p name="erorimage" class="text-danger text-center"></p>
            <label class="control-label col-sm-3">Imagine:</label>
            <div class="col-sm-9">
                <img src="" id="imageviewitem1" class="img-responsive" style="width: 250px;"/>
                <input type="file" name="imageItem"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Activ:</label>
            <div class="col-sm-9">
                <select class="form-control" name="activItem">
                    <option value="1">Activat</option>
                    <option value="0">Dezactivat</option>
                </select>
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>
@endif
<style>
    .form-horizontal{
        display: none;
    }
</style>
<script>
    var menu=0;
    var submenu=0;
    var items=0;
    $("form[name=formaddmenu]").show();
    function expand(){
        $(".list_menu ol").slideDown(500);
    }
    function inpand(){
        $(".list_menu ol").hide(500);
    }
    function expanditems(){
       $(".list_menu .list_submenu").slideDown(500);
       $(".list_menu .list_items").hide(500);
    }
    $(document).on('submit','form[name=formaddmenu]',function(e){
        e.preventDefault();
        var name=$("input[name=nameadd]").val();
        if (name.length>0 && name.length<30){
            $.ajax({  
                type: 'POST',  
                url: "{{URL('/admin/addelement/menu')}}", 
                data: 
                    {
                      name:name
                    },
                success: function() {
                    $("input[name=nameadd]").css("border-color","gray");
                    location.reload();
                }
            });
        }
        else{
            $("input[name=nameadd]").css("border-color","red");
        }
    });
    $(document).on('submit','form[name=formaddsubmenu]',function(e){
        e.preventDefault();
        var name=$("input[name=nameSubadd]").val();
        if (name.length>0 && name.length<30){
            var form=new FormData($(this)[0]);
            form.append("id",submenu);
            $.ajax({
                url:"{{URL('/admin/addelement/submenu')}}",
                data:form,
                dataType:'json',
                async:false,
                type:'post',
                processData: false,
                contentType: false,
                success:function(data){
                    $("input[name=nameSubadd]").css("border-color","gray");
                    if(data.succes===true){
                        $("p[name=erorimage]").html("");
                        location.reload();
                    }else{
                        $("p[name=erorimage]").html("Eroare la incarcarea imaginii");
                    }
                }
            });
        }
        else{
            $("input[name=nameSubadd]").css("border-color","red");
        }
    });
    $(document).on('submit','form[name=formadditem]',function(e){
        e.preventDefault();
        var name=$("input[name=nameitemadd]").val();
        if (name.length>0 && name.length<30){
            var form=new FormData($(this)[0]);
            form.append("id",items);
            $.ajax({
                url:"{{URL('/admin/addelement/items')}}",
                data:form,
                dataType:'json',
                async:false,
                type:'post',
                processData: false,
                contentType: false,
                success:function(data){
                    $("input[name=nameitemadd]").css("border-color","gray");
                    if(data.succes===true){
                        $("p[name=erorimage]").html("");
                        location.reload();
                    }else{
                        $("p[name=erorimage]").html("Eroare la incarcarea imaginii");
                    }
                }
            });
        }
        else{
            $("input[name=nameitemadd]").css("border-color","red");
        }
    });
    $(document).on('submit','form[name=formmenu]',function(e){
        e.preventDefault();
        var name=$("input[name=name]").val();
        var position=$("select[name=position]").val();
        if (name.length>0 && name.length<30){
            $.ajax({  
                type: 'POST',  
                url: "{{URL('/admin/modelement/menu')}}", 
                data: 
                    { id:menu,
                      name:name,
                      position:position
                    },
                success: function() {
                    inchideDeschide("formmenu");
                    $("input[name=name]").css("border-color","gray");
                    location.reload();
                }
            });
        }
        else{
            $("input[name=name]").css("border-color","red");
        }
    });
    $(document).on('submit',"form[name=formsubmenu]",function(e){
        e.preventDefault();
        var name=$("input[name=nameSub]").val();
        if (name.length>0 && name.length<30){
            var form=new FormData($(this)[0]);
            form.append("id",submenu);
            $.ajax({
                url:"{{URL('/admin/modelement/submenu')}}",
                data:form,
                dataType:'json',
                async:false,
                type:'post',
                processData: false,
                contentType: false,
                success:function(data){
                    $("input[name=nameSub]").css("border-color","gray");
                    if(data.succes===true){
                        $("p[name=erorimage]").html("");
                        location.reload();
                    }else{
                        $("p[name=erorimage").html("Eroare la incarcarea imaginii");
                    }
                }
              });
        }
        else{
            $("input[name=nameSub]").css("border-color","red");
        }
    });
    $(document).on('submit',"form[name=formitemsmenu]",function(e){
        e.preventDefault();
        var name=$("input[name=nameItem]").val();
        var subparinte=$("select[name=subparinteItem]").val();
        if (name.length>0 && name.length<30){
            if(subparinte>0){
                var form=new FormData($(this)[0]);
                form.append("id",items);
                $.ajax({
                    url:"{{URL('/admin/modelement/itemmenu')}}", 
                    data:form,
                    dataType:'json',
                    async:false,
                    type:'post',
                    processData: false,
                    contentType: false,
                    success:function(data){
                        $("input[name=nameItem]").css("border-color","gray");
                        $("select[name=subparinteItem]").css("border-color","gray");
                        if(data.succes===true){
                            $("p[name=erorimage").html("");
                            location.reload();
                        }else{
                            $("p[name=erorimage").html("Eroare la incarcarea imaginii");
                        }
                    }
                  });
            }else{
                $("select[name=subparinteItem]").css("border-color","red");
            }
        }
        else{
            $("input[name=nameItem]").css("border-color","red");
        }
    });
    $("body").on("click",".addmenu",function() {
        submenu=$(this).attr("id").replace('add','');
        $("select[name=parinteSubadd]").val(submenu);
        inchideDeschide("formaddsubmenu");
    });
    $("body").on("click",".additem",function() {
        items=$(this).attr("id").replace('addsub','');
        $("select[name=subparinteItemadd]").val(items);
        inchideDeschide("formadditem");
    });
    function inchideDeschide(name){
        $(".form-horizontal").hide();
        $("form[name="+name+"]").show();
    }
    $("body").on("click",".modmenu",function() {
        menu=$(this).attr("id").replace('mod','');
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/admin/getelement/onemenu')}}", 
            data: 
                { id:menu
                },
            success: function(data) {
                $("input[name=name]").val(data[0].menu_name);
                inchideDeschide("formmenu");
                $("input[name=name]").focus();
            }
        });
    });
    $("body").on("click",".modsubmenu",function() {
        submenu=$(this).attr("id").replace('mod','');
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/admin/getelement/onesubmenu')}}", 
            data: 
                { id:submenu
                },
            success: function(data) {
                $("input[name=nameSub]").val(data[0].submenu_name);
                $("#imageviewer").attr("src","{{asset('/')}}"+data[0].submenu_image);
                $("select[name=parinteSub] option[value="+data[0].menu_id+"]").prop('selected', true);
                $("select[name=activSub] option[value="+data[0].submenu_active+"]").prop('selected', true);
                inchideDeschide("formsubmenu");
                $("input[name=nameSub]").focus();
            }
        });
    });
    $("body").on("click",".moditem",function() {
        items=$(this).attr("id").replace('mod','');
        $("select[name=subparinteItem] option").hide();
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/admin/getelement/oneitemmenu')}}", 
            data: 
                { id:items
                },
            success: function(data) {
                $("#imageviewitem1").attr("src","{{asset('/')}}"+data[0].item_image);
                $("input[name=nameItem]").val(data[0].item_name);
                $("select[name=parinteItem] option[value="+data[1].menu_id+"]").prop('selected', true);
                $("select[name=subparinteItem] option[value="+data[1].id+"]").prop('selected', true);
                $("select[name=activItem] option[value="+data[0].item_active+"]").prop('selected', true);
                $("select[name=subparinteItem] option[name="+data[1].menu_id+"]").show();
                inchideDeschide("formitemsmenu");
                $("input[name=nameItem]").focus();
            }
        });
    });
    $("select[name=parinteItem]").change(function() {
        $("select[name=subparinteItem] option").hide();
        var m=$("select[name=parinteItem]").val();
        $("select[name=subparinteItem]").val("");
        $("select[name=subparinteItem] option[name="+m+"]").show();
    });
    $("select[name=parinteItemadd]").change(function() {
        $("select[name=subparinteItemadd] option").hide();
        var m=$("select[name=parinteItemadd]").val();
        $("select[name=subparinteItemadd]").val("");
        $("select[name=subparinteItemadd] option[name="+m+"]").show();
    });
    $("body").on("click",".list_menu span" ,function(e) {
        e.preventdefault();
    });
    $("body").on("click",".list_menu .lmenu" ,function() {
        $("#menu"+$(this).attr("id")).slideToggle(500);
    });
    $("body").on("click",".list_submenu .lsubmenu" ,function() {
        $("#submenu"+$(this).attr("id")).slideToggle(500);
    });
    
</script>
@endsection
