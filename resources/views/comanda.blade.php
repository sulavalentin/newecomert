@extends('base')
@section('content')
    @if(!empty($return) && $return["count"]>0)
    <div style="width:100%; float:left; margin-top:20px;">
        <div class="col-md-7">
            <form id="formcomanda" method="post">
                @if(!empty($return["profil"]) && count($return["profil"])>0)
                    <div class="form-group col-md-12">
                        <label>Nume:</label>
                        <input type="text" class="form-control" name="numec" autocomplete="off" max="100" value="{{$return["profil"]->name}}">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Email:</label>
                        <input type="email" class="form-control" name="emailc" autocomplete="off" value="{{$return["profil"]->email}}">
                    </div>
                @else
                    <div class="form-group col-md-12">
                        <label>Nume:</label>
                        <input type="text" class="form-control" name="numec" autocomplete="off" max="100">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Email:</label>
                        <input type="email" class="form-control" name="emailc" autocomplete="off">
                    </div>
                @endif
                <div class="form-group col-md-12">
                    <label>Telefon:</label>
                    <input type="text" class="form-control" name="telefonc" max="100" autocomplete="off">
                </div>
                <div class="form-group col-md-12">
                    <label>Adresa:</label>
                    <input type="text" class="form-control" name="adresac" max="100" autocomplete="off">
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" id="final" class="btn btn-default" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Se finalizeaza comanda">
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
        $("input[name=telefonc]").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        $("#formcomanda").on("submit",function(e){
            e.preventDefault();
            $("input[name=numec]").css("border-color","#ccc");
            $("input[name=emailc]").css("border-color","#ccc");
            $("input[name=telefonc]").css("border-color","#ccc");
            $("input[name=adresac]").css("border-color","#ccc");
            var nume=$("input[name=numec]").val();
            var email=$("input[name=emailc]").val();
            var telefon=$("input[name=telefonc]").val();
            var adresa=$("input[name=adresac]").val();
            var trecut=true;
            if(adresa.length===0){
                $("input[name=adresac]").css("border-color","red");
                $("input[name=adresac]").focus();
                trecut=false;
            }
            if(telefon.length===0){
                $("input[name=telefonc]").css("border-color","red");
                $("input[name=telefonc]").focus();
                trecut=false;
            }
            if(email.length===0){
                $("input[name=emailc]").css("border-color","red");
                $("input[name=emailc]").focus();
                trecut=false;
            }
            if(nume.length===0){
                $("input[name=numec]").css("border-color","red");
                $("input[name=numec]").focus();
                trecut=false;
            }
            if(trecut===true){
                $("#final").button("loading");
                $.ajax({  
                    type: 'POST',  
                    url: "{{URL('/endcomanda')}}", 
                    data: 
                        { 
                            nume:nume,
                            email:email,
                            telefon:telefon,
                            adresa:adresa
                        },
                    success: function(data) {
                        location.href = "{{URL('/comandatrimisa')}}";
                    }
                });
            }
        });
    </script>
    @else
        <h1 class='text-center'>Cos gol</h1>
    @endif
@endsection