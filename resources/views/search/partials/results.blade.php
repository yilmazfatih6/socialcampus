@if(isset($users) || isset($clubs) || isset($events) || isset($pages))
	<h4 class="text-center"><b>"{{ Request::input('query') }}"</b> İçin Arama Sonucunuz</h4>
@endif

<!--Display users-->
@if( isset($users) && $users->count() )
	<div class="row">
		<h3><b>Kişiler</b></h3>
		@foreach($users as $user)
			<div class="col-md-4 col-sm-6" style="margin:0 0 13px -13px;">
				@include('users.partials.userblock')
			</div>
		@endforeach
	</div>
@endif

<!--Display Clubs-->
@if( isset($clubs) && $clubs->count() )
	<div class="row">
		<h3><strong>Kulüpler</strong></h3>
		@foreach($clubs as $club)
			<div class="col-md-4" style="margin:0 0 13px -13px;">
		    		@include('clubs.partials.clubblock')
			</div>
		@endforeach
	</div>
@endif

<!--Display Events-->
@if( isset($events) && $events->count() )
	<div class="row">
		<h3><strong>Etkinlikler</strong></h3>
		@foreach($events as $event)
			<div class="col-lg-3 col-md-4 col-sm-6">
		    		@include('events.partials.blocks.eventblock')
			</div>
		@endforeach
	</div>
@endif

<!--Display Pages-->
@if( isset($pages) && $pages->count() )
	<div class="row">
		<h3><strong>Sayfalar</strong></h3>
		@foreach($pages as $page)
			<div class="col-md-3" style="margin:0 0 13px -13px;">
		    		@include('pages.partials.pageblock')
			</div>
		@endforeach
	</div>
@endif
