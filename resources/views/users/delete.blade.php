@extends('templates.default')

@section('content')
	@include('users.partials.modals')
	<div class="text-center">
		<h1>Hesabını silmek üzeresin!</h1>
		<p>Bu işlem <b>geri alınamaz</b>. Hesabını ve paylaşımlarını tamamen kaldırır. Bu işlemi gerçekleştirmek ve hesabını <b>kalıcı</b> olarak silmek istediğine emin isen aşağıdaki butona tıkla.</p>
		<a class="btn btn-danger" data-toggle="modal" data-target="#delete-account">Hesabı Sil</a>
	</div>
@endsection