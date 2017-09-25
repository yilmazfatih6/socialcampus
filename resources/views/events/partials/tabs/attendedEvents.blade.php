@if(count($attendedEvents))
	@foreach($attendedEvents as $event)
		<div class="col-lg-3 col-md-4 col-sm-6">
			@include('events.partials.blocks.eventblock')
		</div>
	@endforeach
@else
	<div class="col-lg-12 text-center">
		<small>Katıldığınız hiçbir etkinlik yok.</small>
	</div>
@endif
