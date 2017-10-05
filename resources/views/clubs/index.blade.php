@extends('templates.default')

@section('content')

<div class="container">
	@if(Auth::check())

		<!--Header & Create Button-->
		<div class="row">
			<div class="col-lg-12 text-center">
				<h1 class="inline">Kulüpler</h1>
				<a href="{{route('clubs.create')}}" class="btn-create">
					<i class="fa fa-plus" aria-hidden="true"></i>
				</a>
			</div>
		</div> <!--/ Header & Create Button-->

		<hr>

		<!--Requested Clubs-->
		@if(Auth::user()->isRequestedAnyClub())
			<div class="row">
				<h4 class="header"><b>Katılım İsteği Yollanan Kulüpler</b></h4>
				<section class="requested">
					@include('clubs.partials.pagination.requestedClubs')
				</section>
			</div>
		@endif<!--/ Requested Clubs-->

		<!--Admined Clubs-->
		@if(Auth::user()->isAdminAny())
			<div class="row">
				<h4><b>Yönetici Olduğun Kulüpler</b></h4>
				<section class="owned">
					@include('clubs.partials.pagination.ownedClubs')
				</section>
			</div>
		@endif<!--/ Admined Clubs-->

		<!-- Joined Clubs -->
		@if(Auth::user()->isMemberAny())
			<div class="row">
				<h4><b>Üyesi Olduğun Kulüpler</b></h4>
				<section class="joinedClubs">
					@include('clubs.partials.pagination.joinedClubs')
				</section>
			</div>
		@endif <!-- Joined Clubs -->

		<!--Other Clubs-->
		<div class="row">
			@if( isset($otherClubs) )
				@if(isset($requestedClubs) || isset($ownedClubs) || isset($joinedClubs) )
					<h4><b>Diğer Kulüpler</b></h4>
				@endif
				@if( count($otherClubs) )
					<section class="otherClubs">
						@include('clubs.partials.pagination.otherClubs')
					</section>
				@else
					<div class="col-lg-12">
						<small>Katılabileceğin başka kulüp yok :(</small>
					</div>
				@endif
			@else
				@if( count($clubs) )
					<div class="col-lg-12">
						<h4><b>Tüm Kulüpler</b></h4>
					</div>
					@foreach($clubs as $club)
						<div class="col-lg-4 col-md-4" style="margin-bottom:10px;">
							@include('clubs.partials.clubblock')
						</div>
					@endforeach
				@else
					<div class="col-lg-12 text-center">
						<small>Site üzerinde henüz hiçbir kulüp yok.</small>
					</div>
				@endif
			@endif
		</div><!-- / Other Clubs-->


	@endif

	<!-- Non Authenticated-->
	@if(!Auth::check())
		<div class="row">
			<h1 class="text-center"><strong>Kulüpler</strong></h1><hr>
			@if( count($clubs) )
				<section class="allClubs">
					@include('clubs.partials.pagination.clubs')
				</section>
			@else
				<div class="col-lg-12 text-center">
					<small>Site üzerinde henüz hiç bir kulüp yok.</small>
				</div>
			@endif
		</div>
	@endif	<!-- / Non Authenticated-->
</div>
@endsection
