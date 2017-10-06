@extends('templates.default')

@section('content')
	<div id="event-chat">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<!--Club block (vue component)-->
				<eventblock :event="{{$event}}"></eventblock>
				<event-messages :empty="empty" :auth-id="{{Auth::user()->id}}" :user-id="{{$user->id}}" :messages="messages"></event-messages>
				<event-form data-name="{{Auth::user()->getName()}}" :user-id="{{$user->id}}" :auth-id="{{Auth::user()->id}}" :event-id="{{$event->id}}" @messagesentuser="addMessageAsUser" @messagesentevent="addMessageAsAdmin"></event-form>
			</div>
		</div>
	</div>
@endsection
