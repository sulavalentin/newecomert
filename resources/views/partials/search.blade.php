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
    $("#search").on("change",function(){
        alert("123");
    });
</script>