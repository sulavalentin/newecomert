<!-- Login form-->
<Script>
    function facebook(){
        var popup = window.open("{{ URL('/login-facebook') }}", '');
        var time=setInterval(checkChild, 500);
        function checkChild() {
            if (popup.closed) {
                location.reload();  
                clearInterval(time);
            }
        }
    }
    function google(){
        var popup = window.open("{{ URL('/login-google') }}", '');
        var time=setInterval(checkChild, 500);
        function checkChild() {
            if (popup.closed) {
                location.reload(); 
                clearInterval(time);
            }
        }
    }
</script>
<li>
    <img src="{{asset("img/system/user.png")}}" class="user"/>
    <a data-toggle="modal" data-target="#login">Logare</a>
    <div class="modal fade bs-modal-sm" id="login" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title text-center">Autentificare</h4>
            </div>
            <div class="modal-body login">
                {!! Form::open(array('method'=>'POST', 'id'=>'formalogare')) !!}
                    <label id="error">Email sau parola gresita*</label>
                    <div class="form-group">
                        <label for="email">Email</label>
                        {!! Form::text('text','',array('name'=>'email','class'=>'form-control','placeholder' => 'Email')) !!}
                    </div>
                    <div class="form-group">
                        <label for="parola">Parola</label>
                        {!! Form::password('password',array('name'=>'parola','class'=>'form-control','placeholder' => 'Parola')) !!}
                    </div>
                    <div style="width: 130px;margin: 0 auto; text-align: center;">
                        <img id="logloading" style="display:none; margin:0 auto;" src="{{asset("img/system/loadingreglog.gif")}}"/>
                        {!! Form::button('Login', array('class'=>'btn-sign','style'=>'margin:10px 0px 10px 0px;','id'=>'trimitelog')) !!}
                    </div>
                    <div class="social">
                        <label>Sau :</label>
                        <a onclick="facebook()">
                            <img src="{{asset("img/system/fb.png")}}"/>
                        </a>
                        <a onclick="google()">
                            <img src="{{asset("img/system/google.png")}}"/>
                        </a>
                    </div>
                    <a href="{{URL('/reset')}}" style="color:black; text-decoration: none;">
                        Ai uitat parola?
                    </a>
                    <br>
                    <a data-toggle="modal" data-dismiss="modal" data-target="#registrare" style="color:#333; text-decoration: none;">
                        Inregistrare
                    </a>
                {!! Form::close() !!}
            </div>
          </div>
        </div>
    </div>
</li>
<!--Register form--> 
<li class="last">
<a data-toggle="modal" data-target="#registrare">Inregistrare</a>
<div class="modal fade bs-modal-sm" id="registrare" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center">Inregistreaza-te</h4>
        </div>
        <div class="modal-body login">
            {!! Form::open(array('method'=>'POST', 'id'=>'formaregistrare')) !!}
                <div class="form-group">
                    <label id="rnume">Nume</label>
                    {!! Form::text('text','',array('name'=>'rnume','class'=>'form-control','placeholder' => 'Nume')) !!}
                </div>
                <div class="form-group">
                    <label id="remail">Email</label>
                    {!! Form::text('text','',array('name'=>'remail','class'=>'form-control','placeholder' => 'Email')) !!}
                </div>
                <div class="form-group">
                    <label id="rparola">Parola</label>
                    {!! Form::password('password',array('name'=>'rparola','class'=>'form-control','placeholder' => 'Parola')) !!}
                </div>
                <div class="form-group">
                    <label id="rrparola">Repeta parola</label>
                    {!! Form::password('password',array('name'=>'rrparola','class'=>'form-control','placeholder' => 'Repeta parola')) !!}
                </div>
                <div style="width: 130px;margin: 0 auto; text-align: center;">
                    <img id="regloading" style="display:none; margin:0 auto;" src="{{asset("img/system/loadingreglog.gif")}}"/>
                    {!! Form::button('Registrare', array('class'=>'btn-sign','id'=>'trimitereg')) !!} 
                </div>
                <div class="social">
                    <label>Sau :</label>
                    <a onclick="facebook()">
                        <img src="{{asset("img/system/fb.png")}}"/>
                    </a>
                    <a onclick="google()">
                        <img src="{{asset("img/system/google.png")}}"/>
                    </a>
                </div>
                <a data-toggle="modal" data-dismiss="modal" data-target="#login" style="color:#333; text-decoration: none;">
                    Logare
                </a>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
</div>
</li>
    <div class="modal fade" id="confirm_email" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title text-center">Succes!!</h4>
            </div>
            <div class="modal-body login">
                <h2 class="calibri">Accesati link-ul din email pentru a confirma emailul</h2>
                <button class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
          </div>
        </div>
    </div>
<script>
$(document).ready(function() {
        $("#trimitereg").on("click", function() {
            $("#trimitereg").attr("disabled",true);
            $("#regloading").css("display","block");
            $("#rnume").html("Nume");
            $("#remail").html("Email");
            $("#rparola").html("Parola");
            $("#rrparola").html("Repeta parola");
            $("#rnume").css("color","black");
            $("#remail").css("color","black");
            $("#rparola").css("color","black");
            $("#rrparola").css("color","black");
            $.ajax({  
                type: 'POST',  
                url: "{{URL('/register')}}", 
                data: 
                    { 
                        nume:$("input[name=rnume]").val(),
                        email:$("input[name=remail]").val(),
                        parola:$("input[name=rparola]").val(),
                        rparola:$("input[name=rrparola]").val(),
                    },
                success: function(data) { 
                    $("#rnume").html(data.nume);
                    if(data.nume){
                        $("#rnume").css("color","red");
                    }
                    $("#remail").html(data.email);
                    if(data.email){
                        $("#remail").css("color","red");
                    }
                    $("#rparola").html(data.parola);
                    if(data.parola){
                        $("#rparola").css("color","red");
                    }
                    $("#rrparola").html(data.rparola);
                    if(data.rparola){
                        $("#rrparola").css("color","red");
                    }
                    
                    $("#regloading").css("display","none");
                    $("#trimitereg").attr("disabled",false);
                    if(data.salogat){
                        $("#registrare").modal("hide");
                        $("#confirm_email").modal();
                    }
                }
            });
        });
        $("#trimitelog").on("click", function() {
            $("#trimitelog").attr("disabled",true);
            $("#logloading").css("display","block");
            $("#error").css("display","none");
            $.ajax({  
                type: 'POST',  
                url: "{{URL('/login')}}", 
                data: 
                    { 
                      email:$("input[name=email]").val(),
                      parola:$("input[name=parola]").val()
                    },
                success: function(data) {
                    if(data===false)
                    {
                        $("#error").css("display","block");
                    }
                    else
                    {
                        location.reload();
                    }
                    $("#logloading").css("display","none");
                    $("#trimitelog").attr("disabled",false);
                }
            });
        }); 
});
</script>