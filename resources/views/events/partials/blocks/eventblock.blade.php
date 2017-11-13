<div class="thumbnail">
	<a class="link" href="/event/{{$event->id}}">
		<img id="et-image" src="/storage/events/posters/min/{{$event->poster}}" >
	</a>
	<div class="row text-center" style="margin-top: -30px; margin-bottom: -20px">
		<a class="link" href="/club/{{$event->clubs()->first()->abbreviation}}">
			<img src="/storage/avatars/{{$event->clubs()->first()->avatar}}" style="width:75px; height:75px;" class="img-circle">
			<small class="text-muted">{{$event->clubs()->first()->name}}</small>
		</a>
	</div>
	<div class="caption">
		<a class="link" href="/event/{{$event->id}}"><h4>{{$event->name}}</h4></a>
		<p><b>Tarih:</b> {{date("d F Y",strtotime($event->date))}}</p>
			@if($event->price)
				<p><b>Ücret: </b> {{($event->price)}} ₺</p>
			@else
				<p><b>Ücretsiz</b></p>
			@endif
			<div>
				<p>
					<b><i class="fa fa-users" aria-hidden="true"></i></b>
					{{($event->attenders)}}
				</p>
			</div>
		@if( Auth::check() && Auth::user()->canAttend($event) )
		<div class="row">
			<div class="container-fluid">
				@if(Auth::user()->isConfirmed($event))
					<!--Delete Event if Admin-->
					@if(Auth::user()->isEventAdmin($event))
						<form action="/event/{{$event->id}}/delete" method="post" class="inline" id="delete-event-quick" data-id="{{$event->id}}">
							<div class="form-group inline">
								<button type="submit" class="btn btn-danger">
									Etkinliği Sil <i class="fa fa-trash" aria-hidden="true"></i>
								</button>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
							</div>
						</form>
					@else
						<form action="/event/{{$event->id}}/quit" method="post" class="inline" id="quit-event-quick" data-id="{{$event->id}}">
							<div class="form-group inline">
								<button type="submit" class="btn btn-danger">
									İptal Et <i class="fa fa-times" aria-hidden="true"></i>
								</button>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
							</div>
						</form>
					@endif
				@elseif(Auth::user()->waitingToBeConfirmed($event))
					<button class="btn btn-warning">
						Ödeme Bekleniyor <i class="fa fa-clock-o" aria-hidden="true"></i>
					</button>
				@else
				<form action="/event/{{$event->id}}/add" method="post" class="inline" id="attend-event-quick" data-id="{{$event->id}}">
					<div class="form-group inline">
						<button type="submit" class="btn btn-primary">
							Katıl <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
						</button>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
					</div>
				</form>
				@endif
				<a href="/event/{{$event->id}}" class="btn btn-info pull-right">
					Detaylar <i class="fa fa-info" aria-hidden="true"></i>
				</a>
			</div>
		</div>
		@else
		<div class="row">
			<div class="container-fluid">
				<a href="/event/{{$event->id}}" class="btn btn-info btn-block">
					Detaylar <i class="fa fa-info" aria-hidden="true"></i>
				</a>
			</div>
		</div>
		@endif
	</div>
</div>
