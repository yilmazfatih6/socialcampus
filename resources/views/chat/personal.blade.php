@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<!--User Info-->
			<userblock :user="{{$user}}"></userblock>

			<!--Message Lists-->
	        <chat-messages :auth-id="{{Auth::user()->id}}" :messages="messages" style="height:80vh"></chat-messages>

	        <!--Input-->
	        <chat-form @messagesent="addMessage" :user="{{ Auth::user() }}"></chat-form>
		</div>
	</div>

@endsection
