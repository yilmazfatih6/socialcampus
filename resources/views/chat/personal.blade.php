@extends('templates.default')

@section('content')
	<div id="personal-chat" class="row chat">
		<userblock :user="{{$user}}"></userblock>
        <chat-messages :auth-id="{{Auth::user()->id}}" :messages="messages"></chat-messages>
	    <chat-form id="chat-form" @messagesent="addMessage" :auth-id="{{ Auth::user()->id }}" :user-id="{{$user->id}}"></chat-form>
	</div>
@endsection
