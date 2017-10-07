@if(Auth::check() && Auth::user()->isAdmin($club))
    <div class="row margin-top-ten">
      <div class="col-md-4" style="margin-top:5px;">
              <a href="/club/{{$club->abbreviation}}/edit" class="btn btn-info btn-block">Bilgileri Değiştir</a>
      </div>
      <div class="col-md-4" style="margin-top:5px;">
            <div class="btn-group btn-group-justified">
                <a data-toggle="modal" data-target="#uploadAvatar" class="btn btn-success">
                    Fotoğrafı Değiştir
                </a>
                <a data-toggle="modal" data-target="#uploadCover" class="btn btn-success">
                    Kapağı Değiştir
                </a>
            </div>
        </div>
        <div class="col-md-4" style="margin-top:5px;">
          <div class="btn-group btn-group-justified">
              <a href="/event/create/{{$club->abbreviation}}" class="btn btn-warning">Etkinlik Oluştur</a>
          </div>
        </div>
    </div>
    <br>

    <div class="row">
        <h4 class="text-center">Yöneticiler</h4><hr>
        @foreach($admins as $user)
            <div class="col-md-4" style="margin-bottom:10px;">
                @include('users.partials.userblock')
            </div>
        @endforeach
    </div>

    <div class="row">
        <h4 class="text-center">Katılım İstekleri</h4><hr>
        @if( count($requests) )
            @foreach($requests as $user)
              <div class="col-md-4" style="margin-bottom:10px;">
                @include('clubs.partials.userblock')
              </div>
            @endforeach
        @else
            <small>Henüz hiçbir katılım isteği bulunmamakta.</small>
        @endif
    </div>
@endif
