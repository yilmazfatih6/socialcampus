<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--CSRF Protection-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Videojs-->
    <link href="http://vjs.zencdn.net/5.17.0/video-js.css" rel="stylesheet">
    <!-- If you'd like to support Video Player in IE8 -->
    <script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <!--Snowflake Icons taken from https://icons8.com/-->
    <link rel="shortcut icon" href="/storage/icons/snowflake.png">
    <!--Font Awesome-->
    <script src="https://use.fontawesome.com/fffe030555.js"></script>
    <!--My Css File-->
    <link rel="stylesheet" href="/css/app.css">
    <!--Pusher-->
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <title>Medeniyet Sosyal</title>
</head>
<body>
	<div id="app">
	  	@include('templates.partials.modals')
		<div id="hp-welcome">
			@include('home.partials.navbar')
	      		<div class="container-fluid text-center color-white">
	      			<div class="col-md-6 col-md-offset-3"><br>
					<i class="fa fa-snowflake-o hp-icon" aria-hidden="true"></i>
		      			<h1><b>Merhaba!</b></h1>
		      			<h2>Medeniyet Sosyal'e Hoşgeldin!</h2>
		      			<small><b>Erken Erişim</b></small>
		      			<!--Search-->
		      			<div class="hp-search">
						<form class="inline" role="search" action="/searchengine">
						    <div class="input-group">
						        <input type="text" name="query" class="form-control input-lg" placeholder="Ne Aramak İstersin?">
						        <span class="input-group-btn">
						            <button class="btn btn-lg btn-hp-search btn-white" type="submit">Ara</button>
						        </span>
						    </div>
						</form>
					</div>
		      			<a id="btn-hp-signin" data-toggle="modal" data-target="#signin-modal" class="btn btn-lg btn-default btn-yellow btn-block">Giriş Yap</a>
		      			<a id="btn-hp-signup" href="/signup" class="btn btn-lg btn-default btn-pink btn-block">Kayıt Ol</a>
		      			<a id="btn-hp-info" class="btn btn-lg btn-default btn-purple btn-block">Bu site de ne?</a><br>
		      		</div>
	      		</div>
		</div>
		<div id="hp-content">
	      		<div class="container-fluid color-white">
	      			<div class="col-md-6 col-md-offset-3">
	      				<h2 class="text-center"><b>Medeniyet Sosyal'de Yapabilecekleriniz</b></h2><hr>
		      			<div class="row">
		      				<h3><i class="fa fa-users" aria-hidden="true"></i> Kulüpler</h3>
		      				<p>Üniversite kulübünüzün sayfasını açabilir ya da var olan kulüplere katılabilirsiniz. Kulüp sayfasında kulüp içi etkinlikleri, paylaşımları görebilir, üyesi iseniz paylaşım yapabilir ve yetki sahibi iseniz de etkinlik oluşturabilirsiniz.</p>
	      					<a href="/clubs" class="btn btn-default btn-block btn-purple">Kulüplere Göz At</a>
		      			</div>
		      			<div class="row">
	      					<h3><i class="fa fa-calendar" aria-hidden="true"></i> Etkinlikler</h3>
		      				<p>Üniversite kulüpleri tarafından yapılan etkinliklere göz atabilir, katılabilir ve etkinlik sahipleri ve katılımcıları ile iletişime geçebilirsiniz.</p>
	      					<a href="/events" class="btn btn-default btn-block btn-blue">Etkinliklere Göz At</a>
		      			</div>
		      			<div class="row">
	      					<h3><i class="fa fa-calendar" aria-hidden="true"></i> Sayfalar</h3>
		      				<p>Üniversite ile ilgili sayfalar açabilir ve paylaşımlarda bulunabilirsiniz yok ben sayfa açma sadece içeriklere bakarım derseniz de sayfaları takip edebilirsiniz. Çok şekil değil mi benzersiz falan filan.</p>
	      					<a href="/pages" class="btn btn-default btn-block btn-purple">Sayfalara Göz At</a>
		      			</div>
		      			<div class="row text-center">
	      					<a id="hp-scroll-to-signup"><i class="fa fa-arrow-down hp-down" aria-hidden="true"></i></a>
	      					<br><br>
		      			</div>
		      		</div>
	      		</div>
		</div>
		<div id="hp-signup">
			<div class="container-fluid color-white">
	      			<div class="col-md-6 col-md-offset-3">
					<div class="row text-center hp-join-div vertical-center">
						<div>
							<i class="fa fa-rocket hp-rocket" aria-hidden="true"></i>
							<h3 class="text-center">Bunları yapabilmeniz için tek ihtiyacınız olan hesap oluşturmak!</h3><br>
							<a href="/signup" class="btn btn-default btn-block btn-yellow"><b>Kayıt Ol ve Başla!</b></a>
							<a id="hp-scroll-to-top"><i class="fa fa-arrow-up hp-up" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="/js/app.js"></script>
</body>
</html>
