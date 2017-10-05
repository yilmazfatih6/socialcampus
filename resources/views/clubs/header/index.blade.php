<div class="row profile-header" style="background-image:url('/storage/covers/{{$club->cover}}');">
	<div class="col-lg-4 col-xs-8">
		<!--Club Avatar Media-->
		<div class="media">
			<div class="media-left">
				<img class="img-rounded" src="/storage/avatars/{{$club->avatar}}" style="width:100px; height:100px;">
			</div>
		</div>
	</div>

	<!--Membership Buttons on XS Devices-->
	<div class="col-xs-4 pull-right">
		<!-- Membership Buttons -->
		<ul id="membership-buttons-ul" class="nav navbar-nav navbar-right visible-xs">
			@if(Auth::user())
			    <div id="membership-buttons-div" class="col-lg-12">
			        @if(Auth::user()->isMember($club))
			            <a data-toggle="modal" data-target="#quit" class="btn btn-danger btn-action pull-right" style="margin-top:7px;">
			                <i class="fa fa-times" aria-hidden="true"></i>
			            </a>
			        <!--Modal is in view('clubs.profile')-->
			        @elseif(Auth::user()->isRequestedClub($club))
			            <button class="btn btn-warning navbar-btn btn-action pull-right">
			                <i class="fa fa-clock-o" aria-hidden="true"></i>
			            </button>
			        @else
			            <form id="join-club" class="inline pull-right" action="/club/add/{{$club->abbreviation}}" method="post">
			                <button class="btn btn-success navbar-btn btn-action">
			                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
			                </button>
			                <input type="hidden" name="_token" value="{{ csrf_token() }}">
			            </form>
			        @endif
			    </div>
			@endif
		</ul>
		<!-- / Membership Buttons -->
	</div>
	<!-- / Membership Buttons on XS Devices-->
</div>
@include('clubs.header.partials.bio')
