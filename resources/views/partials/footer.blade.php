<div class="container text-center">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <ul class="footerlist">
                <li>
                    <b>Generale</b>
                </li>
                <li>
                    <a href="{{URL('/')}}">Acasa</a>
                </li>
                <li>
                    <a href="{{URL('helpbuy')}}">Cum cumpar?</a>
                </li>
                <li>
                    <a href="{{URL('contact')}}">Contact</a>
                </li>
            </ul>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-2">
            <ul class="footerlist">
                <li>
                    <b>Altele</b>
                </li>
                <li>
                    <form action="{{URL('search')}}">
                        <input type="text" name="search" placeholder="Cauta" class="text-center"/>
                    </form>
                </li>
                <li>
                    <a href="{{URL('cart')}}">Cos</a>
                </li>
                <li>
                    <a href="{{URL('favorite')}}">Favorite</a>
                </li>
                <li>
                    <a href="{{URL('compare')}}">Compara</a>
                </li>
            </ul>
        </div>
        <div class="col-md-2"></div>
        @if(!empty(Session('menu')))
            <div class="col-md-2">
                <ul class="footerlist">
                    <li>
                        <b>Categorii</b>
                    </li>
                    @foreach(Session('menu') as $i)
                        <li>
                            <a href="{{URL('menu/'.$i->id)}}">
                                {{$i->menu_name}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>