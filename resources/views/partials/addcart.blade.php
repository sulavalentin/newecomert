
<div class="modal fade" id="cosAdded" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title">Produsul a fost adaugat in cos</h3>
        </div>
        <div class="modal-body">
            <div class="content" style="height: 60px;overflow: hidden;margin-bottom:10px;">
                <img src="" class="imgcart" id="imgcart"/>
                <p id="nameCart"></p>
            </div>
            <div class="content">
                <button data-dismiss="modal" class="btn btn-default">Inapoi</button>
                <a href="{{URL("/cart")}}" class="btn btn-primary pull-right">Vezi cosul</a>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="favoriteAdded" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title">Produsul a fost adaugat la favorite</h3>
        </div>
        <div class="modal-body">
            <div class="content" style="height: 60px;overflow: hidden;margin-bottom:10px;">
                <img src="" class="imgcart" id="imgfavorite"/>
                <p id="nameFavorite"></p>
            </div>
            <div class="content">
                <button data-dismiss="modal" class="btn btn-default">Inapoi</button>
                <a href="{{URL("/favorite")}}" class="btn btn-danger pull-right">
                    <span class="icon-heart-empty love"></span>
                    Mergi la favorite
                </a>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="compareAdded" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title text-center" id="mesagecompare">Produsul a fost adaugat</h3>
        </div>
        <div class="modal-body">
            <div class="content">
                <button data-dismiss="modal" class="btn btn-default">Inapoi</button>
                <a href="{{URL("/compare")}}" class="btn btn-primary pull-right">
                    Vezi produsele comparate
                </a>
            </div>
        </div>
      </div>
    </div>
</div>
<!--Modal preview-->
@include('partials.preview')


<script>
$(document).ready(function () {
	$(document).on({
		'show.bs.modal': function () {
			var zIndex = 1040 + (10 * $('.modal:visible').length);
			$(this).css('z-index', zIndex);
			setTimeout(function() {
				$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
			}, 0);
		},
		'hidden.bs.modal': function() {
			if ($('.modal:visible').length > 0) {
				setTimeout(function() {
					$(document.body).addClass('modal-open');
				}, 0);
			}
		}
    }, '.modal');
});
</script>