<form class="form-cauta" action="{{URL("search")}}">
    <input type="text" id="search" name="search" placeholder="Cauta" autocomplete="off"/>
    <button type="submit" id="cauta">
        <span class="glyphicon glyphicon-search"></span>
    </button>
</form>
<div class='searchresult' id="searchresult">
    <ul class='listitemsresult' id='itemssearch'>
        <li class="text-center">Cauta</li>
    </ul>
</div>
<script>
    $("#search").on("keyup",function(){
        var search=$("#search").val();
        search=search.replace(/  +/g, ' ');
        if(search.length>=1){
            $.ajax({  
                type: 'POST',  
                url: "{{URL('/searchajax')}}", 
                data: 
                    { 
                        search:search
                    },
                success: function(data) {
                    $("#searchresult").css("display","block");
                    if(data.length>0){
                        $("#itemssearch").text("");
                        $.each(data, function( index, value ) {
                            $("#itemssearch").append("<a href='{{URL('/product')}}/"+value.id+"'>\
                                                        <li>"+value.originalname+value.name+"</li>\n\
                                                    </a>");
                            });
                    }else{
                        $("#itemssearch").text("");
                        $("#itemssearch").append("<li>Nu s-a gasit nimic pentru '"+search+"'</li>");
                    }
                }
            });
        }else{
            $("#itemssearch").text("");
            $("#itemssearch").append("<li>Cauta</li>");
        }
    });
    $("body").on("click",function(){
        $("#searchresult").css("display","none");
    });
    $(".form-cauta , #search , #cauta").on("click",function(e){
        e.stopPropagation();
        $("#searchresult").css("display","block");
    });
</script>