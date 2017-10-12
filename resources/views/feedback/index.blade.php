@extends('templates.default')

@section('content')
	
	<div class="col-md-6 col-md-offset-3">
		<h2 class="text-center"><b>Geri Bildirim Gönder</b></h2>
		@if(Auth::check())
			<form id="send-feedback-auth" class="send-feedback" action="/feedback/auth/send" method="post">
				<div class="form-group">
					<label for="title">Başlık</label><small> (Tercihen)</small>
					<input class="form-control" name="title" id="title" placeholder="Başlık şu..."></textarea>
				</div>

				<div class="form-group">
					<label for="body">Geri Bildirim</label><small> (Zorunlu)</small>
					<textarea class="form-control" name="body" id="body" cols="30" rows="10" placeholder="Geri bildirimim şu..."></textarea>
				</div>

				<button type="submit" class="btn btn-success btn-block">Gönder</button>
				{{csrf_field()}}
			</form>
		@else
			<form id="send-feedback" class="send-feedback" action="/feedback/send" method="post">
				<div class="form-group">
					<label for="title">Başlık</label><small> (Tercihen)</small>
					<input class="form-control" name="title" id="title" placeholder="Başlık şu..."></textarea>
				</div>

				<div class="form-group">
					<label for="body">Geri Bildirim</label><small> (Zorunlu)</small>
					<textarea class="form-control" name="body" id="body" cols="30" rows="10" placeholder="Geri bildirimim şu..."></textarea>
				</div>

				<button type="submit" class="btn btn-success btn-block">Gönder</button>
				{{csrf_field()}}
			</form>
		@endif
	</div>

@endsection