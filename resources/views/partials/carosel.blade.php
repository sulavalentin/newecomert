<style>
    .item{
        max-height: 400px;
    }
</style>
<div class="container">
    <div class="row">
        <div id="carousel" class="carousel slide">
        <!--indicatore a slaidurilor -->
            <ol class="carousel-indicators">
                <li class="active" data-target="#carousel" data-slide-to="0"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
                <li data-target="#carousel" data-slide-to="3"></li>
            </ol>
            <!--Slaiduri-->
            <div class="carousel-inner">
                <div class="item active">
                    <img src="http://www.cumpar.net/wp-content/uploads/2016/05/procesor-1.jpg" alt="Imaginea lipseste">
                </div>
                @for($i=0;$i<=2;$i++)
                    <div class="item">
                        <a href="#">
                            <img src="http://www.cumpar.net/wp-content/uploads/2016/05/procesor-1.jpg" alt="Imaginea lipseste" >
                        </a>
                    </div>
                @endfor
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
</div>