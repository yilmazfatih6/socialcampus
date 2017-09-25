<a class="link" href="{{$notification->data['link'] }}">
	
	<!--Notification  Media-->
	<div class="media">

		<div class="media-left">
			<!--Notification Image-->
			@if( $notification->type =="medeniyetsosyal\Notifications\MembershipRequest" )
				<div class="col-xs-2">
					<img class="img-circle dual-left-not inline"  src="/storage/avatars/{{$notification->data['sender']['avatar'] }}"/>
					<img class="img-circle dual-right-not inline"  src="/storage/avatars/{{$notification->data['club']['avatar'] }}"/>
				</div>
			@elseif( $notification->type =="medeniyetsosyal\Notifications\AttendanceRequest" )
				<div class="col-xs-2">
					<img class="img-circle dual-left-not inline"  src="/storage/avatars/{{$notification->data['sender']['avatar'] }}"/>
					<img class="img-circle dual-right-not inline"  src="/storage/avatars/{{$notification->data['event']['poster'] }}"/>
				</div>
			@elseif( $notification->type =="medeniyetsosyal\Notifications\FollowRequest" )
				<div class="col-xs-2">
					<img class="img-circle dual-left-drop inline"  src="/storage/avatars/{{$notification->data['sender']['avatar'] }}"/>
					<img class="img-circle dual-right-drop inline"  src="/storage/avatars/{{$notification->data['page']['avatar'] }}"/>
				</div>		
			@elseif( $notification->type =="medeniyetsosyal\Notifications\FriendshipRequest")
				<div class="col-xs-2">
					<img class="img-circle"  src="/storage/avatars/{{$notification->data['sender']['avatar'] }}" style="width:auto; height:50px;"/>
				</div>
			@elseif( $notification->type =="medeniyetsosyal\Notifications\ClubAcceptance")
			<div class="col-xs-2">
				<i class="fa fa-check-circle" aria-hidden="true" style="font-size: 50px; color:green;"></i>
			</div>	
			@endif
		</div>	

		<!--Notification Body-->
		<div class="media-body">
			<p>{{$notification->data['title']}}</p>
		</div><!-- ./ Notification Body-->

	</div><!-- ./ Notification  Media-->
	<hr>
</a>	