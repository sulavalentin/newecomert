@extends('base')
@section('content')
    @if(!empty($products) && count($products)>0)
        <table id="cart" class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:10%">Pret</th>
                    <th style="width:8%">Cantitate</th>
                    <th style="width:22%" class="text-center">Pret total</th>
                    <th style="width:10%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $i)
                    <tr id="{{$i->id}}">
                        <td>
                            <div class="row">
                                <div class="col-sm-2 col-xs-2">
                                    <a href="{{URL("product/".$i->id)}}">
                                        @if(\File::exists($i->address))
                                            <img  src="{{asset($i->address)}}" class="img-responsive"/>
                                        @else
                                            <img src="{{ asset('img/products/default.jpg') }}" class="img-responsive"/>
                                        @endif
                                    </a>
                                </div>
                                <div class="col-sm-9">
                                    <a href="{{URL("product/".$i->id)}}" style="color:#555555">
                                        <p>{{$i->originalname}}{{$i->name}}</p>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td data-th="Pret:">
                            {{number_format($i->price, 2, '.', ' ')}}
                            <span>Lei</span>
                        </td>
                        <td data-th="Cantitate:">
                            <input type="number" class="form-control text-center" name="cantitate" idcant="{{$i->id}}" value="{{$i->cantitate}}">
                        </td>
                        <td data-th="Pret total:" class="text-center">
                            <span id="priceone{{$i->id}}">
                                {{number_format($i->total, 2, '.', ' ')}}
                            </span>
                            <span>Lei</span>
                        </td>
                        <td class="actions">
                            <button class="cumpara_acum">
                                Cumpara acum
                            </button>
                            <button class="btn btn-link btn-sm" del="{{$i->id}}" name="delfromcart">
                                <span class="text-danger">
                                    <span class="glyphicon glyphicon-trash"></span>
                                    Sterge din cos
                                </span>
                            </button>								
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <a href="{{URL("/")}}" class="btn btn-warning">
                            <i class="fa fa-angle-left"></i> 
                            Continua cumparaturile
                        </a>
                    </td>
                    <td colspan="2" class="hidden-xs"></td>
                    <td class="text-center"><strong>Total: <span id="total"></span> Lei</strong></td>
                    <td>
                        <a href="#" class="btn btn-success btn-block">
                            Cumpara 
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
    @else
        <h1 class='text-center'>Cos gol</h1>
    @endif
    <script>
        function totalprice(){
            $.ajax({  
                type: 'POST',  
                url: "{{URL('/totalprice')}}", 
                success: function(data) {
                    console.log(data);
                    $("#total").html(data);
                    if(data==0){
                        $("#cart").html("<h1 class='text-center'>Cos gol</h1>")
                    }
                }
            });
        }
        totalprice();
        $("input[name=cantitate]").on("change",function(){
            var id=$(this).attr("idcant");
            var cantitate=$(this).val();
            var input=$(this);
            $("#fullpageload").show();
            $.ajax({  
                type: 'POST',  
                url: "{{URL('/updatecart')}}", 
                data: 
                    { 
                      id:id,
                      cantitate:cantitate
                    },
                success: function(data) {
                    countcart();
                    totalprice();
                    input.val(data[0].cantitate);
                    $("#priceone"+id).html(data[0].totalone)
                    $("#fullpageload").hide();
                }
            });
            
        });
        $("button[name=delfromcart]").on("click",function(){
            var idprod=$(this).attr("del");
            $("#fullpageload").show();
            $.ajax({  
                type: 'POST',  
                url: "{{URL('/delcart')}}", 
                data: 
                    { 
                      id:idprod
                    },
                success: function() {
                    $("#"+idprod).remove();
                    countcart();
                    totalprice();
                    $("#fullpageload").hide();
                }
            });
        });
    </script>
@endsection