@extends('templates.default')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-5 ">
				<h2><b>Sayfa Oluşturma Hakkında</b></h2>
				<div class="alert alert-warning" role="alert">
						<p>Medeniyet Sosyal Sayfalar'a hoşgeldin</p>
				</div>
			</div>
			<div class="col-lg-6">
				<form method="post" action="/page/create" role="form" class="form-vertical">
					
					<h3><b>Kulüp Genel Bilgileri</b></h3>
					<!--Page Name-->
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			          <label for="name" class="control-label">Sayfa Adı*</label>
			          <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
			          @if ($errors->has('name'))
			              <span class="help-block">{{ $errors->first('name') }}</span>
			          @endif
			   	    </div>

				    <div class="form-group{{ $errors->has('abbr') ? ' has-error' : '' }}">
			            <label for="abbr" class="control-label">Kısaltması*</label>
			          	<input type="text" name="abbr" class="form-control" id="abbr" value="{{ old('abbr') }}" required>
			          	@if ($errors->has('abbr'))
			              	<span class="help-block">{{ $errors->first('abbr') }}</span>
			          	@endif
				    </div>

					<div class="form-group{{ $errors->has('genre') ? ' has-error' : '' }}">
			          	<label for="genre" class="control-label">Sayfa Türü*</label>
						<select class="form-control" name="genre" id="genre" value="{{ old('genre') }}" required>
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
							<option @if (old('club_type') == 'Tarih') selected="selected" @endif >Tarih</option>
							<option @if (old('club_type') == 'Teoloji') selected="selected" @endif >Teoloji</option>
							<option @if (old('club_type') == 'Tıp') selected="selected" @endif >Tıp</option>
							<option @if (old('club_type') == 'Tiyatro') selected="selected" @endif >Tiyatro</option>
							<option @if (old('club_type') == 'Turizm') selected="selected" @endif >Turizm</option>
							<option @if (old('club_type') == 'Uluslararası İlişkiler') selected="selected" @endif >Uluslararası İlişkiler</option>
						</select>
				        @if ($errors->has('genre'))
				            <span class="help-block">{{ $errors->first('genre') }}</span>
				        @endif
			  	  	</div>

					<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
			          	<label for="description" class="control-label">Açıklama</label>
			        	<textarea class="form-control" placeholder="Kulüp hakkında bazı açıklamalar yaz." name="description" class="form-control" id="description">{{old('description')}}</textarea>
			          	@if ($errors->has('description'))
			            	<span class="help-block">{{ $errors->first('description') }}</span>
			          	@endif
				    </div>

					<h3><b>Sayfa Sosyal Medya Hesapları</b></h3>
					<div class="form-group{{$errors->has('fb_url') ? ' has-error' : ''}}">
						<label for="fb_url" class="control-label">Facebook Sayfası Linki</label>
						<input type="url" name="fb_url" class="form-control" id="fb_url" value="{{old('fb_url') }}">
						@if($errors->has('fb_url'))
								<span class="help-block">{{$errors->first('fb_url')}}</span>
						@endif
					</div>

					<div class="form-group{{$errors->has('twitter_url') ? ' has-error' : ''}}">
						<label for="twitter_url" class="control-label">Twitter Sayfası Linki</label>
						<input type="url" name="twitter_url" class="form-control" id="twitter_url" value="{{ old('twitter_url') }}">
						@if($errors->has('twitter_url'))
								<span class="help-block">{{$errors->first('twitter_url')}}</span>
						@endif
					</div>

					<div class="form-group{{$errors->has('insta_url') ? ' has-error' : ''}}">
						<label for="insta_url" class="control-label">Instagram Sayfası Linki</label>
						<input type="url" name="insta_url" class="form-control" id="insta_url" value="{{ old('insta_url') }}">
						@if($errors->has('insta_url'))
							<span class="help-block">{{$errors->first('insta_url')}}</span>
						@endif
					</div>

					<h3><b>Sayfa Yönetimi Şifresi</b></h3>
					<div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
				        <label for="password" class="control-label">Şifre*</label>
				        <input type="password" name="password" class="form-control" id="password" required>
				        @if ($errors->has('password'))
				            <span class="help-block">{{$errors->first('password')}}</span>
				        @endif
				    </div>

					<div class="form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}">
				        <label for="password-confirm" class="control-label">Şifre Tekrarı*</label>
				        <input type="password" name="password_confirmation" class="form-control" id="password-confirm" required>
				        @if ($errors->has('password_confirmation'))
				            <span class="help-block">{{$errors->first('password_confirmation')}}</span>
				        @endif
				    </div>

					<div class="form-group">
							<p class="text-danger">*gerekli alanlar</p>
					</div>

					<div class="form-group">
							<button type="submit" class="btn btn-success">Sayfayı Oluştur</button>
					</div>

					<input type="hidden" name="_token" value="{{Session::token()}}">
				</form>
			</div>
		</div>		
	</div>	
@endsection