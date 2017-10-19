    <!--Header-->
<div class="row profile-header" style="background-image:url('/storage/covers/{{$user->cover}}');">

    <div class="col-lg-10 col-lg-offset-1">
        <!--Profile Photo-->
            <div class="media inline pull-left">
                <div class="media-left media-top">
                    @if(Auth::check() && Auth::user()->id === $user->id)
                        <a data-toggle="modal" data-target="#uploadAvatar" class="pull-left" x>
                            <img class="img-circle  avatar-profile" alt=" {{ $user->getNameOrUsername() }} " src="/storage/avatars/{{$user->avatar}}"/>
                        </a>
                    @else
                        <img class="img-circle avatar-profile" alt=" {{ $user->getNameOrUsername() }} " src="/storage/avatars/{{$user->avatar}}"/>
                    @endif
                </div>
            </div>
        <!--End of Profile Photo-->

        <!--Upload Avatar-->
        @if(Auth::check() && $user->username === Auth::user()->username)
            <div class=" pull-right">
                <button data-toggle="modal" data-target="#uploadCover" class="btn btn-upload btn-yellow btn-xs hidden-lg hidden-md hidden-sm">
                    <small>Kapak Değiştir</small> <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                </button><br>
                <button data-toggle="modal" data-target="#uploadAvatar" class="btn btn-upload btn-yellow btn-xs hidden-lg hidden-md hidden-sm">
                    <small>Fotoğraf Değiştir</small> <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                </button>

                <button data-toggle="modal" data-target="#uploadCover" class="btn btn-upload btn-yellow btn-sm hidden-xs">
                    <small>Kapak Değiştir</small> <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                </button><br>
                <button data-toggle="modal" data-target="#uploadAvatar" class="btn btn-upload btn-yellow btn-sm hidden-xs">
                    <small>Fotoğraf Değiştir</small> <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                </button>
            </div>
        @endif
        <!-- / Upload Avatar-->
    </div>

</div>
<!-- / Header-->

<!--Bio Nav Bar-->
<div class="user-bio">
    @include('users.header.partials.bio')
</div>
<!--/ Bio Nav Bar-->
