@extends('templates.default')
@section('content')
	@include('events.partials.modals')
	<!--Header & Create Button-->
	<div class="row">
		<div class="col-lg-12 text-center">
			<h1 class="inline">Etkinlikler</h1>
			<!-- Checking Auth -->
			@if(Auth::check())
				<!--Modal Button-->
				<a  class="btn-create" data-toggle="modal" data-target="#create-event">
					<i class="fa fa-plus" aria-hidden="true"></i>
				</a> <!-- / Modal Button-->
			@endif
			<!-- End of Checking Auth -->
		</div>
	</div>
	<!-- / Header & Create Button-->
	<hr>
	<!-- Event Panels  -->
	@if( isset($ownedEvents) || isset($joinedClubsEvents) || isset($attendedEvents) )
		@if( count($ownedEvents) || count($joinedClubsEvents) || count($attendedEvents) )
		<div class="row">
			<div class="container-fluid">
				<ul class="nav nav-pills nav-justified tabs-nav" id="tabs">
					@if( count($ownedEvents) )
						<li>
							<a href="#ownedEvents">Etkinliklerim</a>
						</li>
					@endif
					@if( count($attendedEvents) )
						<li>
							<a href="#attended">Katıldıklarım</a>
						</li>
					@endif
					@if( count($joinedClubsEvents) )
						<li class="active">
							<a href="#joinedClubsEvents">Kulüplerim</a>
						</li>
						<li>
							<a href="#others">Diğer Etkinlikler</a>
						</li>
					@else
						<li class="active">
							<a href="#others">Diğer Etkinlikler</a>
						</li>
					@endif
				</ul>
			</div><br><br>
			<div class="tab-content">
				@if( count($joinedClubsEvents) )
				<div id="joinedClubsEvents" class="tab-pane active fade content">
					@include('events.partials.tabs.joinedClubsEvents')
				</div>
				<div id="others" class="tab-pane fade content">
					@include('events.partials.tabs.otherEvents')
				</div>
				@else
				<div id="others" class="tab-pane active fade content">
					@include('events.partials.tabs.otherEvents')
				</div>
				@endif
				<div id="ownedEvents" class="tab-pane fade content">
					@include('events.partials.tabs.ownedEvents')
				</div>
				<div id="attended" class="tab-pane fade content">
					@include('events.partials.tabs.attendedEvents')
				</div>
			</div>
		</div> <!-- / Event Panels  -->
		@endif
	@else
	<div class="row">
		@include('events.partials.tabs.allEvents')
	</div>
	@endif
	
	@include('events.partials.modals')
@endsection
