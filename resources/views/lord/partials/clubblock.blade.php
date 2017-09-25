<div class="media" id="clubblock-{{$club->id}}">

	<!-- Image -->
	<a class="pull-left" href="/club/{{$club->abbreviation}}">
		<img class="img-rounded avatar"  src="/storage/avatars/{{$club->avatar}}">
	</a><!-- / Image -->

	<!--Media Body-->
	<div class="media-body">

		<h4 class="media-heading"><a class="link-header" href="/club/{{$club->abbreviation}}">{{ $club->name }}</a></h4>
		<p class="text-muted">{{ $club->abbreviation }}</p>

		<!--Confirmation Buttons-->
		@if(!$club->confirmed)
			<!-- Confirm Club -->
			<form class="inline" id="lord-confirm-club" action="/lord/confirm/{{$club->abbreviation}}" method="post">
				<button type="submit" class="btn btn-success btn-sm">
					Onayla <i class="fa fa-check" aria-hidden="true"></i>
				</button>
				<input type="hidden" name="_token" value="{{csrf_token()}}">
			</form>

			<!-- Reject Club -->
			<form class="inline" id="lord-reject-club" action="/lord/reject/{{$club->abbreviation}}" method="post">
				<button type="submit" class="btn btn-danger btn-sm">
					Reddet <i class="fa fa-ban" aria-hidden="true"></i>
				</button>
				<input type="hidden" name="_token" value="{{csrf_token()}}">
			</form>
		@endif
		<!-- / Confirmation Buttons-->

		<!-- Info Button-->
		<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#club-info-{{$club->id}}">
		Bilgi <i class="fa fa-info" aria-hidden="true"></i>
		</button>

		<!-- Info Modal -->
		<div id="club-info-{{$club->id}}" class="modal fade" role="dialog">

			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">

					<div class="modal-header">
				      	<button type="button" class="close" data-dismiss="modal">&times;</button>
				      	<h4 class="modal-title">{{$club->name}}</h4>
					</div>

					<div class="modal-body">
						<div class="text-center">
							<img class="img-rounded modal-avatar"  src="/storage/avatars/{{$club->avatar}}">
						</div>
						<p><b>Kısaltması:</b> {{$club->abbreviation}}</p>
						<p><b>Türü:</b> {{$club->club_type}}</p>
						<p><b>Açıklaması: </b> {{$club->description}}</p>

					</div>

				</div>

			</div> <!-- Modal Content -->
		</div> <!-- / Info Modal -->


	</div><!-- / Media Body-->

</div>
