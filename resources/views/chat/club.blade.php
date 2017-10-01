@extends('templates.default')

@section('content')
	<div id="club-chat">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<!--Club block (vue component)-->
				<clubblock :club="{{$club}}"></clubblock>
			</div>
		</div>
	</div>
@endsection
