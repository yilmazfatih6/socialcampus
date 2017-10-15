<!-- Friend , Friend request -->
<h4>Kulüp Listesi</h4>
@if(!$user->clubs()->count())
    @if(Auth::check() && Auth::user()->username===$user->username)
        <p class="text-muted">Henüz bir kulübe üye değilsin.</p>
        <a type="submit" class="btn btn-info btn-sm" href="/clubs">Kulüpler anasayfasına git</a>
    @else
        <p class="text-muted">Bu kullanıcı henüz hiçbir kulübe girmemiş.<p>
    @endif
@else
    @foreach($clubs as $club)
        <div class="col-lg-4 col-md-6" style="margin:0 0 13px -13px;">
            @include('clubs.partials.clubblock')
        </div>
    @endforeach
@endif
