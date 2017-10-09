@extends('templates.default')

@section('content')
@include('events.partials.modals')

<div class="row">
	<div class="col-md-3 event-info">
		@include('events.partials.info')
	</div>

	<!--Middle Grid-->
	<div class="col-md-6">
		<!--Posting Status-->
		@if(Auth::user())
		<div id="sharing-wrapper">
			<div id="share">
				@if(Auth::user()->isConfirmed($event))
					<hr>
					@include('events.partials.posting')
				@endif
			</div>
		</div>
		@endif
		@if(count($statuses))
			<hr>
			<!--Statuses-->
			<h3 class="text-center"><b>Paylaşımlar</b></h3>
	        <section class="results">
                @include('statuses.load')
            </section>
	    @else
			<div class="container-fluid">
				<br>
				<p class="text-center text-danger">Henüz paylaşım yapılmamış.</p>
			</div>
		@endif
	</div><!--/ Middle Grid-->

	<div class="col-md-3">

		<!--Ask smthng to Admin Modal Button-->
		@if(Auth::check())
		<button class="btn btn-info btn-block hidden-sm hidden-xs" data-toggle="modal" data-target="#ask-to-admin">
			<i class="fa fa-comments" aria-hidden="true"></i> Organizatöre Soru Sor
		</button>
		@endif
		<!--Club-->
			<h3>Organizatör Kulüp</h3>
			@foreach($event->clubs()->get() as $club)
				@include('clubs.partials.clubblock')
			@endforeach

		<!--Admins-->
		p

		<!--Attenders-->
		<div id="attenders-wrapper">
			<div id="attenders">
				<h3>Katılımcılar</h3>
				<section class="attenders">
					@include('events.partials.pagination.attenders')
				</section>
			</div>
		</div>

	</div>

</div>

@endsection
