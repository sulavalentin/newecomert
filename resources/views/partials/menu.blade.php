<div id="menu">
    {{App\Menu::menu()}}
    @if(!empty(Session('menu')))
        <div class="dropdown">
            <span class="produse dropdown-toggle" data-toggle="dropdown">
                <button class="btn btn-default" style="outline:0">
                    <span class="fa fa-bars" style="font-size:23px;"></span>
                    <span class="glyphicon glyphicon-chevron-down"></span>
                    Meniu
                </button>
            </span>
            <div class="dropdown-menu">
                <ul class="first_menu" id="first_menu">
                    @foreach(Session('menu') as $i)
                        <li class="component_first" id="m{{$i->id}}">
                            <a class="link">{{$i->menu_name}}</a>
                        </li> 
                        <div class="sub-menu" id="m{{$i->id}}s">
                            @if(!empty(Session('submenu')))
                                <ul class="secundary_menu">
                                    <a>
                                        <li name="back">
                                            <b style="color:red;">
                                                <span class="glyphicon glyphicon-arrow-left"></span>
                                                Inapoi la {{$i->menu_name}}
                                            </b>
                                        </li>
                                    </a>
                                    @foreach(Session('submenu') as $j)
                                        @if($j->menu_id==$i->id)
                                            <li>
                                                <a href="{{URL("/submenu/".$j->id)}}">
                                                    <b>{{$j->submenu_name}}</b>
                                                </a>
                                            </li>
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
        $(".sub-menu").removeClass("active");
    });
    $('li[name=back]').on("click",function()
    {
        $(".sub-menu").removeClass("active");
    });
    $('.component_first').on("click",function()
    { 
        var id=$(this).attr("id");
        $(".sub-menu").removeClass("active");
        $("#"+id+"s").addClass("active");
    });
    
    $(document).ready(function(){
        $('.dropdown-menu').click(function (e) {
            e.stopPropagation();
        });
    });
</script>