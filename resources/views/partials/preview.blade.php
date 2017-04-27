<!-- Modal -->
<div class="modal fade" id="preview" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Modal Header</h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Inchide</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("button[name=peview]").on("click",function(){
        $("#preview").modal();
    });
</script>