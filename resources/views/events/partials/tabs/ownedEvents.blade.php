@if(count($ownedEvents))
	<div class="row">
		@foreach($ownedEvents as $event)
			<div class="col-lg-3 col-md-4 col-sm-6 event-thumbnail-{{$event->id}}">
				@include('events.partials.blocks.eventblock')
			</div>
		@endforeach
	</div>
@else
	<div class="col-lg-12 text-center">
		<small>Organizatörü olduğunuz etkinlik yok.</small>
	</div>
@endif
