<ul class="cos">
    <a href="{{URL("/cart")}}">
        <li class="col-md-4">
            <span>
                <img src="{{asset("img/system/cart.png")}}"/><br>
                Cos
            </span>
            <span class="badge countproducts" id="carcount">
                0
            </span>
        </li>
    </a>
    <a href="{{URL("/favorite")}}">
        <li class="col-md-4">
            <span>
                <img src="{{asset("img/system/favorite.png")}}"/><br>
                Favorite
            </span>
            <span class="badge countproducts" id="favoritecount">
                0
            </span>
        </li>
    </a>
    <li class="col-md-4">
        <span>
            <img src="{{asset("img/system/compare.png")}}"/><br>
            Compara
        </span>
    </li>
</ul>
<script>
    function countcart(){
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/getCountCart')}}", 
            success: function(data) {
                $("#carcount").html(data);
            }
        }); 
    }
    function countfavorite(){
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/getCountFavorite')}}", 
            success: function(data) {
                $("#favoritecount").html(data);
            }
        });
    }
    $(window).on("load", function() {
        countcart();
        countfavorite();
    });
</script>