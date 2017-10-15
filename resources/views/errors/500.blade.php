@extends('templates.default')

@section('content')
	<div class="col-md-6 col-md-offset-3">
		<h1 class="text-center">Üzgünüz bir hata oluştu :(</h1><hr>
		@include('feedback.partials.form')
	</div>	

@endsection