<div class="media">
    <div class="media-left media-top">
        <a class="pull-left" href="/user/{{$user->username}}">
            <img class="img-circle" alt=" {{ $user->getNameOrUsername() }} " src="/storage/avatars/{{$user->avatar}}" style="width:65px; height:65px;"/>
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading"><a href="/user/{{$user->username}}">{{ $user->getNameOrUsername() }}</a></h4>
	@if(Auth::check())
		@if(Auth::user()->isEventAdmin($event))
			@if(!$user->isEventAdmin($event))
				<form id="event-kick-user" class="inline" action="/event/{{$event->id}}/kick/{{$user->id}}" method="post">
					<button type="submit" class="btn btn-danger btn-sm">Çıkar</button>
					<input type="hidden" name="_token" value="{{csrf_token()}}">
				</form>
				<form id="event-make-admin" class="inline" action="/event/{{$event->id}}/make/admin/{{$user->id}}" method="post">
					<button type="submit" class="btn btn-warning btn-sm">Admin Yap</button>
					<input type="hidden" name="_token" value="{{csrf_token()}}">
				</form>
			@endif
		@endif
	@endif
    </div>
</div>
