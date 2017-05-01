<div id="menu">
    {{App\Menu::menu()}}
    @if(!empty(Session('menu')))
        <div class="dropdown">
            <span class="produse dropdown-toggle" data-toggle="dropdown" aria-expanded="false" >
                <div class="menubutton">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
            </span>
            <div class="dropdown-menu">
                <ul class="first_menu" id="first_menu">
                    @foreach(Session('menu') as $i)
                        <li class="component_first" id="m{{$i->id}}">
                            <a class="link">
                                <img src="{{asset('img/system/list_menu.png')}}"/>
                                {{$i->menu_name}}
                            </a>
                        </li> 
                        <div class="sub-menu" id="m{{$i->id}}s">
                            @if(!empty(Session('submenu')))
                                <ul class="secundary_menu">
                                    <a>
                                        <li name="back" class="nopadding">
                                            <b style="color:red;">
                                                <span class="glyphicon glyphicon-arrow-left"></span>
                                                {{$i->menu_name}}
                                            </b>
                                        </li>
                                    </a>
                                    @foreach(Session('submenu') as $j)
                                        @if($j->menu_id==$i->id)
                                            <a href="{{URL("/submenu/".$j->id)}}">
                                                <li class="nopadding">
                                                    <b>{{$j->submenu_name}}</b>
                                                </li>
                                            </a>
                                        @if(Session('items'))
                                                @foreach(Session('items') as $k)
                                                    @if($j->id==$k->submenu_id)
                                                    <a href="{{URL("sort=priceUp/[".$k->id."]-".$k->item_name."/page=1")}}">
                                                        <li>{{$k->item_name}}</li>
                                                    </a>
                                                @else
                                                    @continue;
                                                @endif
                                            @endforeach
                                        @endif
                                        @else
                                            @continue;
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        
                    @endforeach
                </ul>     
           </div>
       </div>
    @endif  
</div>
<script>
    $("#menu").on("click",function(){
        $(".sub-menu").css("display","none");
        $(".sub-menu .secundary_menu").css("right","-250px");
    });
    $('li[name=back]').on("click",function()
    {
        $(".sub-menu").fadeOut().find("ul").animate({"right":-250}, 200);
    });
    $('.component_first').on("click",function()
    { 
        var id=$(this).attr("id");
        $(".sub-menu").fadeOut().find("ul").animate({"right":-250}, 200);
        $("#"+id+"s").fadeIn().find("ul").animate({"right":-220}, 200);
        
    });
    
    $(document).ready(function(){
        $('.dropdown-menu').click(function (e) {
            e.stopPropagation();
        });
    });
</script>