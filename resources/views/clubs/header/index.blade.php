<div class="row profile-header" style="background-image:url('/storage/covers/{{$club->cover}}');">
	<div class="col-lg-4 col-xs-8">
		<!--Club Avatar Media-->
		<div class="media">
			<div class="media-left">
				<img class="img-rounded" src="/storage/avatars/{{$club->avatar}}" style="width:100px; height:100px;">
			</div>
		</div>
	</div>
	
	@if(Auth::check())
	<!--Membership Buttons on XS Devices-->
	<div class="col-xs-4 pull-right">
		<!-- Membership Buttons -->
		<ul id="membership-buttons-xs" class="nav navbar-nav navbar-right visible-xs">
			@include('clubs.partials.load.headerButtons')
		</ul>
		<!-- / Membership Buttons -->
	</div>
	<!-- / Membership Buttons on XS Devices-->
	@endif

</div>
@include('clubs.header.partials.bio')
