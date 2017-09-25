@if( count($admins) === 1 )
	<h3>Organizatör</h3>
	@foreach($admins as $user)
		@include('events.partials.blocks.userblock')
	@endforeach
@elseif( count($admins) > 1 )
	<h3>Organizatörler</h3>
	@foreach($admins as $user)
		@include('events.partials.blocks.userblock')
	@endforeach
@endif
{{ $admins->links() }}
