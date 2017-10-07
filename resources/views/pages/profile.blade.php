@extends('templates.default')

@section('header')

	@include('pages.header.index')

@endsection

@section('content')
	<!--Include pages-->
	@include('pages.partials.modals')
	
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
		@if(Auth::check() && Auth::user()->isPageAdmin($page))
			<li>
				<a data-toggle="pill" href="#admin">Yönetim</a>
			</li>
		@endif
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
			@if(Auth::check() && Auth::user()->isPageAdmin($page))
			<div id="admin" class="tab-pane fade">
				@include('pages.content.admin')
			</div>
		@endif
	</div>

@endsection
