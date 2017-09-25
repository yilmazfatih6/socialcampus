<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>Kulüp Yöneticileri</h4>
        </div>
        @foreach($members as $user)
            @if($club->isAdmin($user))
              <div class="col-md-4" style="margin-bottom:10px;">
                @include('users.partials.userblock')
              </div>
            @endif
        @endforeach
    </div>
    <div id="club-members-wrapper">
        <div class="row" id="club-members">
            <div class="col-lg-12">
                <h4>Üyeler</h4>
            </div>
            @foreach($members as $user)
                <div class="col-md-4" style="margin-bottom:10px;">
                    @include('users.partials.userblock')
                </div>
            @endforeach
        </div>
    </div>
</div>
