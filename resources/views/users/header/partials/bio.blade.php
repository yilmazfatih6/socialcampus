<!--Bio Nav Bar-->
<div class="row">
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle btn btn-sm btn-expand" data-toggle="collapse" data-target="#bioNav">
                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                </button>
              <a class="navbar-brand" href="user/{{$user->username}}">{{$user->getNameOrUsername()}}</a>
            </div>
            <div class="collapse navbar-collapse" id="bioNav">
                <!--Output of username-->
                @if(Auth::user()->id === $user->id)
                <ul class="nav navbar-nav hidden-md hidden-lg">
                    <li><a href="{{ route('profile.edit') }}" class="text-center">Profilini Güncelle</a></li>
                    <li><a href="/profile/edit/password" class="text-center">Şifreni Değiştir</a></li>
                    <li>
                        <a data-toggle="modal" data-target="#uploadCover" class="btn btn-upload" id="btn-upload-avatar">Kapak Fotoğrafı Değiştir</a>
                    </li>
                    <li>
                        <a data-toggle="modal" data-target="#uploadAvatar" class="btn btn-upload" id="btn-upload-avatar">Profil Fotoğrafı Değiştir</a>
                    </li>
                </ul>
                @endif
                <!--End of out of username-->

                <!--Editing Friendship-->
                @if(Auth::user() && Auth::user()->id!==$user->id)
                <ul class="nav navbar-nav navbar-right">
                    
                    <!--Send Message Link Message-->
                    @if(Auth::user()->isFriendsWith($user))
                    <li>
                        <a class="text-center" href="/chat/personal/{{$user->id}}" title="Mesaj Gönder">
                            <i class="fa fa-envelope" aria-hidden="true"></i> Mesaj Gönder
                        </a>
                    </li>
                    @endif

                    <li style="margin-left: 15px;">

                        <!--If Request Is Pending-->
                        @if(Auth::user()->hasFriendRequestPending($user))
                            <button class="btn btn-warning navbar-btn">Onay Bekleniyor</button>

                        <!--If User Has Friendship Request-->
                        @elseif(Auth::user()->hasFriendRequestReceived($user))
                            <!--Accept-->
                            <form class="accept-friendship inline text-center" action="/friends/accept/{{$user->id}}" method="post">
                                <!--block button Visible on sm and xs devices-->
                                <button type="submit" class="btn btn-success navbar-btn btn-block hidden-lg hidden-md">
                                    Kabul Et <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                </button>
                                <!--Non block button Visible on lg and md devices-->
                                <button type="submit" class="btn btn-success navbar-btn hidden-xs hidden-sm">
                                    Kabul Et <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                </button>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>
                            <!--Reject-->
                             <form class="reject-friendship inline text-center" action="/friends/reject/{{$user->id}}" method="post">
                                <!--block button Visible on sm and xs devices-->
                                <button type="submit" class="btn btn-danger navbar-btn btn-block hidden-lg hidden-md">
                                    Reddet <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                                <!--Non block button Visible on lg and md devices-->
                                <button type="submit" class="btn btn-danger navbar-btn hidden-xs hidden-sm">
                                    Reddet <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>

                        <!--If Users are Friends-->
                        @elseif(Auth::user()->isFriendsWith($user))
                            <form class="delete-friendship text-center" action="/friends/delete/{{$user->id}}" method="post">
                                <button type="submit" class="btn btn-danger navbar-btn btn-block">Arkadaşlıktan Çıkar</button>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>

                        <!--If users are not Friends-->
                        @elseif(Auth::user()->id!==$user->id)
                            <form class="send-friendship text-center" action="/friends/add/{{$user->id}}" method="post">
                                <button type="submit" class="btn btn-success navbar-btn btn-block">Arkadaşlık İsteği Gönder</button>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        @endif
                    </li>
                </ul>
                @endif
                <!-- End of the Editing Friendship-->
            </div>
        </div>
    </nav>
</div>
