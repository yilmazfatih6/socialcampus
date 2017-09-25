<div class="media">

    <!-- Image -->
    <a class="pull-left" href="/club/{{$club->abbreviation}}">
        <img class="img-rounded avatar" src="/storage/avatars/{{$club->avatar}}"/>
    </a><!-- / Image -->

    <!--Media Body-->
    <div class="media-body">

        <!--Media Content-->
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            <h4 class="media-heading"><a class="link-header" href="/club/{{$club->abbreviation}}">{{ $club->name }}</a></h4>
            <p class="text-muted">{{ $club->abbreviation }}</p>
        </div>
        <!-- / Media Content-->

        <!-- Hot Buttons -->
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

            @if(Auth::check())
                <div class="row" id="button-wrapper-{{$club->id}}">
                    <div class="container-fluid" id="button-{{$club->id}}">
                        <!-- Quit Club -->
                        @if(Auth::user()->isMember($club))
                            <form class="inline pull-right" id="quit-club-quick" data-id="{{$club->id}}" action="/club/quit/{{$club->abbreviation}}" method="post">
                                <div class="form-group inline">
                                    <button type="submit" class="btn btn-danger btn-action-red">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </div>
                            </form>
                        <!-- Requested Club -->
                        @elseif(Auth::user()->isRequestedClub($club))
                            <button class="btn btn-warning btn-action btn-action-orange pull-right">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                            </button>
                        <!-- Join Club -->
                        @else
                            <form class="inline pull-right" id="join-club-quick" data-id="{{$club->id}}" action="/club/add/{{$club->abbreviation}}" method="post">
                                <div class="form-group inline">
                                    <button type="submit" class="btn btn-success btn-action-green">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </div>
                            </form>
                        @endif
                    </div>  <!--  / #Buttons-->
                </div><!-- / #Button Wrapper-->
            @endif

        </div> <!--  / Hot Buttons -->

    </div><!-- / Media Body-->

</div>
