@extends('templates.default')

@section('content')

	<div class="container">
		<div class="col-md-6 col-md-offset-3">
			<div class="admins">
				@include('events.partials.pagination.admins')
			</div>
		</div>
	</div>

@endsection
