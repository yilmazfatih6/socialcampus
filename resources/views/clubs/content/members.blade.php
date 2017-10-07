<div class="row">
    <h3 class="text-center">Kulüp Yöneticileri</h3><hr>
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
        <h3 class="text-center">Üyeler</h3><hr>
        @foreach($members as $user)
            <div class="col-md-4" style="margin-bottom:10px;">
                @include('users.partials.userblock')
            </div>
        @endforeach
    </div>
</div>
