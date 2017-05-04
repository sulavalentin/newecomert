<ul class="cos">
    <a href="{{URL("/cart")}}">
        <li class="col-md-4 col-sm-4 col-xs-4">
            <span>
                <img src="{{asset("img/system/cart.png")}}"/><br>
                Cos
            </span>
            <span class="badge countproducts" id="carcount">
                <?php 
                    echo App\Cart::getCountCart();
                ?>
            </span>
        </li>
    </a>
    <a href="{{URL("/favorite")}}">
        <li class="col-md-4 col-sm-4 col-xs-4">
            <span>
                <img src="{{asset("img/system/favorite.png")}}"/><br>
                Favorite
            </span>
            <span class="badge countproducts" id="favoritecount">
                <?php 
                    echo App\Favorite::getCountFavorite();
                ?>
            </span>
        </li>
    </a>
    <a href="{{URL("/compare")}}">
        <li class="col-md-4 col-sm-4 col-xs-4">
            <span>
                <img src="{{asset("img/system/compare.png")}}"/><br>
                Compara
            </span>
            <span class="badge countproducts" id="comparecount">
                {{count(session('idcompare'))}}
            </span>
        </li>
    </a>
</ul>