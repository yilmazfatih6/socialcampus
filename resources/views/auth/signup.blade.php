@extends('templates.default')

@section('content')
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><b>Kayıt Ol</b></h1><br/>
            <form class="form-vertical" id="signup-form" role="form" method="post" action="/signup">
                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label for="first_name" class="control-label">Ad*</label>
                    <input type="text" name="first_name" class="form-control" id="first_name" value="{{ Request::old('first_name') ?: ''}}" required>
                    @if ($errors->has('first_name'))
                        <span class="help-block">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <label for="last_name" class="control-label">Soyad*</label>
                    <input type="text" name="last_name" class="form-control" id="last_name" value="{{ Request::old('last_name') ?: ''}}">
                    @if ($errors->has('last_name'))
                        <span class="help-block">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for="username" class="control-label">Kullanıcı Adı*</label>
                    <input type="text" name="username" class="form-control" id="username" value="{{ Request::old('username') ?: ''}}">
                    @if ($errors->has('username'))
                        <span class="help-block">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">Email*</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ Request::old('email') ?: ''}}">
                    @if ($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="control-label">Şifre*</label>
                    <input type="password" name="password" class="form-control" id="password" value="">
                    @if ($errors->has('password'))
                        <span class="help-block">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password-confirm" class="control-label">Şifre Tekrarı*</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password-confirm" value="">
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block">Kayıt Ol</button>
                </div>

                <input type="hidden" name="_token" value="{{Session::token()}}">
            </form>
            <br>
            <br>
            <br>
            <br>
        </div>
     </div>
</div>
@endsection
