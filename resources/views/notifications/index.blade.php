@extends('templates.default')


@section('content')
	
		<div class="row">
			<div class="col-md-6 col-md-offset-3">	
				<h3>Bildirimler</h3>

				@if(count(Auth::user()->notifications))
					@foreach (Auth::user()->notifications as $notification)
						@include('notifications.partials.notificationblock')
					@endforeach
				@else
					<small>Seni düşünen yok :(</small>	
				@endif	
			</div>	
		</div>

@endsection
				