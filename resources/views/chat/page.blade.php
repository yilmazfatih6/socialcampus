@extends('templates.default')

@section('content')
	<div id="page-chat">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<!--Club block (vue component)-->
				<pageblock :page="{{$page}}"></pageblock>
				<page-messages :empty="empty" :auth-id="{{Auth::user()->id}}" :user-id="{{$user->id}}" :messages="messages"></page-messages>
				<page-form data-name="{{Auth::user()->getName()}}" :user-id="{{$user->id}}" :auth-id="{{Auth::user()->id}}" :page-id="{{$page->id}}" @messagesentuser="addMessageAsUser" @messagesentpage="addMessageAsPage"></page-form>
			</div>
		</div>
	</div>
@endsection
