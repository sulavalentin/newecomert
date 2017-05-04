@extends("admin.base")
@section("content")
<style>
    .badge{
       background-color: #e23939;
    }
    .badgeblue{
       background-color: #00ad25;
    }
</style>
<p class="text-right text-warning">
    <?php
        $views=App\Logo::getviews();
    ?>
    <span id="total">
        @if(!empty($views) && count($views)>0)
            Total: {{$views->valuevariable}} views
        @else
            Total: 0 views
        @endif
    </span>
    <span id="time"></span>
</p>
<div class="homepage">
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
            <li class="active">
                <a href="{{URL('/admin')}}">
                    <i class="fa fa-home fa-fw"></i>
                    Acasa
                </a>
            </li>
            <li>
                <a href="{{URL('/')}}" target="_blank">
                    <i class="fa fa-check fa-fw"></i>
                    Vezi siteul
                    <span class="badge">
                        <i class="fa fa-arrow-right"></i>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{URL('/admin/comenzi')}}">
                    <i class="fa fa-money fa-fw"></i>
                    Comenzi
                    <span class="badge">{{$countcomenzi}}</span>
                </a>
            </li>
            <li>
                <a href="{{URL('/admin/contact')}}">
                    <i class="fa fa-volume-control-phone fa-fw"></i>
                    Contact
                    <span class="badge">{{$countcontact}}</span>
                </a>
            </li>
            <li>
                <a href="{{URL('/admin/coments')}}">
                    <i class="fa fa-comment fa-fw"></i>
                    Comentarii
                    <span class="badge">{{$countcomentarii}}</span>
                </a>
            </li>
            <li>
                <a href="{{URL('/admin/menu')}}">
                    <i class="fa fa-bars fa-fw"></i>
                    Meniu
                </a>
            </li>
            <li>
                <a href="{{URL('/admin/slideshow')}}">
                    <i class="fa fa-slideshare fa-fw"></i>
                    Slideshow
                    <span class="badge badgeblue">Total {{$countslideshow}}</span>
                </a>
            </li>
            
            <li>
                <a href="{{URL('/admin/utilizatori')}}">
                    <i class="fa fa fa-user fa-fw"></i>
                    Utilizatori
                    <span class="badge badgeblue">Total {{$countusers}}</span>
                </a>
            </li>
            <li>
                <a href="{{URL('/admin/admins')}}">
                    <i class="fa fa-male fa-fw"></i>
                    Admini
                    <span class="badge badgeblue">Total {{$countadmins}}</span>
                </a>
            </li>
            <li>
                <a href="{{URL('/admin/products')}}">
                    <i class="fa fa-file-o fa-fw"></i>
                    Produse
                    <span class="badge badgeblue">Total {{$countproducts}}</span>
                </a>
            </li>
            <li>
                <a href="{{URL('/admin/logo')}}">
                    <i class="fa fa-list-alt fa-fw"></i>
                    Logo
                </a>
            </li>
            <li>
                <a href="{{URL('/admin/tables')}}">
                    <i class="fa fa-table fa-fw"></i>
                    Tabele
                    <span class="badge badgeblue">Total {{$counttabele}}</span>
                </a>
            </li>
            <li>
                <a href="{{URL('/admin/allcomenzi')}}">
                    <i class="fa fa-unlock-alt fa-fw"></i>
                    Toate comenzile
                    <span class="badge badgeblue">Total {{$countallcomenzi}}</span>
                </a>
            </li>
            <li>
                <a href="{{URL('admin/profil')}}">
                    <i class="fa fa-cogs fa-fw"></i>
                    Setari
                </a>
            </li>
            <li>
                <a href="{{URL('exitadmin')}}">
                    <i class="fa fa-sign-out fa-fw"></i>
                    Iesire
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-5">
        @if(!empty($comandate) && count($comandate)>0)
            <h4 class="calibri">Ultimele produse comandate ({{count($comandate)}})</h4>
            <table class="table">
                @foreach($comandate as $i)
                <tr>
                    <td style="width: 70px;">
                        <a href="{{URL('product/'.$i->id_produs)}}" target="_blank">
                            @if(\File::exists($i->address))
                                <img src="{{ asset($i->address) }}" class="img-responsive"/>
                            @else
                                <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive" />
                            @endif
                        </a>
                    </td>
                    <td>
                        <a href="{{URL('product/'.$i->id_produs)}}" target="_blank">
                            {{$i->originalnameprodus}}{{$i->nameprodus}}
                        </a>
                    </td>
                    <td class="text-center">
                        {{$i->priceprodus}} Lei
                    </td>
                    <td>
                        {{date('d/m/Y', strtotime($i->created_at))}}
                    </td>
                </tr>
                @endforeach
            </table>
        @endif
    </div>
    <div class="col-md-4">
        <!--Cele mai vandute -->
        @if(!empty($vandute) && count($vandute)>0)
            <h4 class="calibri">Cele mai vandute produse ({{count($vandute)}})</h4>
            <table class="table">
                @foreach($vandute as $i)
                <tr>
                    <td style="width: 70px;">
                        <a href="{{URL('product/'.$i->id_produs)}}" target="_blank">
                            @if(\File::exists($i->address))
                                <img src="{{ asset($i->address) }}" class="img-responsive"/>
                            @else
                                <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive" />
                            @endif
                        </a>
                    </td>
                    <td>
                        <a href="{{URL('product/'.$i->id_produs)}}" target="_blank">
                            {{$i->originalnameprodus}}{{$i->nameprodus}}
                        </a>
                    </td>
                    <td class="text-center">
                        {{$i->vandut}} ori
                    </td>
                </tr>
                @endforeach
            </table>
        @endif
        <!--Cele mai populare -->
        @if(!empty($populars) && count($populars)>0)
            <h4 class="calibri">Cele mai populare produse ({{count($populars)}})</h4>
            <table class="table">
                @foreach($populars as $i)
                <tr>
                    <td style="width: 70px;">
                        <a href="{{URL('product/'.$i->id)}}" target="_blank">
                            @if(\File::exists($i->address))
                                <img src="{{ asset($i->address) }}" class="img-responsive"/>
                            @else
                                <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive" />
                            @endif
                        </a>
                    </td>
                    <td>
                        <a href="{{URL('product/'.$i->id)}}" target="_blank">
                            {{$i->originalname}}{{$i->name}}
                        </a>
                    </td>
                    <td class="text-center">
                        {{$i->views}} views
                    </td>
                </tr>
                @endforeach
            </table>
        @endif
    </div>
</div>
<Script>
    $(document).ready(function(){
        function timefunc() {
            var dt = new Date();
            var ora=dt.getHours();
            var minute=dt.getMinutes();
            var secunde=dt.getSeconds();
            if(ora<9){
                ora="0"+ora;
            }
            if(minute<9){
                minute="0"+minute;
            }
            if(secunde<9){
                secunde="0"+secunde;
            }
            var time = ora + ":" + minute + ":" + secunde;
            $("#time").html(time);
            setTimeout(timefunc, 1000);
        }
        timefunc();
    });
</script>
@endsection
