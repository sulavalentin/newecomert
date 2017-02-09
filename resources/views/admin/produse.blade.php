@extends("admin.base")
@section("content")
    @if(!empty($items))
    <div class="content">
        <ul class="menuitems" id="menuitems">
            @foreach($items as $key => $submenu)
                <h1 class="den_menu">{{$key}}</h1>
                    @foreach($submenu as $k => $itemssubmenu)
                        <li class="submenu_items">
                            <b>{{$k}}</b>
                        </li>
                        <ul>
                            @foreach($itemssubmenu as $i)
                            <a href="{{URL("admin/getproducts/".$i->id)}}"/>
                                <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                                    @if(!empty($i->item_image))
                                        <img src="{{ asset($i->item_image) }}" class="img-responsive"/>
                                    @else
                                        <img src="{{ asset('img/products/default.jpg') }}" class="img-responsive"/>
                                    @endif
                                    {{$i->item_name}}
                                </li>
                            </a>
                            @endforeach 
                        </ul>
                    @endforeach
            @endforeach
        </ul>
    </div>
    @else
    @endif
@endsection