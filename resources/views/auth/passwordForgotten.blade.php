@extends('templates.default')

@section('content')
	<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">Şifreni Sıfırla</h2><hr>
            <form role="form" action="/password/forgotten" method="post">
            	<div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
    	        	<label for="email">Emailiniz</label>
					<input type="email" id="email" name="email" class="email form-control" placeholder="Email hesabınız">
					@if($errors->has('email'))
	            		<span class="help-block">{{ $errors->first('email') }}</span>
	        		@endif
					<small>Siteye kayıtlı olduğunuz email adresini girin. Bu email adresine şifrenizi sıfırlamanız için email atacağız.</small>
           		</div>
           		<button type="submit" class="btn btn-info btn-block">Gönder</button>
            	{{csrf_field()}}
            </form>
        </div>
	</div>       
@endsection