@extends('base')
@section('content')
<div class="container">
    @if(!empty($profil) && count($profil)>0)
        <div class="col-md-12">
            <h1 class="text-center calibri">Setari</h1>
            <form class=" col-md-6"  id="nameemail">
                <div class="form-group">
                    <label for="name" >Numele:</label>
                    <input type="text" class="form-control" id="name" value="{{$profil->name}}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" value="{{$profil->email}}" required>
                </div>
                <a class="btn btn-default" id="submit">Salveaza</a>
            </form>
            <form class="col-md-6"  id="parola">
                @if(strlen($profil->password)>10)
                <div class="form-group">
                    <label>Parola veche:</label>
                    <input type="text" class="form-control" id="parolaveche" required>
                </div>
                @endif
                <div class="form-group">
                    <label>Parola noua:</label>
                    <input type="password" class="form-control" id="password" required>
                </div>
                <div class="form-group">
                    <label>Repeta parola:</label>
                    <input type="password" class="form-control" id="repeatpassword" required>
                </div>
                <a class="btn btn-default" id="changepassword">Salveaza</a>
            </form>
        </div>
        <div class="col-md-12">
            @if(!empty($comenzi) && count($comenzi)>0)
                <h1 class="text-center calibri">Cumparaturi</h1>
                @foreach($comenzi as $i)
                <div class="comenzidiv" idmoved="{{$i["nume"]["id"]}}">
                    <b style="color:gray;">
                        Comanda id #{{$i["nume"]["id"]}}
                    </b>
                    <button class="btn btn-danger btn-xs pull-right" 
                            style="margin-bottom:15px;" 
                            id="{{$i["nume"]["id"]}}"
                            name="trececomanda">
                        Sterge
                    </button>
                    <table class="table">
                        <tr>
                            <td><b>Adresa:</b></td>
                            <td>{{$i["nume"]["adresa"]}}</td>
                        </tr>
                        <tr>
                            <td><b>Data:</b></td>
                            <td>{{date('d-m-Y H:i', strtotime($i["nume"]["data"]))}}</td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr>
                            <th style="width: 70px;">Imagine:</th>
                            <th>Lista Produselor:</th>
                            <th>Pret (Lei):</th>
                            <th>Cantitate:</th>
                            <th>Pret total (Lei):</th>
                        </tr>
                        <?php $sumatotala=0;?>
                        @foreach($i["produse"] as $j)
                            <tr>
                                <td>
                                    @if(\File::exists($j["imagine"]))
                                        <img src="{{asset($j["imagine"])}}" class="img-responsive"/>
                                    @else
                                        <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive"/>
                                    @endif
                                </td>
                                <td>
                                    <a target="_blank" href="{{URL('/product/'.$j["idprodus"])}}">
                                        {{$j["originalname"]}}{{$j["name"]}}
                                    </a>
                                </td>
                                <td>
                                    {{number_format(floor($j["price"]), 0, '.', ' ')}}.{{str_replace("0.","",(string)number_format(round($j["price"] - (int)$j["price"],2),2))}}
                                </td>
                                <td>{{$j["cantitate"]}}</td>
                                <td>
                                    {{number_format(floor($j["total"]), 0, '.', ' ')}}.{{str_replace("0.","",(string)number_format(round($j["total"] - (int)$j["total"],2),2))}}
                                </td>
                            </tr>
                            <?php $sumatotala+=$j["total"]?>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td colspan="3" class="text-right">
                                <b>
                                    Suma totala:
                                    <span style="color:red; font-size:16px;">
                                    {{number_format(floor($sumatotala), 0, '.', ' ')}}.{{str_replace("0.","",(string)number_format(round($sumatotala - (int)$sumatotala,2),2))}}
                                    Lei
                                    </span>
                                </b>
                            </td>
                        </tr>
                    </table>
                </div>
                @endforeach
                <div class="modal fade" id="comfirm_trecerea" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title text-center">Sterge comanda</h4>
                        </div>
                        <div class="modal-body text-center">
                            <h3 class="calibri">Sigur doresti sa stergi aceasta comanda?</h3>
                            <button class="btn btn-default" id="yesmove">Da</button>
                            <button class="btn btn-primary" data-dismiss="modal">Nu</button>
                        </div>
                      </div>
                    </div>
                </div>
                {{ $comenzi->links() }}
                <script>
                    $("button[name=trececomanda]").on("click",function(){
                        var id=$(this).attr("id");
                        $("#comfirm_trecerea").modal();
                        $("#yesmove").attr("move",id);
                    });
                    $("#yesmove").on("click",function(){
                        $("#comfirm_trecerea").modal("hide");
                        $("div[idmoved="+$('#yesmove').attr('move')+"]").remove();
                        $.ajax({  
                            type: 'POST',  
                            url: "{{URL('/stergecomanda')}}", 
                            data: 
                                { 
                                    id:$("#yesmove").attr("move")
                                },
                            success: function() {
                            }
                        });
                    });
                </script>
            @else
                <h1 class="text-center calibri">Nu sunt cumparaturi</h1>
            @endif
        </div>
        <script>
            $(document).ready(function(){
                $("#changepassword").on("click",function(){
                    $("#parolaveche").css("border-color","#ccc");
                    $("#password").css("border-color","#ccc");
                    $("#repeatpassword").css("border-color","#ccc");
                    $.ajax({
                        type:"post",
                        url:"{{URL('/profil')}}",
                        data:{
                            parolaveche:$("#parolaveche").val(),
                            password:$("#password").val(),
                            repeatpassword:$("#repeatpassword").val()
                        },
                        success:function(data){
                            if(data===true){
                                alert("Parola a fost schimbata");
                                location.reload();
                            }else{
                                if(data["parolaveche"]){
                                    $("#parolaveche").css("border-color","red");
                                }
                                if(data["password"]){
                                    $("#password").css("border-color","red");
                                }
                                if(data["repeatpassword"]){
                                    $("#repeatpassword").css("border-color","red");
                                }
                            }
                        }
                    });

                });
                $('#submit').on("click",function (e) {
                    e.stopPropagation();
                    $.ajax({
                        type:"post",
                        url:"{{URL('/changenameuser')}}",
                        data:{
                            name:$("#name").val(),
                            email:$("#email").val()
                        },
                        success:function(){
                            alert("Numele a fost schimbat");
                            location.reload();
                        }
                    });
                });
            });
        </script>
    @else
        <h1 class="text-center calibri">OPS , A aparut o eroare</h1>
    @endif
</div>
@endsection