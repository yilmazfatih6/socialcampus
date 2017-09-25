@extends('templates.default')

@section('content')

	<div class="container">
		<div class="col-md-6 col-md-offset-3">
			<h1>Katılımcılar</h1>
			<div class="attenders">
				@include('events.partials.pagination.attenders')
			</div>
		</div>

	</div>

@endsection
