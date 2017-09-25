<!--Displaying Event Blocks-->
<div class="row">
	<h3 class="text-center">Kulüp İçi Etkinlikler</h3><hr>
	@if(count($events))
		@foreach($events as $event)
			<div class="col-lg-3 col-md-4 col-sm-6">
			@if(!$event->ended)
				@include('events.partials.blocks.eventblock')
			</div>
			@endif
		@endforeach
	@else
		<div class="col-lg-12">
			<p class="small text-center">Henüz hiçbir etkinlik oluşturulmamış.</p>
		</div>
	@endif
</div>
