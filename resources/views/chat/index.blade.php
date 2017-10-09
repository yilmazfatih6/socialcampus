@extends('templates.default')

@section('content')
	<div id="personal-chat">
		@include('chat.partials.modals')

		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				
				<!--Tabs List-->
				<ul class="nav nav-pills nav-justified tabs-nav">
					<li class="active"><a data-toggle="pill" href="#users">Kişiler</a></li>
					<li><a data-toggle="pill" href="#clubs">Kulüpler</a></li>
					<li><a data-toggle="pill" href="#events">Etkinlikler</a></li>
					<li><a data-toggle="pill" href="#pages">Sayfalar</a></li>
				</ul>

				<!--Tabs Contents-->
				<div class="tab-content">

					<!--Users-->
					<div id="users" class="tab-pane fade in active">
						<!--Header-->
						<div class="text-center margin-top-ten">
							<h2 class="inline">Kişiler</h2>
							<!--New Chat-->
							<a class="btn-create" data-toggle="modal" data-target="#selectUser">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</a>
						</div><hr>
						<!--Inbox-->
						@if(!empty($users) && count($users))
							<users :users="{{$users}}"></users>
						@else
							<div class="text-center">
								<small>Henüz hiç mesajınız yok.</small>
							</div>
						@endif
					</div><!--/Users-->

					<!--Clubs-->
					<div id="clubs" class="tab-pane fade">
						<!--Header-->
						<div class="text-center margin-top-ten">
							<h2 class="inline">Kulüpler</h2>
							<!--New Chat-->
							<a class="btn-create" data-toggle="modal" data-target="#selectClub">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</a><hr>
							<!--Inbox-->
							@if(!empty($clubs) && count($clubs))
								<clubs :user="{{Auth::user()}}" :clubs="{{$clubs}}"></clubs>
							@else
								<div class="text-center">
									<small>Henüz hiç mesajınız yok.</small>
								</div>
							@endif
						</div>
						
					</div><!--/ Clubs -->

					<!--Events-->
					<div id="events" class="tab-pane fade">
						<!--Header-->
						<div class="text-center margin-top-ten">
							<h2 class="inline">Etkinlikler</h2>
							<!--New Chat-->
							<a class="btn-create" data-toggle="modal" data-target="#selectEvent">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</a><hr>
							<!--Inbox-->
							@if(!empty($events) && count($events))
								<events :user="{{Auth::user()}}" :events="{{$events}}"></events>
							@else
								<div class="text-center">
									<small>Henüz hiç mesajınız yok.</small>
								</div>
							@endif
						</div>
					</div><!--/ Events-->

					<!--Pages-->
					<div id="pages" class="tab-pane fade">
						<!--Header-->
						<div class="text-center margin-top-ten">
							<h2 class="inline">Sayfalar</h2>
							<!--New Chat-->
							<a class="btn-create" data-toggle="modal" data-target="#selectPage">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</a><hr>
							<!--Inbox-->
							@if(!empty($pages) && count($pages))
								<clubs :user="{{Auth::user()}}" :pages="{{$pages}}"></clubs>
							@else
								<div class="text-center">
									<small>Henüz hiç mesajınız yok.</small>
								</div>
							@endif
						</div>
					</div><!--/ Pages-->

				</div><!--/Tabs Contents-->


				
			</div>
		</div>
	</div>

@endsection
