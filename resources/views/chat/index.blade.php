@extends('templates.default')

@section('content')
	<div id="personal-chat">
		@include('chat.partials.modals')
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<button class="btn btn-success btn-sm btn-block margin-bottom-ten" data-toggle="modal" data-target="#select">
					<i class="fa fa-plus" aria-hidden="true"></i> Yeni Sohbet Oluştur
				</button>
				@if(!empty($users))
					<users :users="{{$users}}"></users>
				@else
					<div class="text-center">
						<small>Henüz hiç mesajınız yok.</small>
					</div>
				@endif
			</div>
		</div>
	</div>

@endsection
