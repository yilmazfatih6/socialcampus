@extends('templates.rawDefault')

@section('content')
    <div class="container" style="padding:0px;">
		<div id="personal-chat" class="row">
			<div class="col-md-6 col-md-offset-3">
				<userblock :user="{{$user}}"></userblock>
		        <chat-messages :auth-id="{{Auth::user()->id}}" :messages="messages"></chat-messages>
			    <chat-form @messagesent="addMessage" :auth-id="{{ Auth::user()->id }}" :user-id="{{$user->id}}"></chat-form>
			</div>
		</div>
	</div>
@endsection
