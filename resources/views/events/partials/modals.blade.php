@if(Auth::check())
	@if( isset($clubAdmin) )
	<!--Create Event Modal-->
	<div id="create-event" class="modal fade" role="dialog">
		<!--Modal Dialog-->
		<div class="modal-dialog">
			<!--Modal Content-->
			<div class="modal-content">
				<!--Modal Header-->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
			        		<h3 class="modal-title">Etkinlik Oluştur</h3>
		        		</div><!--End of the Modal Header-->
			        	<!--Modal Body-->
				<div class="modal-body">
					@if(count($clubAdmin))
						<h4>Şu kulüp için etkinlik oluştur.</h4>
						@foreach($clubAdmin as $club)
							@if($club->confirmed)
								@include('events.partials.blocks.clubblock')
							@else
								<p>Herhangi bi kulüpte yönetici değilsin.</p>
								<small class="text-muted">
								Etkinlik Oluşturabilmek için herhangi kulüpten bir tanesinde yönetici olmasın.
								</small>
							@endif
						@endforeach
					@else
						<p class="lead">Herhangi bi kulüpte yönetici değilsin.</p>
						<small class="text-muted">
						Etkinlik Oluşturabilmek için herhangi kulüpten bir tanesinde yönetici olmasın.
						</small>
					@endif
				</div> <!--End of Modal Body-->
			</div><!--End of Modal Content-->
	  	</div><!--End of the Modal Dialog-->
	</div> <!--End of the Modal-->
	@endif
@endif


<!--Ask smthng to Admin Modal-->
@if(Auth::check())
	<!--Modal Fade-->
	<div class="modal fade" id="ask-to-admin" role="dialog">
	    <!--Modal Dialog-->
	    <div class="modal-dialog">
	        <!--Modal Content-->
	        <div class="modal-content">
	            <!-- Modal Header -->
	            <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3><b>Organizatöre Soru Sor</b></h3>
	            </div><!--/ Modal Header-->
	            <!--Modal Body-->
	            <div class="modal-body">

	            </div><!--/ Modal Body-->
	        </div><!--/ Modal Content-->
	    </div><!--/ Modal Dialog-->
	</div><!--/ Modal Fade-->
@endif
