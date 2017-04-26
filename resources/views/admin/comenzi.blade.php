@extends("admin.base")
@section("content")
<div class="content">
    @if(!empty($comenzi) && count($comenzi)>0)
        @foreach($comenzi as $i)
        <div class="comenzidiv" idmoved="{{$i["nume"]["id"]}}">
            <b style="color:gray;">
                #{{$i["nume"]["id"]}}
                @if($i["nume"]["new"]==1)
                <button class="btn btn-xs btn-danger">Nou</button>
                @endif
            </b>
            <button class="btn btn-danger btn-xs pull-right" 
                    style="margin-bottom:15px;" 
                    id="{{$i["nume"]["id"]}}"
                    name="trececomanda">
                Trece comanda la toate comenzile
            </button>
            <table class="table">
                <tr>
                    <td><b>Beneficiar:</b></td>
                    <td>
                        {{$i["nume"]["nume"]}} ,
                        Email ( {{$i["nume"]["email"]}} ) ,
                        Telefon ( {{$i["nume"]["telefon"]}} )
                    </td>
                </tr>
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
                  <h4 class="modal-title text-center">Trece comanda ca finalizata</h4>
                </div>
                <div class="modal-body text-center">
                    <h3 class="calibri text-danger" style="margin: 0px 0px 15px 0px;">
                        !Comenzile nu pot fi sterse , comanda va fi trecuta in tabela cu comenzi finalizate
                    </h3>
                    <h3 class="calibri">Sigur aceasta comanda a fost finalizata?</h3>
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
                url: "{{URL('/admin/movecomanda')}}", 
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
    <h1 class="text-center calibri">Nu sunt comenzi</h1>
    @endif
</div>
@endsection