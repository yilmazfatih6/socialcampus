@extends('templates.default')

@section('content')
@include('events.partials.modals')

<div class="row">
	<div class="col-md-3">
		<ul class="list-group">
			<!--Title-->
			<li class="list-group-item text-center"><h3>{{$event->name}}</h3></li>
			<!--Image-->
			<img src="/storage/events/posters/{{$event->poster}}" class="center-block" style=" max-width:100%; max-height:100%;">
			<!--Description-->
			<li class="list-group-item white-space" id="description">{!! $event->shortenDescript() !!}</li>
			<!--Date-->
			<li class="list-group-item">
				<b><i class="fa fa-calendar" aria-hidden="true"></i> Tarih:</b>
				{{date("d F Y",strtotime($event->date))}}
			</li>
			<!--Hour-->
			<li class="list-group-item">
				<b><i class="fa fa-clock-o" aria-hidden="true"></i> Tarih:</b>
				{{$event->hour}}
			</li>
			@if($event->deadline)
				<!--Deadline-->
				<li class="list-group-item">
					<b><i class="fa fa-calendar" aria-hidden="true"></i> Son Başvuru:</b>
					{{date("d F Y",strtotime($event->deadline))}}
				</li>
			@endif
			<!--Attenders-->
			<li id="attender-num-wrap" class="list-group-item">
				<div id="attender-num">
					<b><i class="fa fa-users" aria-hidden="true"></i> Katılımcı:</b>
					{{$event->attenders}}
				</div>
			</li>
			@if($event->attender_limit)
				<!--Attenders Limit-->
				<li class="list-group-item">
					<b><i class="fa fa-users" aria-hidden="true"></i> Katılımcı Limiti:</b>
					{{$event->attender_limit}}
				</li>
			@endif
			@if($event->phone)
				<!--Phone-->
				<li class="list-group-item">
					<b><i class="fa fa-phone" aria-hidden="true"></i> Telefon:</b>
					{{$event->phone}}
				</li>
			@endif
			@if($event->phone_alternative)
				<!--Phone Alternative-->
				<li class="list-group-item">
					<b><i class="fa fa-phone-square" aria-hidden="true"></i> Telefon:</b>
					{{$event->phone_alternative}}
				</li>
			@endif

			<!--Price-->
			@if($event->price)
				<li class="list-group-item">
					<b>₺ Ücret:</b>
					{{$event->price}}
				</li>
			@endif

			<!--Ask smthng to Admin Modal Button-->
			@if(Auth::check())
				<li class="list-group-item ask-to-admin hidden-lg hidden-md">
					<a class="link-white" href="/chat/{{Auth::user()->id}}/event/{{$event->id}}">
						<i class="fa fa-comments" aria-hidden="true"></i> Organizatöre Soru Sor
					</a>
				</li>
			@endif

			@if(Auth::user() && Auth::user()->canAttend($event))
			<!--Event Message-->
			<div id="event-message">
				<div id="message">
					<!--Payment Warning-->
					@if(Auth::user()->waitingToBeConfirmed($event))
						<li class="list-group-item event-action-btn">
							<b class="text-warning">Ödeme işleminin tamamlanması bekleniyor.</b>
						</li>
					@endif
				</div>
			</div>

			<!--Event Buttons Wrapper-->
			<div id="ebw">
				<!--Event Buttons-->
				<div id="eb">
					@if(Auth::user()->isAttending($event))
						<li id="qel" class="list-group-item text-center event-action-btn">
							<form action="/event/{{$event->id}}/quit" method="post" class="inline" id="quit-event" data-id="{{$event->id}}">
								<button type="submit" id="qeb">
									İptal Et <i class="fa fa-times" aria-hidden="true"></i>
								</button>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
							</form>
						</li>
					<!--Attend to Event-->
					@else
						<li id="ael" class="list-group-item text-center event-action-btn">
							<form action="/event/{{$event->id}}/add" method="post" class="inline" id="attend-event" data-id="{{$event->id}}">
								<div class="form-group inline">
									<button type="submit" id="aeb">
										Katıl <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
									</button>
									<input type="hidden" name="_token" value="{{csrf_token()}}">
								</div>
							</form>
						</li>
					@endif
				</div>
				<!--End of Event Buttons -->
			</div>
			<!--End of Buttons Wrapper-->
			@else
			<li class="list-group-item text-center div-warning event-action-btn">
				<b>Etkinliğe katılabilmek için bu kulübün üyesi olmanız lazım.</b>
			</li>
			@endif
		</ul>

	</div>

	<!--Middle Grid-->
	<div class="col-md-6">
		<!--Posting Status-->
		@if(Auth::user())
		<div id="sharing-wrapper">
			<div id="share">
				@if(Auth::user()->isConfirmed($event))
					<hr>
					@include('events.partials.posting')
				@endif
			</div>
		</div>
		@endif
		@if(count($statuses))
			<hr>
			<!--Statuses-->
			<h3 class="text-center"><b>Paylaşımlar</b></h3>
	        <section class="results">
                @include('statuses.load')
            </section>
	    @else
			<div class="container-fluid">
				<br>
				<p class="text-center text-danger">Henüz paylaşım yapılmamış.</p>
			</div>
		@endif
	</div><!--/ Middle Grid-->

	<div class="col-md-3">

		<!--Ask smthng to Admin Modal Button-->
		@if(Auth::check())
		<button class="btn btn-info btn-block hidden-sm hidden-xs" data-toggle="modal" data-target="#ask-to-admin">
			<i class="fa fa-comments" aria-hidden="true"></i> Organizatöre Soru Sor
		</button>
		@endif
		<!--Club-->
			<h3>Organizatör Kulüp</h3>
			@foreach($event->clubs()->get() as $club)
				@include('clubs.partials.clubblock')
			@endforeach

		<!--Admins-->
		p

		<!--Attenders-->
		<div id="attenders-wrapper">
			<div id="attenders">
				<h3>Katılımcılar</h3>
				<section class="attenders">
					@include('events.partials.pagination.attenders')
				</section>
			</div>
		</div>

	</div>

</div>

@endsection
