<script>
$(document).ready(function() {
    $("button[name=addcart]").on("click",function(){
        $("#fullpageload").show();
        var idprod=$(this).attr("prod");
        $("button[name=addcart]").prop('disabled', true);
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/addcart')}}", 
            data: 
                { 
                  id:idprod
                },
            success: function(data) {
                $("button[name=addcart]").removeAttr('disabled');
                $("#carcount").html(data[0]);
                $("#nameCart").html(data[1].originalname+data[1].name);
                $("#imgcart").attr("src","{{asset('/')}}"+data[1].address);
                $("#fullpageload").hide();
                $("#cosAdded").modal();
            }
        });
    });
    $("button[name=addfavorite]").on("click",function(){
        $("#fullpageload").show();
        var idprod=$(this).attr("prod");
        $("button[name=addfavorite]").prop('disabled', true);
        var thisspan=$(this).find("span");
        $.ajax({  
            type: 'POST',  
            url: "{{URL('/addfavorite')}}", 
            data: 
                { 
                  id:idprod
                },
            success: function(data) {
                if(data===false){
                    $("#login").modal();
                    $("#fullpageload").hide();
                }else{
                    if(data===0){
                        $("#fullpageload").hide();
                        thisspan.removeClass("icon-heart").addClass("icon-heart-empty");
                    }else{
                        $("#favoritecount").html(data[0]);
                        $("#nameFavorite").html(data[1].originalname+data[1].name);
                        $("#imgfavorite").attr("src","{{asset('/')}}"+data[1].address);
                        $("#favoriteAdded").modal();
                        $("#fullpageload").hide();
                        thisspan.removeClass("icon-heart-empty").addClass("icon-heart");
                    }
                }
                $("button[name=addfavorite]").removeAttr('disabled'); 
            }
        });
    });
});
</script>