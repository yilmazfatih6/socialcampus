<!--Modal Fade-->
<div class="modal fade" id="select" role="dialog">
    <!--Modal Dialog-->
    <div class="modal-dialog">
        <!--Modal Content-->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            	<h4 class="inline">Şuna mesaj at...</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            </div><!--/ Modal Header-->
            <!--Modal Body-->
            <div class="modal-body">
                <users :users="{{$friends}}"></users>
            </div><!--/ Modal Body-->
        </div><!--/ Modal Content-->
    </div><!--/ Modal Dialog-->
</div><!--/ Modal Fade-->
