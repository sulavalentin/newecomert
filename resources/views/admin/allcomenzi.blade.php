@extends("admin.base")
@section("content")
<div class="content">
    @if(!empty($comenzi) && count($comenzi)>0)
        @foreach($comenzi as $i)
        <div class="comenzidiv" idmoved="{{$i["nume"]["id"]}}">
            <b style="color:gray;">#{{$i["nume"]["id"]}}</b>
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
        {{ $comenzi->links() }}
    @else
    <h1 class="text-center calibri">Nu sunt comenzi</h1>
    @endif
</div>
@endsection