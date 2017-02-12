@extends("admin.base")
@section("content")
<div class="homepage">
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
        <a href="{{URL("/admin/products")}}">
            <div class="produsehome">
                <p class="imagehome">
                    <img src="{{asset("img/homepage/productshome.png")}}" class="img-responsive"/>
                </p>
                <h3 class="text-center">Produse</h3>
                <h1 class="text-center">{{$countproducts}}</h1>
            </div>
        </a>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
        <a href="{{URL("/admin/tables")}}">
            <div class="tabelehome">
                <p class="imagehome">
                    <img src="{{asset("img/homepage/tabelehome.png")}}" class="img-responsive"/>
                </p>
                <h3 class="text-center">Tabele</h3>
                <h1 class="text-center">{{$counttabele}}</h1>
            </div>
        </a>
    </div>
</div>
@endsection
