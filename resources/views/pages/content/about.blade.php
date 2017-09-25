<div class="row">

    <!--Description-->
    <div class="col-lg-12">
        @if($page->description)
            <h3><b>Sayfa Açıklaması</b></h3>
            <p class="textarea">{{$page->description}}</p>
        @endif
    </div>

    <!--Admins-->
    <div class="col-lg-12">
        <h3><b>Yöneticiler</b></h3>
        @foreach($followers as $user)
            @if($page->isAdmin($user))
                <div class="col-lg-4 col-md-4" style="margin-bottom:10px;">
                    @include('users.partials.userblock')
                </div>
            @endif
        @endforeach
    </div>

</div>
