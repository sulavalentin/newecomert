@extends("admin.base")
@section("content")
<div class="col-md-12">
    <p class='text-info'>Recomandat 1000x300px</p>
    <p id='curentlogo'>
        @if(!empty($post) && count($post['logo'])>0)
            <img src='{{asset($post['logo']->valuevariable)}}' class='img-responsive'/>
        @else
            <b>Siteul nu are logo</b>
        @endif
    </p>
    <form id="upload" enctype="multipart/form-data" class="col-md-4">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label class="file">
            <a class='btn btn-info' id="logosite" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Se incarca">Incarca logo</a>
            <input type="file" name="file" style="display:none;"><br>
        </label>
        <p id="imageeror" class="text-danger"></p>
    </form>
</div>
<script>
    $(document).ready(function(){
        $("#upload").on("submit",function(e){
            e.preventDefault();
            $("#logosite").button("loading");
            $("#imageeror").html("");
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: "{{URL('/admin/uploadlogo')}}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    if(data.succes===true){
                        $("#curentlogo").html("<img src='{{asset('/')}}"+data.image+"' class='img-responsive'/>");
                    }else{
                        $("#imageeror").html("fisierul nu este imagine");
                    }
                    $("#logosite").button("reset");
                },
                error:function(){
                    $("#imageeror").html("A aparut o eroare");
                    $("#logosite").button("reset");
                }
            });
        });
        $("#upload").on("change", function() {
            $("#upload").submit();
        });
    });
</script>
@endsection