<!-- Friend , Friend request -->
<h4>Arkadaş Listesi</h4>
@if(!$user->friends()->count())
    <p class="text-muted">Arkadaş listesine henüz hiç kimse eklenmemiş.<p>
@else
    @foreach($friends as $user)
        <div class="col-lg-4 col-md-4" style="margin:0 0 13px -13px;">
            @include('users.partials.userblock')
        </div>
    @endforeach
@endif
