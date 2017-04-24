@extends("admin.base")
@section("content")
    @if(!empty($items))
    <div class="content">
        <ul class="menuitems" id="menuitems">
            @foreach($items as $key => $submenu)
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1 class="den_menu">
                        {{$key}}
                    </h1>
                </div>
                <div class="panel-body">
                    @foreach($submenu as $k => $itemssubmenu)
                        <li class="submenu_items">
                            <b>{{$k}}</b>
                        </li>
                        <ul>
                            @foreach($itemssubmenu as $i)
                            <a href="{{URL("admin/products/".$i->id)}}"/>
                                <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                                    @if(\File::exists($i->item_image))
                                        <img src="{{ asset($i->item_image) }}" class="img-responsive"/>
                                    @else
                                        <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive"/>
                                    @endif
                                    {{$i->item_name}}
                                </li>
                            </a>
                            @endforeach 
                        </ul>
                    @endforeach
                </div>
            </div>
            @endforeach
        </ul>
    </div>
    @endif
@endsection