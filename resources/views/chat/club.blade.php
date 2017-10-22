@extends('templates.default')

@section('content')
	<div id="club-chat" class="chat">
		<!--Club block (vue component)-->
		<clubblock :user="{{$user}}" admin="{{ Auth::user()->isAdmin($club) }}" :club="{{$club}}"></clubblock>
		<club-messages :empty="empty" :auth-id="{{Auth::user()->id}}" :user-id="{{$user->id}}" :messages="messages"></club-messages>
		<club-form id="chat-form" data-name="{{Auth::user()->getName()}}" :user-id="{{$user->id}}" :auth-id="{{Auth::user()->id}}" :club-id="{{$club->id}}" @messagesentuser="addMessageAsUser" @messagesentclub="addMessageAsClub"></club-form>
	</div>
@endsection
