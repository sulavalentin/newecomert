<Style>
    .previewcauta{
        width: 100%;
        height: 100%;
        position: fixed;
        bottom: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.2);
        z-index: 3;
        display: none;
    }
    .cautafrumos{
        z-index: 100;
        position: relative;
    }
</style>
<form class="form-cauta cautafrumos" action="{{URL("search")}}">
    <input type="text" id="search" name="search" placeholder="Cauta" autocomplete="off"/>
    <button type="submit" id="cauta">
        <span class="glyphicon glyphicon-search"></span>
    </button>
</form>
<div class='searchresult' id="searchresult">
    <ul class='listitemsresult' id='itemssearch'>
    </ul>
</div>
<div class="previewcauta" id="previewcauta"></div>
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
        }
    });
    $("#previewcauta").on("click",function(){
        $("#searchresult").css("display","none");
        $("#previewcauta").hide();
    });
    $("#search").on("click",function(e){
        $("#searchresult").css("display","block");
        $("#previewcauta").show();
    });
</script>