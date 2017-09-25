@extends('templates.default')

@section('header')

	@include('pages.header.index')

@endsection

@section('content')

	<!--Content of the Profile-->
	<ul class="nav nav-pills nav-justified tabs-nav" id="tabs">
		<li class="active">
			<a data-toggle="pill" href="#home">Anasayfa</a>
		</li>
		<li class="nav-item">
			<a data-toggle="pill" href="#followers">Takipçiler</a>
		</li>
		<li>
			<a data-toggle="pill" href="#about">Hakkında</a>
		</li>
	</ul>
	<div class="tab-content">
			<div id="home" class="tab-pane fade in active">
				@include('pages.content.home')
			</div>
			<div id="followers" class="tab-pane fade">
				@include('pages.content.followers')
			</div>
			<div id="about" class="tab-pane fade">
				@include('pages.content.about')
			</div>
	</div>

@endsection
