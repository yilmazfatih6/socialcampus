<!--Start of the Container-->
<div class="container-fluid" id="status-{{$status->id}}" style="padding:10px 10px;">

    <!--Start of the Main Row Wrapper-->
    <div class="row" id="sc-{{$status->id}}">

        <!--Start of the Main Col Class-->
        <div class="col-lg-12">

            <!--Start of the Header Row-->
            <div class="row">

                <!--Start of the Media-->
                <div class="media">

                    <!--Owner Image-->
                    @if($status->page_id)
                        <a class="pull-left" href="/page/{{$status->page->abbr}}">
                            <img class="img-circle" alt="{{$status->page->name}}" src="/storage/avatars/{{$status->page->avatar}}" style="width:25px; height:25px; margin-bottom: 10px;">
                        </a>
                    @else
                        <a class="pull-left" href="/user/{{$status->user->username}}">
                            <img class="img-circle" alt="{{$status->user->getNameOrUsername()}}" src="/storage/avatars/{{$status->user->avatar}}" style="width:25px; height:25px; margin-bottom: 10px;">
                        </a>
                    @endif
                    <!--/ Owner Image-->

                    <!--Deleting post-->
                    @if(Auth::check())
                        @if( $status->page_id && Auth::user()->isPageAdmin($status->page) )
                             <form class="pull-right inline delete-status" method="post" action="/status/{{$status->id}}/delete">
                                <button class="btn btn-default btn-borderless link-muted" type="submit">Sil <i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                <input type="hidden" value="{{csrf_token()}}" name="_token">
                            </form>
                        @elseif(Auth::user()->id === $status->user_id)
                            <form class="pull-right inline delete-status" method="post" action="/status/{{$status->id}}/delete">
                                <button class="btn btn-default btn-borderless link-muted" type="submit">Sil <i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                <input type="hidden" value="{{csrf_token()}}" name="_token">
                            </form>
                        @endif
                    @endif
                    <!--End of the Deleting Post-->

                    <!--Owner Name-->
                    @if($status->page_id)
                        <div class="media-body">
                            <h4 class="media-heading" style="line-height: 25px;">
                                <a href="/page/{{$status->page->abbr}}" class="link color-blue">{{$status->page->name}}</a>
                            </h4>
                        </div>
                    @else
                        <div class="media-body">
                            <h4 class="media-heading" style="line-height: 25px;">
                                <a href="/user/{{$status->user->username}}" class="link color-blue">{{$status->user->getNameOrUsername()}}</a>
                                <!--Shared Platform-->
                                @if($status->club_id)
                                <small>
                                    <a href="/club/{{$status->club->abbreviation}}" class="link-muted">
                                        <i class="fa fa-share" aria-hidden="true"></i> {{$status->club->abbreviation}}
                                    </a>
                                </small>
                                @elseif($status->event_id)
                                 <small>
                                    <a href="/event/{{$status->event->id}}" class="link-muted">
                                        <i class="fa fa-share" aria-hidden="true"></i> {{$status->event->name}}
                                    </a>
                                </small>
                                @endif<!--/ Shared Platform-->
                            </h4>
                        </div>
                    @endif
                    <!--/ Owner Name -->

                </div><!--/ Media-->

            </div>
            <!--End of the Header Row-->
            
            <!--Start of the Status Body-->
            @if($status->isLong())
            <div class="row">
                <p id="status-body-{{$status->id}}" class="textarea inline">{{$status->shortened()}}<a class="link extend-status color-blue" data-status-id="{{$status->id}}"> <i class="fa fa-chevron-down" aria-hidden="true"></i> Genişlet</a></p>
            </div>
            @else
            <div class="row">
                <p class="textarea inline">{{$status->body}}</p>
            </div>
            @endif
            <!--End of the Status Body-->

            <!--Post Image-->
            @if($status->image)
            <div class="row">
                <img class="center-block" src="/storage/statuses/images/{{$status->image}}" style="max-width:100%; max-height:100%; margin-bottom:10px;">
            </div>
            @endif
            <!--End of post image-->

            <!--Post Video-->
            @if($status->video)
            <div class="row">
                <video id="video" class="video-js" controls preload="auto" style="height:300px; max-width:100%; max-height:100%; margin-bottom:10px;" data-setup="{}">
                    <source src="/storage/statuses/videos/{{$status->video}}" type='video/mp4'>
                    <source src="/storage/statuses/videos/{{$status->video}}" type='video/webm'>
                    <source src="/storage/statuses/videos/{{$status->video}}" type='video/ogg'>
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a web browser that
                        <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                  </video>

                  <script src="http://vjs.zencdn.net/5.17.0/video.js"></script>
            </div>
            @endif
            <!--End of post video-->

            <!--Start of the Post Footer Row-->
            <div class="row" id="sf-{{$status->id}}">
                <ul class="list-inline" id="sf-ul-{{$status->id}}">
                    <!--Posted Time-->
                    <li>
                        <a href="/status/{{$status->id}}" class="text-muted small link-muted">
                            {{ $status->created_at->diffForHumans() }}
                        </a>
                    </li>
                    <!--End of Posted Time-->

                    <!--Liking & Disliking Status-->
                    @if(Auth::user())
                        @if($status->user->id !== Auth::user()->id)
                        <li>
                        <!--Dislike-->
                        @if(Auth::user()->hasLikedStatus($status))
                            <form class="inline dislike-status" method="post" action="/status/{{$status->id}}/dislike">
                                <button class="btn btn-default btn-dislike" type="submit">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                </button>
                                <input type="hidden" value="{{csrf_token()}}" name="_token">
                            </form>
                        <!--Like-->
                        @else
                            <form class="inline like-status" method="post" action="/status/{{$status->id}}/like">
                                <button class="btn btn-default btn-like" type="submit">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                </button>
                                <input type="hidden" value="{{csrf_token()}}" name="_token">
                            </form>
                        @endif
                        </li>
                        @endif
                    @endif
                    <!--End of the Liking & Disliking Status-->

                    <!--Number of Likes and Dislikes-->
                    <li><small class="text-muted">{{$status->likes->count()}} Beğeni</small></li>
                    <!--End of the Number of Likes & Dislikes-->
                </ul>
            </div>
            <!--End of the Post Footer Row-->

            <!--Start of the Reply Row-->
            <div class="row" style="margin-left:5px;">

                <!--Starting of the Foreach-->
                @foreach($status->replies as $reply)
                    <!--Start of Reply Wrapper-->
                    <div class="Wrapper" id="reply-{{$reply->id}}">
                        <!--Starting of the User Information Row-->
                        <div class="row">
                            <!--Starting of the Col Class-->
                            <div class="col-lg-12">
                                <div class="media">
                                    <a class="pull-left" href="/user/{{$reply->user->username}}">
                                        <img class="img-circle" alt="{{$reply->user->getNameOrUsername()}}" src="/storage/avatars/{{$reply->user->avatar}}" style="width:20px; height:20px; margin-bottom: 10px;">
                                    </a>

                                    <!--Deleting Reply-->
                                    @if(Auth::check())
                                        @if( $reply->page_id && Auth::user()->isPageAdmin($reply->page) )
                                            <a href="/status/{{$reply->id}}/delete" class="pull-right text-muted" style="text-decoration:none;">
                                                <small>Gönderiyi Sil</small>
                                            </a>
                                        @elseif(Auth::user()->id === $reply->user_id)
                                        <form class="pull-right inline delete-reply" method="post" action="/status/{{$reply->id}}/delete">
                                                <button class="btn btn-default btn-borderless link-muted" type="submit">Sil <i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                <input type="hidden" value="{{csrf_token()}}" name="_token">
                                            </form>
                                        @endif
                                    @endif
                                    <!--End of the deleting post-->

                                    <div class="media-body">
                                        <h5 class="media-heading"><a class="link color-blue" href="/user/{{$reply->user->username}}" style="line-height: 20px;">{{$reply->user->getNameOrUsername()}}</a></h5>
                                    </div>


                                </div>
                            </div>
                            <!--Ending of the Col Class-->
                        </div>
                        <!--Ending of the User Information Row-->

                        <!--Starting of the Reply Body-->
                        <div class="row">
                            <div class="col-lg-12">
                                @if($reply->isLong())
                                    <div class="row">
                                        <p id="status-body-{{$reply->id}}" class="textarea inline">{{$reply->shortened()}}<a class="link extend-status color-blue" data-status-id="{{$reply->id}}"> <i class="fa fa-chevron-down" aria-hidden="true"></i> Genişlet</a></p>
                                    </div>
                                @else
                                    <div class="row">
                                        <p class="textarea inline">{{$reply->body}}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!--Ending of the Reply Body-->

                        <!--Starting of the Row-->
                        <div class="row">
                            <div class="col-lg-12" id="sf-{{$reply->id}}">
                                <ul class="list-inline" id="sf-ul-{{$reply->id}}">
                                    <!--Posted Time-->
                                    <li>
                                        <small class="text-muted">{{$reply->created_at->diffForHumans()}}</small>
                                    </li>
                                    <!--Liking Status-->
                                    @if(Auth::user())
                                        @if($reply->user->id !== Auth::user()->id)
                                            <li>
                                            <!--Dislike-->
                                            @if(Auth::user()->hasLikedStatus($reply))
                                                <form class="inline dislike-status" method="post" action="/status/{{$reply->id}}/dislike">
                                                    <button class="btn btn-default btn-dislike" type="submit">
                                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </button>
                                                    <input type="hidden" value="{{csrf_token()}}" name="_token">
                                                </form>
                                            <!--Like-->
                                            @else
                                                <form class="inline like-status" method="post" action="/status/{{$reply->id}}/like">
                                                    <button class="btn btn-default btn-like" type="submit">
                                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </button>
                                                    <input type="hidden" value="{{csrf_token()}}" name="_token">
                                                </form>
                                            @endif
                                            </li>
                                        @endif
                                    @endif
                                    <li>
                                        <small class="text-muted">{{$reply->likes->count()}} Beğeni</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--Ending of the Row-->

                    </div>
                    <!--End of Reply Wrapper-->
                @endforeach
                <!--End of the Foreach-->

            </div>
            <!--End of the Reply Row-->

            <!--REPLY-->
            @if(Auth::check())
                <!--If this is a Club, Event or Page Post Don't Check Friendship-->
                @if(isset($status->club_id) || isset($status->event_id) || isset($status->page_id) )
                    <!--If this is a Club Post and if User is Member of the club Make Reply Available -->
                    @if( isset($status->club_id) && Auth::user()->isMemberWithId($status->club_id))
                        @include('statuses.partials.reply')
                    @endif

                    <!--If this is a Event Post and if user is attending to event Make Reply Available-->
                    @if( isset($status->event_id) && Auth::user()->isAttendingWithId($status->event_id))
                        @include('statuses.partials.reply')
                    @endif

                    <!--If this is a Event Post Make Reply Available-->
                    @if( isset($status->page_id))
                        @include('statuses.partials.reply')
                    @endif

                <!--If this is a Personal Post Query Friendship -->
                @else
                    <!-- If users are not friend don't include reply -->
                    @if( Auth::user()->isFriendsWithId($status->user_id) || Auth::user()->id === $status->user_id  )
                        @include('statuses.partials.reply')
                    @endif
                @endif
            @endif
            <!-- END OF REPLY -->

        </div>
        <!--End of the Main Col Class-->

    </div>
    <!--End of the Main Row Wrapper-->

</div>
<!--End of the Container-->
