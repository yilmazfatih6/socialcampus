<!--Header-->
<div class="row" style="background-image:url('/storage/covers/{{$user->cover}}'); margin-top:-20px; padding:25px 0;">

    <div class="col-lg-10 col-lg-offset-1">
        <!--Profile Photo-->
            <div class="media inline pull-left">
                <div class="media-left media-top">
                    <a data-toggle="modal" data-target="#uploadAvatar" class="pull-left" x>
                        <img class="img-circle" alt=" {{ $user->getNameOrUsername() }} " src="/storage/avatars/{{$user->avatar}}" style="width:100px; height:100px;"/>
                    </a>
                </div>
            </div>
        <!--End of Profile Photo-->

        <!--Upload Avatar-->
        @if($user->username === Auth::user()->username)
            <div class=" pull-right">
                <button data-toggle="modal" data-target="#uploadCover" class="btn btn-lg btn-upload" id="btn-upload-avatar">
                    <i class="fa fa-cloud-upload upload-cover-icon" aria-hidden="true"></i>
                </button>
            </div>
        @endif
        <!-- / Upload Avatar-->
    </div>

</div>
<!-- / Header-->

<!--Bio Nav Bar-->
@include('users.header.partials.bio')
<!--/ Bio Nav Bar-->
