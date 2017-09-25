<a class="link" id="mark-as-read" data-id="{{$notification->id}}" href="{{$notification->data['link'] }}">
	<div class="row" style="margin-bottom: 5px;">
		<!--Notification Image-->
		@if( $notification->type =="medeniyetsosyal\Notifications\MembershipRequest" )
			<div class="col-xs-2">
				<img class="img-circle dual-left-drop inline"  src="/storage/avatars/{{$notification->data['sender']['avatar'] }}"/>
				<img class="img-circle dual-right-drop inline"  src="/storage/avatars/{{$notification->data['club']['avatar'] }}"/>
			</div>
		@elseif( $notification->type =="medeniyetsosyal\Notifications\AttendanceRequest" )
			<div class="col-xs-2">
				<img class="img-circle dual-left-drop inline"  src="/storage/avatars/{{$notification->data['sender']['avatar'] }}"/>
				<img class="img-circle dual-right-drop inline"  src="/storage/avatars/{{$notification->data['event']['poster'] }}"/>
			</div>
		@elseif( $notification->type =="medeniyetsosyal\Notifications\FollowRequest" )
			<div class="col-xs-2">
				<img class="img-circle dual-left-drop inline"  src="/storage/avatars/{{$notification->data['sender']['avatar'] }}"/>
				<img class="img-circle dual-right-drop inline"  src="/storage/avatars/{{$notification->data['page']['avatar'] }}"/>
			</div>	
		@elseif( $notification->type =="medeniyetsosyal\Notifications\FriendshipRequest")
			<div class="col-xs-2">
				<img class="img-circle"  src="/storage/avatars/{{$notification->data['sender']['avatar'] }}" style="width:auto; height:40px;"/>
			</div>
		@elseif( $notification->type =="medeniyetsosyal\Notifications\ClubAcceptance")
			<div class="col-xs-2">
				<i class="fa fa-check-circle" aria-hidden="true" style="font-size: 50px; color:#5cb85c;"></i>
			</div>	
		@endif
		<!--Notification Body-->
		<div class="col-xs-10">
			<p>{{$notification->data['title']}}</p>
		</div>

	</div>
</a>