@extends('templates.default')

@section('content')
	<div id="event-chat" class="chat">
		<!--Club block (vue component)-->
		<eventblock :user="{{$user}}" admin="{{Auth::user()->isEventAdmin($event)}}" :event="{{$event}}"></eventblock>
		<event-messages :empty="empty" :auth-id="{{Auth::user()->id}}" :user-id="{{$user->id}}" :messages="messages"></event-messages>
		<event-form id="chat-form" data-name="{{Auth::user()->getName()}}" :user-id="{{$user->id}}" :auth-id="{{Auth::user()->id}}" :event-id="{{$event->id}}" @messagesentuser="addMessageAsUser" @messagesentevent="addMessageAsAdmin"></event-form>
	</div>
@endsection
