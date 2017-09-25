<!--Bio Nav Bar-->
<div class="row">
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
		<button type="button" class="navbar-toggle btn btn-sm btn-expand" data-toggle="collapse" data-target="#bioNav">
			<i class="fa fa-arrow-down" aria-hidden="true"></i>
		</button>
		<a class="navbar-brand">{{$page->name}}</a>
            </div>
            <div class="collapse navbar-collapse" id="bioNav">
                <ul class="nav navbar-nav">
                    <li><a><strong>Sayfa Türü: </strong>{{ $page->genre }}</a></li>
                    @if($page->fb_url || $page->twitter_url || $page->insta_url)
                    	@if($page->fb_url)
                    	<li>
                    		<a href="{{$page->fb_url}}" style="text-decoration:none; margin-right: 5px;">
								<span class="fa fa-facebook"></span> Facebook
							</a>
						</li>
						@endif
						@if($page->twitter_url)
						<li>
                    		<a href="{{$page->twitter_url}}" style="text-decoration:none; margin-right: 5px;">
								<span class="fa fa-twitter"></span> Twitter
							</a>
						</li>
						@endif
						@if($page->insta_url)
						<li>
							<a href="{{$page->insta_url}}" style="text-decoration:none;">
								<span class="fa fa-instagram"></span> Instagram
							</a>
						</li>
						@endif
                    @endif
                </ul>
                <!--Follow and Unfollow Buttons-->
                <ul class="nav navbar-nav navbar-right">
	            @if(Auth::user())
	            	<div class="col-lg-12">
						@if(Auth::user()->isFollowingPage($page))
				    		<form action="/page/{{$page->abbr}}/unfollow" method="post" style="display: inline;">
	                            <button class="btn btn-danger navbar-btn">Takibi Bırak</button>
	                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                        </form>
						@else
							<form action="/page/{{$page->abbr}}/follow" method="post" style="display: inline;">
	                            <button class="btn btn-success navbar-btn">Takip Et</button>
	                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                        </form>
						@endif
				    </div>
				@endif
				<!--End of Follow and Unfollow buttons-->
            </div>
        </div>
    </nav>
</div>


