@extends('base')
@section('content')
    @if(!empty($return) && $return["count"]>0)
    <div style="width:100%; float:left; margin-top:20px;">
        <div class="col-md-7">
            <form id="formcomanda" method="post">
                <div class="form-group col-md-6">
                    <label>Nume:</label>
                    <input type="text" class="form-control" name="nume" autocomplete="off" max="100">
                </div>
                <div class="form-group col-md-6">
                    <label>Prenume:</label>
                    <input type="text" class="form-control" name="prenume" max="100" autocomplete="off">
                </div>
                <div class="form-group col-md-12">
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email" max="100" autocomplete="off">
                </div>
                <div class="form-group col-md-12">
                    <label>Telefon:</label>
                    <input type="text" class="form-control" name="telefon" max="100" autocomplete="off">
                </div>
                <div class="form-group col-md-12">
                    <label>Adresa:</label>
                    <input type="text" class="form-control" name="adresa" max="100" autocomplete="off">
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-default">
                        Finalizeaza comanda
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-5">
            <p class="produseincos">Produse in cos</p>
            @foreach($return["produse"] as $i)
                <a href="{{URL("product/".$i->id)}}">
                    <p class="namecos">
                        {{$i->originalname}}{{$i->name}}
                    </p>
                </a>
                <p class="cantitatepret">
                    {{$i->cantitate}}
                    x
                    {{number_format($i->price, 2, '.', ' ')}}
                    <span>Lei</span>
                </p>
            @endforeach
            <p class="produseincos">Suma totala:</p>
            <p class="totalpricecart">
                {{number_format($return["sumatotala"], 2, '.', ' ')}} Lei
            </p>
        </div>
    </div>
    <script>
        $("input[name=telefon]").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        $("#formcomanda").on("submit",function(e){
            e.preventDefault();
            $("input[name=nume]").css("border-color","#ccc");
            $("input[name=prenume]").css("border-color","#ccc");
            $("input[name=email]").css("border-color","#ccc");
            $("input[name=telefon]").css("border-color","#ccc");
            $("input[name=adresa]").css("border-color","#ccc");
            var nume=$("input[name=nume]").val();
            var prenume=$("input[name=prenume]").val();
            var email=$("input[name=email]").val();
            var telefon=$("input[name=telefon]").val();
            var adresa=$("input[name=adresa]").val();
            var trecut=true;
            if(adresa.length===0){
                $("input[name=adresa]").css("border-color","red");
                $("input[name=adresa]").focus();
                trecut=false;
            }
            if(telefon.length===0){
                $("input[name=telefon]").css("border-color","red");
                $("input[name=telefon]").focus();
                trecut=false;
            }
            if(email.length===0){
                $("input[name=email]").css("border-color","red");
                $("input[name=email]").focus();
                trecut=false;
            }
            if(prenume.length===0){
                $("input[name=prenume]").css("border-color","red");
                $("input[name=prenume]").focus();
                trecut=false;
            }
            if(nume.length===0){
                $("input[name=nume]").css("border-color","red");
                $("input[name=nume]").focus();
                trecut=false;
            }
            if(trecut===true){
                
            }
        });
    </script>
    @else
        <h1 class='text-center'>Cos gol</h1>
    @endif
@endsection