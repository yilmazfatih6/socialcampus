@extends('templates.default')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h2 class="text-center">Arama Yap</h2>
				<form id="search-page-form" role="search" method="get" action="/searchengine">
					<div class="input-group">
						@if(isset($query))
						<input type="text" name="query" class="form-control" placeholder="Arama Yap" value="{{$query}}">
						@else
						<input type="text" name="query" class="form-control" placeholder="Arama Yap">
						@endif
						<span class="input-group-btn">
							<button class="btn btn-info" type="submit">Ara</button>
						</span>
					</div>
					<div class="text-center margin-top-ten">
				  		<label class="radio-inline"><input type="radio" name="restrict" value="all" checked>Hepsi</label>
						<label class="radio-inline"><input type="radio" name="restrict" value="users">Kişiler</label>
						<label class="radio-inline"><input type="radio" name="restrict" value="clubs">Kulüpler</label>
						<label class="radio-inline"><input type="radio" name="restrict" value="events">Etkinlikler</label>
						<label class="radio-inline"><input type="radio" name="restrict" value="pages">Sayfalar</label>
					</div>
				</form>
			</div>
		</div><br>
		<!--Results Section-->
		<section id="results">
			@include('search.partials.results')
		</section>
	</div>
@endsection
