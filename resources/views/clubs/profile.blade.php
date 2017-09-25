@extends('templates.default')
@section('header')
	@include('clubs.header.index')
@endsection
@section('content')
	<!--All Club Modals-->

	@include('clubs.partials.modals')
	<!--Content of the Profile-->
	<ul class="nav nav-pills nav-justified tabs-nav" id="tabs">
		<li class="active">
			<a href="#home">Anasayfa</a>
		</li>
		<li>
			<a href="#events">Etkinlikler</a>
		</li>
		<li>
			<a href="#members">Üyeler</a>
		</li>
		<li>
			<a href="#about">Hakkında</a>
		</li>
		@if(Auth::user())
			@if(Auth::user()->isAdmin($club))
			<li>
				<a href="#admin">Yönetim</a>
			</li>
			@endif
		@endif
	</ul>

	<div class="tab-content">
		<div id="home" class="tab-pane fade in active content">
			@include('clubs.content.home')
		</div>
		<div id="events" class="tab-pane fade content">
			@include('clubs.content.events')
		</div>
		<div id="members" class="tab-pane fade content">
			@include('clubs.content.members')
		</div>
		<div id="about" class="tab-pane fade content">
			@include('clubs.content.about')
		</div>
		@if(Auth::user())
			@if(Auth::user()->isAdmin($club))
				<div id="admin" class="tab-pane fade content">
					@include('clubs.content.admin')
				</div>
			@endif
		@endif
	</div>

@endsection
