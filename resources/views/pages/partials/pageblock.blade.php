<div class="media" style="margin-bottom: 15px;">

    <!-- Image -->
    <a class="pull-left" href="/page/{{$page->abbr}}">
        <img class="img-rounded" alt="{{$page->name}}" src="/storage/avatars/{{$page->avatar}}" style="width:50px; height:50px;"/>
    </a><!-- ./ Image -->

    <!--Media Body-->
    <div class="media-body">

        <!--Media Content-->
        <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">

            <!--Page Name-->
            <h4 style="line-height:5px;">
                <a style="text-decoration:none;" href="/page/{{$page->abbr}}">{{$page->name}}</a>
            </h4> <!-- / Page Name-->

            <!--Page Abbr-->
            <span>
                <a class="text-muted" style="text-decoration:none;" href="/page/{{$page->abbr}}">{{$page->abbr}}</a>
            </span><!-- / Page Abbr-->

        </div>
        <!-- / Media Content-->

        <!-- Hot Buttons -->
        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">

            @if(Auth::check())
                <div class="row" id="button-wrapper-{{$page->id}}">
                    <div class="container-fluid" id="button-{{$page->id}}">
                        <!-- Unfollow Page -->
                        @if(Auth::user()->isFollowingPage($page))
                            <form class="inline" id="unfollow-page-quick" action="/page/{{$page->abbr}}/unfollow" method="post">
                                <div class="form-group inline">
                                    <button type="submit" class="btn btn-danger btn-action-red">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </div>
                            </form>
                        <!--Follow Page-->
                        @else
                            <form class="inline" id="follow-page-quick" action="/page/{{$page->abbr}}/follow" method="post">
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

    </div><!-- ./ Media Body-->

</div>
