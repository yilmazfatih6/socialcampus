<!--Bio Nav Bar-->
<div class="row">

    <!-- nav -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation">

        <!-- .container-fluid -->
        <div class="container-fluid">

            <!-- .navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle btn btn-sm btn-expand" data-toggle="collapse" data-target="#bioNav">
                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                </button>
                <a class="navbar-brand">{{$club->name}}</a>

            </div>

            <div class="collapse navbar-collapse" id="bioNav">


                <ul class="nav navbar-nav">

                    <li><a><strong>Kulüp Türü: </strong>{{ $club->club_type }}</a></li>

                    @if($club->fb_url || $club->twitter_url || $club->insta_url)

                        <!--Facebook URL-->
                        @if($club->fb_url)
                            <li>
                                <a href="{{$club->fb_url}}" style="text-decoration:none; margin-right: 5px;">
                                    <span class="fa fa-facebook"></span> Facebook
                                </a>
                            </li>
                        @endif

                        <!--Twitter URL-->
                        @if($club->twitter_url)
                            <li>
                                <a href="{{$club->twitter_url}}" style="text-decoration:none; margin-right: 5px;">
                                    <span class="fa fa-twitter"></span> Twitter
                                </a>
                            </li>
                        @endif

                        <!--Insta URL-->
                        @if($club->insta_url)
                            <li>
                                <a href="{{$club->insta_url}}" style="text-decoration:none;">
                                    <span class="fa fa-instagram"></span> Instagram
                                </a>
                            </li>
                        @endif

                    @endif
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/chat/{{Auth::user()->id}}/club/{{$club->id}}"><i class="fa fa-envelope" aria-hidden="true"></i>
                            Yöneticiye Mesaj At
                        </a>
                    </li>
                </ul>

                <!-- Membership Buttons Hidden on XS devices XS device button located in header.blade.php-->
                <ul id="membership-buttons-ul" class="nav navbar-nav navbar-right hidden-xs">
                    @if(Auth::user())
                        <div id="membership-buttons-div inline" class="col-lg-12">
                            @if(Auth::user()->isMember($club))
                                <a data-toggle="modal" data-target="#quit" class="btn btn-danger" style="margin-top:7px;">
                                Üyelikten Çık
                                </a>
                            <!--Modal is in view('clubs.profile')-->
                            @elseif(Auth::user()->isRequestedClub($club))
                                <button class="btn btn-warning navbar-btn">Onay Beklemede</button>
                            @else
                                <form id="join-club" class="inline" action="/club/add/{{$club->abbreviation}}" method="post">
                                    <button class="btn btn-success navbar-btn">Katılım İsteği Gönder</button>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            @endif
                        </div>
                    @endif
                </ul>
                <!-- / Membership Buttons -->



            </div>
            <!-- / .navbar-header- -->
        </div>
        <!-- / .container-fluid -->
    </nav>
    <!-- / nav -->
</div>



