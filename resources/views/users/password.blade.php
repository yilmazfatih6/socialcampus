@extends('templates.default')

@section('content')
<div class="container">
    <h2>Şifreni Değiştir</h2><br>
    <div class="row">
        <div class="col-lg-8">
            <form class="form-vertical" role="form" method="post" action"{{ route('profile.editPassword') }}">
                <!--Row Starts-->
                <!-- <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group{{ $errors->has('current_password') ? ' has-error': '' }}">
                            <label for="current_password" class="control-label">Geçerli Şifre</label>
                            <input type="password" name="current_password" class="form-control" id="current_password" value="">
                            @if($errors->has('current_password'))
                                <span class="help-block">{{ $errors->first('current_password') }}</span>
                            @endif
                        </div>
                    </div>
                </div> -->
                <!--Row Ends-->
                <!--Row Starts-->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group{{ $errors->has('password') ? ' has-error': '' }}">
                            <label for="password" class="control-label">Yeni Şifre</label>
                            <input type="password" name="password" class="form-control" id="password" value="">
                            @if($errors->has('password'))
                                <span class="help-block">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <!--Row Ends-->
                <!--Row Starts-->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}">
                            <label for="password-confirm" class="control-label">Yeni Şifre Tekrarı</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password-confirm" value="">
                            @if($errors->has('password_confirmation'))
                                <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <!--Row Ends-->
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Güncelle</button>
                </div>
                <input type="hidden" name="_token" value="{{Session::token()}}"/>
            </form>
        </div>
    </div>
</div>    
@stop
