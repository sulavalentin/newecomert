<ul class="cos">
    <a href="{{URL("/cart")}}">
        <li class="col-md-4">
            <span>
                <img src="{{asset("img/system/cart.png")}}"/><br>
                Cos
            </span>
            <span class="badge countproducts" id="carcount">
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
                    $(window).on("load", function() {
                        countcart();
                    });
                </script>
            </span>
        </li>
    </a>
    <li class="col-md-4">
        <span>
            <img src="{{asset("img/system/favorite.png")}}"/><br>
            Favorite
        </span>
        <span class="badge countproducts" id="favcount">
            0
        </span>
    </li>
    <li class="col-md-4">
        <span>
            <img src="{{asset("img/system/compare.png")}}"/><br>
            Compara
        </span>
    </li>
</ul>