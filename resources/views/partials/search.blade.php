<form class="form-cauta" action="{{URL("search")}}">
    <input type="text" id="search" name="search" placeholder="Cauta" autocomplete="off"/>
    <button type="submit" id="cauta">
        <span class="glyphicon glyphicon-search"></span>
    </button>
</form>
<div class='searchresult'>
    <ul class='listitemsresult' id='itemssearch'>
        <a href='#'>
            <li>
                INTEL Celeron G3900 , LGA 1151 , 2,8 GHz , 2 Mb , 51 W , Intel HD Graphics 510
            </li>
        </a>
    </ul>
</div>
<script>
    $("#search").on("keyup",function(){
        var search=$("#search").val();
        search=search.replace(/  +/g, ' ');
        if(search.length>=2){
            $.ajax({  
                type: 'POST',  
                url: "{{URL('/searchajax')}}", 
                data: 
                    { 
                        search:search
                    },
                success: function(data) {
                    if(data.length>0){
                        $("#itemssearch").text("");
                        $.each(data, function( index, value ) {
                             $("#itemssearch").append("<a href='{{URL('product/1')}}'>\
                                                            <li>"+value.originalname+value.name+"</li>\n\
                                                        </a>\n\
                                                        ");
                        });
                    }else{
                        $("#itemssearch").text("");
                        $("#itemssearch").append("<li>Nu s-a gasit nimic pentru '"+search+"'</li>");
                    }
                }
            });
        }
    });
</script>