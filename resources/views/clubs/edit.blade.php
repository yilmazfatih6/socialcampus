@extends('templates.default')

@section('content')
<div class="container">
    <div class="row">
    	<div class="col-md-6 col-md-offset-3">
		<form method="post" action="/club/{{$club->abbreviation}}/edit" role="form" class="form-vertical">
                                <h2 class="text-center"><b>{{$club->name}} Kulüp Bilgileri</b></h2><hr>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Kulüp Adı*</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{$club->name}}" required>
                                    @if ($errors->has('name'))
                                    <span class="help-block">{{$errors->first('name')}}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('abbreviation') ? ' has-error' : '' }}">
                                    <label for="abbreviation" class="control-label">Kısaltması*</label>
                                    <input type="text" name="abbreviation" class="form-control" id="abbreviation" value="{{$club->abbreviation}}" required>
                                    @if ($errors->has('abbreviation'))
                                    <span class="help-block">{{ $errors->first('abbreviation') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('club_type') ? ' has-error' : '' }}">
                                    <label for="club_type" class="control-label">Kulübün Türü*</label>
                                    <select class="form-control" name="club_type" id="club_type" value="{{$club->club_type}}" required>
                                        <option @if (old('club_type') == null) selected="selected" @endif disabled >Bir Tür Seçin</option>
                                        <option @if ($club->club_type == 'Edebiyat') selected="selected" @endif>Edebiyat</option>
                                        <option @if ($club->club_type == 'Eğlence') selected="selected" @endif>Eğlence</option>
                                        <option @if ($club->club_type == 'Din') selected="selected" @endif>Din</option>
                                        <option @if ($club->club_type == 'Mühendislik') selected="selected" @endif>Mühendislik</option>
                                        <option @if ($club->club_type == 'Sağlık') selected="selected" @endif>Sağlık</option>
                                        <option @if ($club->club_type == 'Sanat') selected="selected" @endif>Sanat</option>
                                        <option @if ($club->club_type == 'Siyaset') selected="selected" @endif>Siyaset</option>
                                        <option @if ($club->club_type == 'Tıp') selected="selected" @endif>Tıp</option>
                                        <option @if ($club->club_type == 'Sosyal Yardımlaşma') selected="selected" @endif>Sosyal Yardımlaşma</option>
                                    </select>
                                    @if ($errors->has('club_type'))
                                        <span class="help-block">{{ $errors->first('club_type') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description" class="control-label">Açıklama</label>
                                    <textarea class="form-control" placeholder="Bu kulüp hakkında bir şeyler yaz..." name="description" class="form-control" id="description" rows="10">{{$club->description}}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>

    			<h3 class="text-center"><b>Kulüp İletişim Bilgileri</b></h3>
    			<div class="form-group{{$errors->has('fb_url') ? ' has-error' : ''}}">
    				<label for="" class="control-label">Facebook Sayfası Linki</label>
    				<input type="text" name="fb_url" class="form-control" id="fb_url" value="{{$club->fb_url}}">
    				@if($errors->has('fb_url'))
    						<span class="help-block">{{$errors->first('fb_url')}}</span>
    				@endif
    			</div>

    			<div class="form-group{{$errors->has('twitter_url') ? ' has-error' : ''}}">
    				<label for="twitter_url" class="control-label">Twitter Sayfası Linki</label>
    				<input type="text" name="twitter_url" class="form-control" id="twitter_url" value="{{$club->twitter_url}}">
    				@if($errors->has('twitter_url'))
    						<span class="help-block">{{$errors->first('twitter_url')}}</span>
    				@endif
    			</div>

    			<div class="form-group{{$errors->has('insta_url') ? ' has-error' : ''}}">
    				<label for="insta_url" class="control-label">Instagram Sayfası Linki</label>
    				<input type="text" name="insta_url" class="form-control" id="insta_url" value="{{$club->insta_url}}">
    				@if($errors->has('insta_url'))
    						<span class="help-block">{{$errors->first('insta_url')}}</span>
    				@endif
    			</div>

    			<div class="form-group">
				<p class="text-danger">*gerekli alanlar</p>
    			</div>

    			<div class="form-group">
				<button type="submit" class="btn btn-info btn-block">Güncelle</button>
    			</div>

    			<input type="hidden" name="_token" value="{{Session::token()}}"><br><br>
    		</form>
    	</div>
    </div>
</div>
@endsection
