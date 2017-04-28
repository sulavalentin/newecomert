<!-- Modal -->
<div class="modal fade" id="preview" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content modal-lg">
            <div class="content ProducteImagine" style="padding: 20px 15px 15px 15px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 itemborder">
                    <!-- Imagini slide-->
                    <div class="item_imagine">
                        <div class="image-preview">
                            <img src="{{ asset('img/system/default.jpg') }}" class="img-responsive" id="jdefault"/>
                        </div>
                        <div class="content_images">
                            <ul class="list_images" id="jlist_images">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 continut">
                    <h4 class="itemName calibri" id="jname"></h4>
                    <div class="pretEtc">
                        <div class="pret_Produs calibri"> 
                            <span id="jlei">
                                <sup class="price_dec">
                                </sup>
                            </span>
                        </div>  
                        <div class="item_margin">
                            <button class="btn_add calibri" name="addcart" prod="" id="jaddcard">
                                <span class="glyphicon glyphicon-shopping-cart"></span>
                                Adauga in cos
                            </button>
                            <br>
                            <button class="favorite calibri" name="addfavorite" prod="" id="jaddfavorite">
                                    <span class="" id="jheart"></span>
                                Adauga la favorite
                            </button>
                            <br>
                            <button class="compare calibri" name="addcompare" prod="" id="jaddcompare">
                                <span class="glyphicon glyphicon-sort"></span>
                                Compara
                            </button>
                        </div>
                   </div>
                </div>
                <div class="col-lg-12 detalii" id="jdetalii">
                </div>
                <div class="col-xs-12 info" id="jinfo">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Inchide</button>
            </div>
        </div>
    </div>
</div>
<script>
    var asset="{{asset('/')}}";
    $('body').on("click","#jlist_images li img",function () {
        $("#jdefault").attr("src",$(this).attr("src"));
    });
    function UrlExists(url)
    {
        var http = new XMLHttpRequest();
        http.open('HEAD', asset+url, false);
        http.send();
        return http.status!=404;
    }
    function adddata(data){
        if(data.item[0]){
            $("#jname").text(data.item[0].originalname+data.item[0].name);
            $("#jlei").html(data.item["price"].lei+" <sup class='price_dec'>,"+data.item["price"].capici+"</sup> Lei");
            if(UrlExists(data.item[0].address))
            {
                $("#jdefault").attr("src",asset+data.item[0].address);
            }
            else
            {
                $("#jdefault").attr("src",asset+"img/system/default.jpg");
            }
            $("#jlist_images").text("");
            $.each(data.images,function(i,v){
                $("#jlist_images").append("<li>\n\
                                                <img src='"+asset+v.address+"' class='img-responsive'/>\n\
                                            </li>");
            });
            $("#jaddcard").attr("prod",data.item[0].id);
            $("#jaddfavorite").attr("prod",data.item[0].id);
            $("#jaddcompare").attr("prod",data.item[0].id);
            if(data.item[0].idfavorite===null){
                $("#jheart").removeClass("icon-heart-empty icon-heart").addClass("icon-heart-empty");
            }else{
                $("#jheart").removeClass("icon-heart-empty icon-heart").addClass("icon-heart");
            }
            if(data.item[1]){
                var count=0;
                $.each(data.item[1],function(i,v){
                    count++;
                    $("#jdetalii").append("<div class='desSearch'>\n\
                                            <div class='specification'>\n\
                                                <p class='denumire'>"+i+"</p>\n\
                                                <div class='spec_value' id='count"+count+"'>");
                                                   $.each(v,function(i1,v1){
                                                        $("#count"+count).append("<div style='width:100%; float:left'>\n\
                                                                    <p class='value_spec'>"+v1.specification_name+":</p>\n\
                                                                    <p class='value_spec'>"+v1.value+"</p> \n\
                                                                </div>");
                                                    });
                    $("#jdetalii").append("</div>\n\
                                        </div>\n\
                                    </div> ");
                });
            }
            if(data.descriere){
                $.each(data.descriere,function(i,v){
                    $("#jinfo").append("<img class='img-responsive' src='"+asset+v.image+"'/>");
                });
            }
        }
        return 0;
    }
    function closeloader(){
        $("#fullpageload").hide();
        $("#preview").modal();
    }
    $("button[name=peview]").on("click",function(){
        $("#fullpageload").show();
        $("#jdetalii").html("<h1 class='text-center calibri' style='margin: 0px 0px 15px 0px;'>Caracteristici</h1>");
        $("#jinfo").text("");
        $("#jlei").text("");
        $("#jcapici").text("");
        var id=$(this).attr("prod");
        $.ajax({  
            type: 'POST',  
            url: '{{ URL("/preview") }}', 
            data: 
                { 
                    id:id
                },
            success: function(data) {
                adddata(data).then(closeloader());
                
            },
            error:function(){
                $("#fullpageload").hide();
            }
        });
    });
</script>