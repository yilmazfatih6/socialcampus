@if(count($events))
	@foreach($events as $event)
		<div class="col-lg-3 col-md-4 col-sm-6 event-thumbnail-{{$event->id}}">
			@include('events.partials.blocks.eventblock')
		</div>
	@endforeach
@else
	<div class="col-lg-12 text-center">
		<small>Site üzerinde hiçbir etkinlik yok.</small>
	</div>
@endif
