<div class="row">
	@foreach($ownedClubs as $club)
		<div class="col-lg-4 col-md-4" style="margin-bottom:10px;">
			@include('clubs.partials.clubblock')
		</div>
	@endforeach
</div>
<div class="row text-center">
	{{ $ownedClubs->links() }}
</div>
