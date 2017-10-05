@extends('templates.default')

@section('content')
	<div id="club-chat">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<!--Club block (vue component)-->
				<clubblock :club="{{$club}}"></clubblock>
				<club-messages :empty="empty" :auth-id="{{Auth::user()->id}}" :user-id="{{$user->id}}" :messages="messages"></club-messages>
				<club-form data-name="{{Auth::user()->getName()}}" :user-id="{{$user->id}}" :auth-id="{{Auth::user()->id}}" :club-id="{{$club->id}}" @messagesentuser="addMessageAsUser" @messagesentclub="addMessageAsClub"></club-form>
			</div>
		</div>
	</div>
@endsection
