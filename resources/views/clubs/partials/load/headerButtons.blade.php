@if(Auth::user()->isMember($club))
    <button data-toggle="modal" data-target="#quit" class="btn btn-danger btn-sm navbar-btn btn-action pull-right">
        Kulüpten Çık <i class="fa fa-times" aria-hidden="true"></i>
    </button>
<!--Modal is in view('clubs.profile')-->
@elseif(Auth::user()->isRequestedClub($club))
    <button class="btn btn-warning btn-sm navbar-btn btn-action pull-right">
        İstek Beklemede <i class="fa fa-clock-o" aria-hidden="true"></i>
    </button>
@else
    <form id="join-club" class="inline pull-right" action="/club/add/{{$club->abbreviation}}" method="post">
        <button class="btn btn-success btn-sm navbar-btn btn-action">
            Katıl <i class="fa fa-paper-plane" aria-hidden="true"></i>
        </button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
@endif