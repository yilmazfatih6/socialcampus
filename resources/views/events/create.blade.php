@extends('templates.default')

@section('header')
	<div class="row text-center" style="background-image:url('/storage/covers/{{$club->cover}}'); margin-top:-20px; padding:25px 0;">
        	<div class="col-lg-12">
        		<!--Club Avatar Media-->
        		<img class="img-circle" src="/storage/avatars/{{$club->avatar}}" style="width:150px; height:auto; border: 3px solid white;">
        	</div>
	</div><br>
@endsection
@section('content')

	@if(Auth::user() && Auth::user()->isAdmin($club))
		<div class="container">
			<div class="row">

				<div class="col-lg-5 ">
					<h3 class="text-center"><b>Etkinlik Oluşturma Hakkında</b></h3><hr>
					<p>Etkinlik Oluşturma hakkında...</p>
					<p>İşte buraya etkinlik oluşturma nedir, ne değildir, koşullar nelerdir falan yazılacak.</p>
				</div>

				<div class="col-lg-6">
					<h3 class="text-center"><b>{{$club->name}} İçin Etkinlik Oluştur</b></h3><hr>
					<form role="form" enctype="multipart/form-data" method="post" action="/event/create/{{$club->abbreviation}}">
						<!--Event Name-->
						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="control-label">Etkinlik Adı*</label>
							<input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" required>
							@if($errors->has('name'))
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>

						<!--Event Description-->
						<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
							<label for="description" class="control-label">Etkinlik Açıklaması*</label>
							<textarea class="form-control" name="description" rows="10" id="description" required>{{old('description')}}</textarea>
							@if($errors->has('description'))
								<span class="help-block">{{ $errors->first('description') }}</span>
							@endif
						</div>

						<!--Event Time-->
						<div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
							<label for="date" class="control-label">Etkinlik Tarihi*</label>
							<input type="date" class="form-control" name="date" value="{{old('date')}}" required>
							@if($errors->has('date'))
								<span class="help-block">{{ $errors->first('date') }}</span>
							@endif
							<small class="form-text text-muted">
							Tarih seçimi Firefox, Internet Explorer 11 ve önceki sürümlerinde desteklenmemektedir. Lütfen bu işlemi kullanmak için başka bir tarayıcı kullanınız.
							</small>
						</div>

						<!--Event Starting Hour-->
						<div class="form-group{{ $errors->has('hour') ? ' has-error' : '' }}">
							<label for="hour" class="control-label">Etkinlik Başlangıç Saati*</label>
							<input type="time" class="form-control" name="hour" value="{{old('hour')}}" required>
							@if($errors->has('hour'))
								<span class="help-block">{{ $errors->first('hour') }}</span>
							@endif
							<small class="form-text text-muted">
							Saat seçimi Firefox, Internet Explorer 12 ve önceki sürümlerinde desteklenmemektedir. Lütfen bu işlemi kullanmak için başka bir tarayıcı kullanınız.
							</small>
						</div>

						<!--Deadline-->
						<div class="form-group{{ $errors->has('deadline') ? ' has-error' : '' }}">
							<label for="deadline" class="control-label">Etkinliğe Son Katılım Tarihi</label>
							<input type="date" class="form-control" name="deadline" value="{{old('deadline')}}">
							@if($errors->has('deadline'))
								<span class="help-block">{{ $errors->first('deadline') }}</span>
							@endif
							<small class="form-text text-muted">
								Son katılım tarihi koymak istemiyorsanız bu alanı boş bırakınız.
							</small>
						</div><!--/Deadline-->

						<!--Attender Limit-->
						<div class="form-group{{ $errors->has('attender_limit') ? ' has-error' : '' }}">
							<label for="attender_limit" class="control-label">Katılımcı Limiti</label>
							<input type="number" id="attender_limit" class="form-control" name="attender_limit" value="{{old('attender_limit')}}">
							@if($errors->has('attender_limit'))
								<span class="help-block">{{ $errors->first('attender_limit') }}</span>
							@endif
							<small class="text-muted">
								Etkinliğinizde katılımcı limiti yoksa bu alanı boş bırakınız.
							</small>
						</div>

						<!--Event Price-->
						<label for="price" class="control-label">Katılım Ücreti</label>
						<div class="input-group{{ $errors->has('price') ? ' has-error' : '' }}">
							<span class="input-group-addon">₺</span>
							<input type="number" id="price" class="form-control" name="price" value="{{old('price')}}">
							@if($errors->has('price'))
								<span class="help-block">{{ $errors->first('price') }}</span>
							@endif
						</div>
						<small class="text-muted">Etkinliğiniz ücretsiz ise bu alanı boş bırakınız.</small>
						<br><br>

						<!--Phone Number-->
						<div class="form-group{{ $errors->has('contact') ? ' has-error' : '' }}">
							<label for="contact" class="control-label">İletişim Telefon Numarası</label>
							<input type="number" id="contact" class="form-control" name="contact" value="{{old('contact')}}">
							@if($errors->has('contact'))
								<span class="help-block">{{ $errors->first('contact') }}</span>
							@endif
							<small class="form-text text-muted">Örn: 53xxxxxxxx</small>
							<small class="form-text text-muted">İletişim telefon numarası yok ise bu alanı boş bırakınız.</small>
						</div><!--/ Phone Number-->

						<!--Secondary Phone Number-->
						<div class="form-group{{ $errors->has('contact_2') ? ' has-error' : '' }}">
							<label for="contact_2" class="control-label">Alternatif İletişim Telefon Numarası</label>
							<input type="number" id="contact_2" class="form-control" name="contact_2" value="{{old('contact_2')}}">
							@if($errors->has('contact_2'))
								<span class="help-block">{{ $errors->first('contact_2') }}</span>
							@endif
							<small class="form-text text-muted">Örn: 53xxxxxxxx</small>
							<small class="form-text text-muted">Alternatif iletişim telefon numarası yok ise bu alanı boş bırakınız.</small>
						</div><!--/ Secondary Phone Number-->

						<!--Sharing Image-->
						<div class="form-group{{$errors->has('poster') ? ' has-error' : ''}}" style="display: inline; margin-right:5px;">
							<label>Etkinlik Posteri</label><br>
							<label for="poster" class="file-select">
								<span class="glyphicon glyphicon-camera"></span> Seç
							</label>
							<input type="file" name="poster" accept="image/*" id="poster" class="hidden file-input">
							<small class="file-name"></small>
							@if($errors->has('poster'))
								<span class="help-block">{{$errors->first('poster')}}</span>
							@endif
						</div><!--/ Sharing Image-->
						<br><br>
						<div class="form-group">
							<button type="submit" class="btn btn-success btn-block">Etkinliği Oluştur</button>
						</div>
			     			<input type="hidden" name="_token" value="{{ Session::token() }}"/>
					</form>
				</div>
			</div>
		</div>
	@endif
	@endsection
