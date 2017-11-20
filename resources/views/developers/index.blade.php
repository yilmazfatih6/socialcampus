@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h1 class="text-center">Geliştirici Paneline Hoşgeldiniz!</h1>
			<p>Medeniyet Sosyal, İstanbul Medeniyet Üniversitesi öğrencileri tarafından geliştirilen bir platformdur. Bu platformu geliştiriken bize yardım edebilecek ekip arkadaşları arıyoruz. Eğer belirli yazılım dilleri veya tasarım üstüne tecrübeniz var ise ve ekibimize katılmak isterseniz aşağıdaki formu doldurarak bize başvuruda bulunabilirsiniz. Eğer ben yazılımsal veya tasarımsal geliştirme ekibinin bir parçası değil de fikir üreten ekibin bir parçası olmak istiyorum derseniz da bunu aşağıdaki formda belirterek bize başvuruda bulunabilirsiniz.</p>

			<h2 class="text-center">Başvuru Formu</h2>
			<form action="/developers/apply" method="post">
				<div class="form-group{{$errors->has('full_name') ? ' has-error' : ''}}">
					<label for="full_name">Adınız ve Soyadınız</label>
					<input type="text" class="form-control" name="full_name" id="full_name" placeholder="Adınız ve Soyadınız" value="{{ old('full_name') }}" required>
					@if($errors->has('full_name'))
			            <span class="help-block">{{$errors->first('full_name')}}</span>
			        @endif
				</div>
				<div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
					<label for="full-name">Emailiniz <small>(Size ulaşabilmemiz için)</small></label>
					<input type="email" class="form-control" name="email" id="email" placeholder="Emailiniz" value="{{ old('email') }}" required>
					@if($errors->has('email'))
			            <span class="help-block">{{$errors->first('email')}}</span>
			        @endif
				</div>
				<div class="form-group{{$errors->has('phone_num') ? ' has-error' : ''}}">
					<label for="phone_num">Telefon Numaranız <small>(Size ulaşabilmemiz için)</small></label>
					<input type="number" class="form-control" name="phone_num" id="phone_num" placeholder="Telefon Numaranız" value="{{ old('phone_num') }}" required>
					<small>(Örn: 53xxxxxxxx)</small>
					@if($errors->has('phone_num'))
			            <span class="help-block">{{$errors->first('phone_num')}}</span>
			        @endif
				</div>
				<div class="form-group{{$errors->has('body') ? ' has-error' : ''}}">
					<label for="body">Bildikleriniz ve Ekibe Katabilecekleriz</label>
					<textarea class="form-control" name="body" id="body" placeholder="Ben şunları çok iyi yaparım..." required>{{ old('body') }}</textarea>
					@if($errors->has('body'))
			            <span class="help-block">{{$errors->first('body')}}</span>
			        @endif
				</div>
				<button type="submit" class="btn btn-success btn-block">Başvur</button>
				{{csrf_field()}}
			</form>
			<br>
		</div>
	</div>
@endsection