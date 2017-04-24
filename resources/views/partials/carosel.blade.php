@if(!empty($slideshow) && count($slideshow)>0)
    <style>
        .item{
            max-height: 450px;
        }
    </style>
    <div class="content">
        <div id="carousel" class="carousel slide">
        <!--indicatore a slaidurilor -->
            <ol class="carousel-indicators">
                <li class="active" data-target="#carousel" data-slide-to="0"></li>
                @for($i=1;$i < count($slideshow);$i++)
                    <li data-target="#carousel" data-slide-to="{{$i}}"></li>
                @endfor	
            </ol>
            <!--Slaiduri-->
            <div class="carousel-inner">
                @foreach($slideshow as $i)
                    @if($i->id==$slideshow[0]->id)
                        <div class="item active">
                            <a href="{{$i->link}}">
                                <img src="{{asset($i->image)}}" alt="Imaginea lipseste" style="width:100%">
                            </a>
                        </div>
                    @else
                        <div class="item">
                            <a href="{{$i->link}}">
                                <img src="{{asset($i->image)}}" alt="Imaginea lipseste" style="width:100%">
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
            <!--Sagetile de pornire a slaidului -->
            <a href="#carousel" class="left carousel-control" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>	
            </a>
            <a href="#carousel" class="right carousel-control" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>
    <script>
        $('#carousel').carousel({
            interval: 4000
        });
    </script>
@endif