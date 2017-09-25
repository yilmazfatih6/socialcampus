<div class="media" id="userblock-{{$user->id}}">

    <!--Media Header-->
    <div class="media-left media-top">
        <a class="pull-left" href="/user/{{$user->username}}">
            <img class="img-circle" alt=" {{ $user->getNameOrUsername() }} " src="/storage/avatars/{{$user->avatar}}" style="width:50px; height:50px;"/>
        </a>
    </div>
    <!--/ .Media Header-->

    <!--Media Body-->
    <div class="media-body">
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            <h4 class="media-heading"><a class="link-header" href="/user/{{$user->username}}">{{ $user->getNameOrUsername() }}</a></h4>
            <span class="text-muted"><span>@</span>{{ $user->username }}</span>
        </div>
        @if(Auth::check())
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            @if(Auth::user()->id !== $user->id)
                <!-- Friendship Buttons Wrapper-->
                <div id="friendship-btn-wrapper-{{$user->username}}">
                    <!-- Friendship Buttons -->
                    <div id="friendship-btn-{{$user->username}}">

                        <!-- If request received -->
                        @if(Auth::user()->hasFriendRequestReceived($user))
                            <!--Accept-->
                            <form id="accept-friendship-quick" action="/friends/accept/{{$user->id}}" method="post" class="inline">
                                <div class="form-group inline">
                                    <button type="submit" class="btn btn-xs btn-success btn-action-green">
                                       <i class="fa fa-check" aria-hidden="true"></i>
                                    </button>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </div>
                            </form>
                            <!--Reject-->
                             <form id="reject-friendship-quick" action="/friends/reject/{{$user->id}}" method="post" class="inline">
                                <div class="form-group inline">
                                    <button type="submit" class="btn btn-xs btn-danger btn-action-red">
                                       <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </div>
                            </form>

                         <!-- Requested -->
                        @elseif(Auth::user()->hasFriendRequestPending($user))
                                <button type="button" class="btn btn-warning btn-sm btn-action-orange">
                                       <i class="fa fa-clock-o" aria-hidden="true"></i>
                                </button>

                        <!--Delete Friend-->
                        @elseif(Auth::user()->isFriendsWith($user))
                            <form id="delete-friendship-quick" action="/friends/delete/{{$user->id}}" method="post" class="inline">
                                    <button type="submit" class="btn btn-sm btn-danger btn-action-red">
                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                    </button>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>

                        <!--Send Friendship-->
                        @else
                            <form id="send-friendship-quick" action="/friends/add/{{$user->id}}" method="post" class="inline">
                                    <button type="submit" class="btn btn-sm btn-success btn-action-green">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>

                        @endif
                    </div>
                    <!-- / .Friendship Buttons -->
                </div>
                <!-- / .Friendship Buttons Wrapper-->
            @endif
        </div><!--/ Row -->
        @endif
    </div>
    <!-- / .Media Body-->

</div>
