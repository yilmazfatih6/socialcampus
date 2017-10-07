<!--Bio Nav Bar-->
<div class="row">
    
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        
        <div class="container-fluid">
			
			<!--PAGE NAME AND TOGGLE BUTTON-->
            <div class="navbar-header">
				<button type="button" class="navbar-toggle btn btn-sm btn-expand" data-toggle="collapse" data-target="#bioNav">
					<i class="fa fa-arrow-down" aria-hidden="true"></i>
				</button>
				<a class="navbar-brand">{{$page->name}}</a>
            </div>

            <!--COLLAPSED PART-->
            <div class="collapse navbar-collapse" id="bioNav">
                <ul class="nav navbar-nav">
                    <!--GENRE-->
                    @if($page->genre)
                    	<li><a><strong>Sayfa Türü: </strong>{{ $page->genre }}</a></li>
					@endif

					<!--SOCIAL MEDIA LINKS-->
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
				
				<!--MESSAGE TO ADMIN-->
				@if(Auth::check() && !Auth::user()->isPageAdmin($page))
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="/chat/{{Auth::user()->id}}/page/{{$page->id}}"><i class="fa fa-envelope" aria-hidden="true"></i>
                                Yöneticiye Mesaj At
                            </a>
                        </li>
                    </ul>
                @endif

                <!--Follow and Unfollow Buttons-->
	            @if(Auth::check())
                <ul class="nav navbar-nav navbar-right">
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
				</ul>
				@endif

            </div><!--/ COLLAPSED PART -->
        
        </div><!--/ CONTAINER FLUID-->

    </nav>

</div>


