@extends('templates.default')

@section('content')
<div class="row">
	<div class="col-lg-6">
			<h2>Kulüp Sayfası Oluştur</h2>
			<div class="alert alert-warning" role="alert">
				<p>Kulüp sayfası oluşturma koşulları</p>
			</div>
	</div>
	<div class="col-lg-5">
		<form method="post" action="{{ route('clubs.create') }}" role="form" class="form-vertical">
			<h3>Kulüp Genel Bilgileri</h3>
			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	          <label for="name" class="control-label">Kulüp Adı*</label>
	          <input type="text" name="name" class="form-control" id="name" value="{{ Request::old('name') ?: ''}}" required>
	          @if ($errors->has('name'))
	              <span class="help-block">{{ $errors->first('name') }}</span>
	          @endif
	   	    </div>

			<div class="form-group{{ $errors->has('abbreviation') ? ' has-error' : '' }}">
				<label for="abbreviation" class="control-label">Kısaltması*</label>
				<input type="text" name="abbreviation" class="form-control" id="abbreviation" value="{{ Request::old('abbreviation') ?: ''}}" required>
				@if ($errors->has('abbreviation'))
					<span class="help-block">{{ $errors->first('abbreviation') }}</span>
				@endif
			</div>

			<div class="form-group{{ $errors->has('club_type') ? ' has-error' : '' }}">
          			<label for="club_type" class="control-label">Kulübün Türü</label>
				<select class="form-control" name="club_type" id="club_type" required>
					<option @if (old('club_type') == null) selected="selected" @endif  disabled >Bir Tür Seçin</option>
					<option @if (old('club_type') == 'Sosyoloji') selected="selected" @endif >Biyoloji</option>
					<option @if (old('club_type') == 'Edebiyat') selected="selected" @endif >Edebiyat</option>
					<option @if (old('club_type') == 'Eğlence') selected="selected" @endif >Eğlence</option>
					<option @if (old('club_type') == 'Felsefe') selected="selected" @endif >Felsefe</option>
					<option @if (old('club_type') == 'Fotoğrafçılık') selected="selected" @endif >Fotoğrafçılık</option>
					<option @if (old('club_type') == 'Hukuk') selected="selected" @endif >Hukuk</option>
					<option @if (old('club_type') == 'İktisat') selected="selected" @endif >İktisat</option>
					<option @if (old('club_type') == 'İşletme') selected="selected" @endif >İşletme</option>
					<option @if (old('club_type') == 'Mühendislik') selected="selected" @endif >Mühendislik</option>
					<option @if (old('club_type') == 'Politik') selected="selected" @endif >Politik</option>
					<option @if (old('club_type') == 'Müzik') selected="selected" @endif >Müzik</option>
					<option @if (old('club_type') == 'Sağlık') selected="selected" @endif >Sağlık</option>
					<option @if (old('club_type') == 'Sanat') selected="selected" @endif >Sanat</option>
					<option @if (old('club_type') == 'Sinema ve Televizyon') selected="selected" @endif >Sinema ve Televizyon</option>
					<option @if (old('club_type') == 'Siyaset Bilimi') selected="selected" @endif >Siyaset Bilimi</option>
					<option @if (old('club_type') == 'Sosyal Yardımlaşma') selected="selected" @endif >Sosyal Yardımlaşma</option>
					<option @if (old('club_type') == 'Sosyoloji') selected="selected" @endif >Sosyoloji</option>
					<option @if (old('club_type') == 'Spor') selected="selected" @endif >Spor</option>
					<option @if (old('club_type') == 'Tarih') selected="selected" @endif >Tarih</option>
					<option @if (old('club_type') == 'Teoloji') selected="selected" @endif >Teoloji</option>
					<option @if (old('club_type') == 'Tıp') selected="selected" @endif >Tıp</option>
					<option @if (old('club_type') == 'Tiyatro') selected="selected" @endif >Tiyatro</option>
					<option @if (old('club_type') == 'Turizm') selected="selected" @endif >Turizm</option>
					<option @if (old('club_type') == 'Uluslararası İlişkiler') selected="selected" @endif >Uluslararası İlişkiler</option>
				</select>
				@if ($errors->has('club_type'))
				    <span class="help-block">{{ $errors->first('club_type') }}</span>
				@endif
	  	  	</div>

			<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
	          	<label for="description" class="control-label">Açıklama</label>
	        	<textarea class="form-control" placeholder="Kulüp hakkında bazı açıklamalar yaz." name="description" class="form-control" id="description" rows="10">{{old('description')}}</textarea>
	          	@if ($errors->has('description'))
	            	<span class="help-block">{{ $errors->first('description') }}</span>
	          	@endif
		    </div>

			<h3>Kulüp İletişim Bilgileri</h3>
			<div class="form-group{{$errors->has('fb_url') ? ' has-error' : ''}}">
				<label for="fb_url" class="control-label">Facebook Sayfası Linki</label>
				<input type="url" name="fb_url" class="form-control" id="fb_url" value="{{Request::old('fb_url') ?: ''}}">
				<small class="text-muted">Örn: http://www.facebook.com</small>
				@if($errors->has('fb_url'))
						<span class="help-block">{{$errors->first('fb_url')}}</span>
				@endif
			</div>

			<div class="form-group{{$errors->has('twitter_url') ? ' has-error' : ''}}">
				<label for="twitter_url" class="control-label">Twitter Sayfası Linki</label>
				<input type="url" name="twitter_url" class="form-control" id="twitter_url" value="{{Request::old('twitter_url') ?: ''}}">
				<small class="text-muted">Örn: http://www.twitter.com</small>
				@if($errors->has('twitter_url'))
						<span class="help-block">{{$errors->first('twitter_url')}}</span>
				@endif
			</div>

			<div class="form-group{{$errors->has('insta_url') ? ' has-error' : ''}}">
				<label for="insta_url" class="control-label">Instagram Sayfası Linki</label>
				<input type="url" name="insta_url" class="form-control" id="insta_url" value="{{Request::old('insta_url') ?: ''}}">
				<small class="text-muted">Örn: http://www.instagram.com</small>
				@if($errors->has('insta_url'))
					<span class="help-block">{{$errors->first('insta_url')}}</span>
				@endif
			</div>

			<div class="form-group">
					<p class="text-danger">*gerekli alanlar</p>
			</div>

			<div class="form-group">
					<button type="submit" class="btn btn-success">Talebi Gönder</button>
			</div>

			<input type="hidden" name="_token" value="{{Session::token()}}">
		</form>
	</div>
</div>
@endsection
