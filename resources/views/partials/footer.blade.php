<div class="container">
    <div class="row">
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
                <li>
                    <a href="#">Despre noi</a>
                </li>
            </ul>
        </div>
        <div class="col-md-2">
            <ul class="footerlist">
                <li>
                    <b>Altele</b>
                </li>
                <li>
                    <form action="{{URL('search')}}">
                        <input type="text" name="search" placeholder="Cauta"/>
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
    </div>
</div>