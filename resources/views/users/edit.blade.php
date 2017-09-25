@extends('templates.default')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <h2>Profilini Güncelle</h2><br>
            <form class="form-vertical" role="form" method="post" action="/profile/edit/{{Auth::user()->username}}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error': '' }}">
                            <label for="first_name" class="control-label">Ad</label>
                            <input type="text" name="first_name" class="form-control" id="first_name" value="{{Request::old('first_name') ?: Auth::user()->first_name}}">
                            @if($errors->has('first_name'))
                                <span class="help-block">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group{{$errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="control-label">Soyad</label>
                            <input type="text" name="last_name" class="form-control" id="last_name" value="{{Request::old('last_name') ?: Auth::user()->last_name}}">
                            @if($errors->has('last_name'))
                                <span class="help-block">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group{{$errors->has('username') ? ' has-error' : ''}}">
                            <label for="username" class="control-label">Kullanıcı Adı</label>
                            <input type="text" name="username" class="form-control" id="username" value="{{Request::old('username') ?: Auth::user()->username}}">
                            @if($errors->has('username'))
                                <span class="help-block">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                          <label for="email" class="control-label">Email</label>
                          <input type="text" name="email" class="form-control" id="email" value="{{Request::old('email') ?: Auth::user()->email}}">
                          @if($errors->has('email'))
                              <span class="help-block">{{ $errors->first('email') }}</span>
                          @endif
                      </div>
                    </div>
                </div>

                <!--Departments-->
                @include('templates.partials.departmentsForEdit')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group{{$errors->has('password') ? ' has-error': ''}}">
                            <label for="password" class="control-label">Şifreni Onayla*</label>
                            <input type="password" name="password" class="form-control" id="password" value="" required>
                            @if($errors->has('password'))
                                <span class="help-block">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
                <input type="hidden" name="_token" value="{{Session::token()}}"/>
            </form>
        </div>
    </div>
</div>
@stop
