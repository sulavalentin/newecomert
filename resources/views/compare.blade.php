@extends('base')
@section('content')
<div class='container'>
    <div class="row">   
        @if(!empty($compare) && count($compare)>0)
        <style>
            .width{
                <?php $width=100/(count($compare)+1);
                      $colspan=count($compare)+1;
                    echo "width:$width%;";
                ?>
            }
            h1{
                margin-top:5px;
            }
            .fontsize{
                font-size:16px;
            }
        </style>
            <h1 class='text-center calibri'>Compara produse</h1>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td class="width">
                            <b>Produse<b>
                        </td>
                        @foreach($compare as $i)
                            <td class="width">
                                <div>
                                    <a href="{{URL("/product/".$i->id)}}">
                                        @if(\File::exists($i->address))
                                            <img  src="{{asset($i->address)}}" class="img-responsive" style="max-height: 200px;"/>
                                        @else
                                            <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive" style="max-height: 200px;"/>
                                        @endif
                                    </a>
                                </div>
                                <a class="NumeProduct" href="{{URL("/product/".$i->id)}}">
                                    <p title="{{$i->originalname}}{{$i->name}}" class="comparename">
                                        {{$i->originalname}}{{$i->name}}
                                    </p>
                                </a>
                                <p class="price calibri">
                                    {{number_format(floor($i->price), 0, '.', ' ')}}
                                    <sup class="price_dec">
                                        ,{{str_replace("0.","",(string)number_format(round($i->price - (int)$i->price,2),2))}}
                                    </sup>
                                    <span>Lei</span>
                                </p>
                                <button class="addcart" name="addcart" prod="{{$i->id}}">
                                    <span class="glyphicon glyphicon-shopping-cart"></span>
                                    Adauga in cos
                                </button>
                                <a class="btn btn-default btn-sm pull-right btn-block" style="margin-top:5px;" name="stergecompare" compare="{{$i->id}}">
                                    <span class="glyphicon glyphicon-remove text-danger"></span>
                                    Sterge
                                </a>
                            </td>
                        @endforeach
                    </tr>
                    @if(!empty($specificationsname) && count($specificationsname)>0)
                        @foreach($specificationsname as $key=>$i)
                            <tr>
                                <td class='width text-center' colspan="{{$colspan}}">
                                    <b>{{$key}}</b>
                                </td>
                            </tr>
                            @foreach($i as $key1=>$i1)
                                <tr>
                                    <td class="width">
                                        <b>{{$key1}}</b>
                                    </td>
                                    @foreach($cantitate as $i2)
                                        <td class="width calibri fontsize">
                                            @if(!empty($i1[$i2]->value) && $i1[$i2]->value!=null)
                                                {{$i1[$i2]->value}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </table>
            </div>
            @include('partials.addcart')
            @include('partials.scriptcart')
            <script>
                $("a[name=stergecompare]").on("click",function(){
                    var id=$(this).attr("compare");
                    $.ajax({
                        type:"post",
                        url:"{{URL('deletecompare')}}",
                        data:{
                            id:id
                        },
                        success:function(){
                            location.reload();
                        }
                    });
                });
            </script>
        @else
            <h1 class="calibri text-center">Nu aveti produse care trebuie comparate</h1>
        @endif
    </div>
</div>
@endsection