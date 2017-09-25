@extends('templates.default')


@section('content')

	<div class="row">
		<div class="col-md-3" id="club-requests-wrapper">
			<div id="club-requests">
				<h3 class="text-center">Kulüp Açma Talepleri</h3>
				@if( count($clubRequests) )
					@foreach($clubRequests as $club)
						@include('lord.partials.clubblock')
					@endforeach
				@else
					<div class="text-center">
						<small>Yeni kulüp açma isteği bulunmamakta.</small>
					</div>
				@endif
			</div>
		</div>
		<div class="col-md-6">
			<h2 class="text-center">Yönetim Kontrol Paneli</h2>
			<div class="text-center">
				<small>Buralar henüz bomboş.</small>
			</div>
		</div>
		<div class="col-md-3" id="active-clubs-wrapper">
			<div id="active-clubs">
				<h3 class="text-center">Aktif Kulüpler</h3>
				@if( count($confirmedClubs) )
					@foreach($confirmedClubs as $club)
						@include('lord.partials.clubblock')
					@endforeach
				@else
					<div class="text-center">
						<small>Sitede henüz aktif kulüp yok.</small>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection
