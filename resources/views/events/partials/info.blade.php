<ul class="list-group">
	<!--Title-->
	<li class="list-group-item text-center"><h3>{{$event->name}}</h3></li>
	<!--Image-->
	<img src="/storage/events/posters/{{$event->poster}}" class="center-block" style=" max-width:100%; max-height:100%;">
	
	<!--Description-->
	@if($event->isDescLong())
	<li class="list-group-item white-space" id="description">{{$event->shortenDescript()}}<a class="link extend-desc" data-event-id="{{$event->id}}"> <i class="fa fa-chevron-down" aria-hidden="true"></i> Genişlet</a></li>
	@else
	<li class="list-group-item white-space" id="description">{{$event->description}}</li>
	@endif

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
	<li class="list-group-item">
		<b><i class="fa fa-users" aria-hidden="true"></i> Katılımcı:</b>{{$event->attenders}}
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
		@if(Auth::user()->waitingToBeConfirmed($event))
			<li class="list-group-item event-action-btn">
				<b class="text-warning">Ödeme işleminin tamamlanması bekleniyor.</b>
			</li>
		@endif

		<!--Event Buttons-->
		@if(Auth::user()->isAttending($event))
			@if(Auth::user()->isEventAdmin($event))
				<li id="qel" class="list-group-item text-center event-action-btn">
					<form action="/event/{{$event->id}}/delete" method="post" class="inline" id="delete-event" data-id="{{$event->id}}">
						<button type="submit" id="qeb">
							Etkinliği Sil <i class="fa fa-trash" aria-hidden="true"></i>
						</button>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
					</form>
				</li>
			@else
				<li id="qel" class="list-group-item text-center event-action-btn">
					<form action="/event/{{$event->id}}/quit" method="post" class="inline" id="quit-event" data-id="{{$event->id}}">
						<button type="submit" id="qeb">
							İptal Et <i class="fa fa-times" aria-hidden="true"></i>
						</button>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
					</form>
				</li>
			@endif
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
	<!--End of Event Buttons -->
	@else
		@if($event->isAttenderLimitReached())
			<li class="list-group-item text-center div-disabled event-action-btn">
				<b>Katılımcı limitine ulaşıldı.</b>
			</li>
		@else
			<li class="list-group-item text-center div-warning event-action-btn">
				<b>Etkinliğe katılabilmek için bu kulübün üyesi olmanız lazım.</b>
			</li>
		@endif
	@endif
</ul>