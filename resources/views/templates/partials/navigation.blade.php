<nav id="main-nav" class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<!--Snow flake ıcon-->
			<a class="navbar-toggle text-center navbar-icon" href="/">
				<i class="fa fa-snowflake-o navbar-snowflake" aria-hidden="true"></i>
			</a>
			<!--Clubs-->
			<a href="/clubs" class="navbar-toggle text-center navbar-icon">
				<i class="fa fa-handshake-o" aria-hidden="true"></i>
			</a>
			<!--Pages-->
			<a href="/pages" class="navbar-toggle text-center navbar-icon">
				<i class="fa fa-files-o" aria-hidden="true"></i>
			</a>
			<!--Events-->
			<a href="/events" class="navbar-toggle text-center navbar-icon">
				<i class="fa fa-calendar" aria-hidden="true"></i>
			</a>
			
			<!--Messages-->
			@if(Auth::check())
				<a href="/chat" class="navbar-toggle text-center navbar-icon">
					<i class="fa fa-envelope" aria-hidden="true"></i>
				</a>
			@endif

			<!--Search-->
			<a href="/search" class="navbar-toggle text-center navbar-icon">
				<i class="fa fa-search" aria-hidden="true"></i>
			</a>
			@if(Auth::check())
			<!--Friends-->
			<a href="/friends" class="navbar-toggle text-center navbar-icon">
				@if(Auth::user()->friendRequests()->count())
				<i class="fa fa-users" aria-hidden="true"></i><span class="badge badge-icon">{{Auth::user()->friendRequests()->count()}}</span>
				@else
				<i class="fa fa-users" aria-hidden="true"></i>
				@endif
			</a>
			<!--Mobile Notifications-->
			<a class="dropdown-toggle navbar-toggle text-center navbar-icon" data-toggle="dropdown">
				<i class="fa fa-bell" aria-hidden="true"></i>
				@if(Auth::user()->unreadNotifications->count())
				<span class="badge badge-icon">{{Auth::user()->unreadNotifications->count()}}</span>
				@endif
			</a>
			<ul id="dropdown-menu" class="dropdown-menu dropdown-notification">
				<div id="content">
					<div style="margin: 10px;">
						@if(count(Auth::user()->unreadNotifications))
						<div style="margin-bottom: 10px;">
							<h4 class="inline">Bildirimler</h4>
							<a class="link" id="mark-as-read-all" href="/markAsReadAll">
								<small class="pull-right">Hepsini Okundu Yap</small>
							</a>
						</div>
						@foreach(Auth::user()->unreadNotifications as $notification)
							@include('notifications.partials.dropdownblock')
						@endforeach
						@else
						<li><a class="link"><h4><b>Buralar bomboş</b></h4></a></li>
						<li><a class="link">Seni düşünen yok ¯\_(ツ)_/¯</a></li>
						@endif
						<li style="margin-top: 5px;"><a class="link text-center" href="/notifications"><small class="text-success">Eski bildirimleri gör</small></a></li>
					</div>
				</div>
			</ul>
			<!--/Mobile Notifications-->
			<!--Profile-->
			<a href="/user/{{Auth::user()->username}}" class="navbar-toggle text-center navbar-icon">
				<i class="fa fa-user-circle-o" aria-hidden="true"></i>
			</a>
			<!--Signout-->
			<a href="/signout" class="navbar-toggle text-center navbar-icon">
				<i class="fa fa-sign-out" aria-hidden="true"></i>
			</a>
			@else
			<!--Signin-->
			<a data-toggle="modal" data-target="#signin-modal" class="navbar-toggle text-center pull-right navbar-icon">
				<i class="fa fa-sign-in" aria-hidden="true"></i>
			</a>
			 <!--Signup-->
			<a href="/signup" class="navbar-toggle text-center pull-right navbar-icon">
				<i class="fa fa-user-plus" aria-hidden="true"></i>
			</a>
			@endif
		</div><!-- ./ navbar-header -->

		<!--Hidden Part on Collapse-->
		<div class="collapse navbar-collapse" id="myNavbar">

			<ul class="nav navbar-nav">
				<li>
					<a class="navbar-brand text-center navbar-icon-lg" href="/">
						<i class="fa fa-snowflake-o navbar-snowflake" aria-hidden="true"></i>
					</a>
				</li>
				<li><a href="/clubs" class="navbar-icon-lg">Kulüpler</a></li>
				<li><a href="/pages" class="navbar-icon-lg">Sayfalar</a></li>
				<li><a href="/events" class="navbar-icon-lg">Etkinlikler</a></li>

				@if(Auth::check())
					<li>
						<a href="{{route('friends.index')}}" class="navbar-icon-lg">Arkadaşlar
							@if(Auth::user()->friendRequests()->count())
								<span class="badge badge-nav">{{Auth::user()->friendRequests()->count()}}</span>
							@endif
						</a>
					</li>
				@endif
				<!--Messagess-->
				@if(Auth::check())
					<li><a href="/chat" class="navbar-icon-lg">Mesajlar</a></li>
				@endif
			</ul>



			<!--Navbar Search-->
			<div id="navbar-search">
				@if(Auth::check())
					<form class="navbar-form navbar-left inline" role="search" methd="get" action="/searchengine">
						<div class="input-group">
							<input type="text" name="query" class="form-control" placeholder="Arama Yap">
							<span class="input-group-btn">
								<button class="btn btn-info" type="submit">Ara</button>
							</span>
						</div>
					</form>
				@endif
			</div>
			<!-- ./ Navbar Search -->

			<!--  Collapse Navbar Collapse -->
			<ul class="nav navbar-nav navbar-right">
				@if(Auth::check())

					<!--Notifications-->
					 <li class="dropdown">
						<a class="dropdown-toggle navbar-icon-lg" data-toggle="dropdown">Bildirimler
							@if(Auth::user()->unreadNotifications->count())
								<span class="badge badge-nav">{{Auth::user()->unreadNotifications->count()}}</span>
							@else
								<span class="caret"></span>
							@endif
						</a>
						<ul id="dropdown-menu" class="dropdown-menu" style="width: 400px; ">
							<div style="margin: 10px;">
								@if(count(Auth::user()->unreadNotifications))
										<h4 class="inline">Bildirimler</h4>
										<a class="link" id="mark-as-read-all" href="/markAsReadAll">
											<small class="pull-right">Hepsini Okundu Yap</small>
										</a>
										@foreach(Auth::user()->unreadNotifications as $notification)
												@include('notifications.partials.dropdownblock')
										@endforeach
								@else
									<li><a class="link"><h4><b>Buralar bomboş</b></h4></a></li>
									<li><a class="link">Seni düşünen yok ¯\_(ツ)_/¯</a></li>
								@endif
							</div>
								<li><a class="link text-center" href="/notifications"><small class="text-success">Eski bildirimleri gör</small></a></li>
						</ul>
					</li><!-- ./ Notifications-->

					<!--User's Name Dropdown-->
					<li class="dropdown">
						<a class="dropdown-toggle navbar-icon-lg" data-toggle="dropdown">{{Auth::user()->getNameOrUsername()}}<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="/user/{{Auth::user()->username}}">Profil</a></li>
							<li><a href="{{ route('profile.edit') }}">Profilini Güncelle</a></li>
							<li><a href="{{ route('profile.password') }}">Şifreni Değiştir</a></li>
							<li><a href="{{ route('auth.signout') }}">Çıkış Yap</a></li>
						</ul>
					</li>
					<!-- ./ User's Name Dropdown-->

				@else
					<li><a href="{{ route('auth.signup') }}"><span class="glyphicon glyphicon-user"></span> Kayıt Ol</a></li>
					<li><a data-toggle="modal" data-target="#signin-modal"><span class="glyphicon glyphicon-log-in"></span> Giriş Yap</a></li>
				@endif
			</ul>
		</div><!-- ./ collapse navbar-collapse -->

	</div>
</nav>
