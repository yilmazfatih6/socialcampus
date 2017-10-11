@extends('templates.default')

@section('content')
	<form role="form" action="/foo" method="post" enctype="multipart/form-data">
		<!--Sharing Image-->
		<div class="form-group{{$errors->has('image') ? ' has-error' : ''}} inline">
			<label>Foto</label><br>
			<label for="image" class="file-select">
				<span class="glyphicon glyphicon-camera"></span> Seç
			</label>
			<input type="file" name="image" accept="image/*" id="image" class="hidden file-input">
			<small class="file-name"></small>
			@if($errors->has('image'))
				<span class="help-block">{{$errors->first('image')}}</span>
			@endif
		</div><!--/ Sharing Image-->
		<div class="form-group">
			<button type="submit" class="btn btn-success btn-block">Sal</button>
		</div>
		<input type="hidden" name="_token" value="{{ Session::token() }}"/>
	</form>
@endsection