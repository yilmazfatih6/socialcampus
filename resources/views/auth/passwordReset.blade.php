@extends('templates.default')

@section('content')
	<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">Şifreni Sıfırla</h2><hr>
            <form role="form" action="/password/reset/{{$token}}" method="post">
                <!--Password-->
            	<div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
    	        	<label for="password">Yeni Şifreniz</label>
					<input type="password" id="password" name="password" class="password form-control" placeholder="Yeni Şifreniz">
					@if($errors->has('password'))
	            		<span class="help-block">{{ $errors->first('password') }}</span>
	        		@endif
           		</div>
                <!--Password Confirm-->
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : ''}}">
                    <label for="password-confirm">Yeni Şifrenizin Tekrarı</label>
                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Yeni Şifrenizin Tekrarı">
                    @if($errors->has('password_confirmation'))
                        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
           		<button type="submit" class="btn btn-info btn-block">Şifreyi Değiştir</button>
            	{{csrf_field()}}
            </form>
        </div>
	</div>       
@endsection