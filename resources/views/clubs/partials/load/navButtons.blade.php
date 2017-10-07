@if(Auth::user()->isMember($club))
    <a data-toggle="modal" data-target="#quit" class="btn btn-danger" style="margin-top:7px;">
    Üyelikten Çık
    </a>
@elseif(Auth::user()->isRequestedClub($club))
    <button class="btn btn-warning navbar-btn">Onay Beklemede</button>
@else
    <form id="join-club" class="inline" action="/club/add/{{$club->abbreviation}}" method="post">
        <button class="btn btn-success navbar-btn">Katılım İsteği Gönder</button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
@endif