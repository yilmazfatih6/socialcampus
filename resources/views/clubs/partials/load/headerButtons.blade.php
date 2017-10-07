@if(Auth::user()->isMember($club))
    <a data-toggle="modal" data-target="#quit" class="btn btn-danger btn-action pull-right" style="margin-top:7px;">
        <i class="fa fa-times" aria-hidden="true"></i>
    </a>
<!--Modal is in view('clubs.profile')-->
@elseif(Auth::user()->isRequestedClub($club))
    <button class="btn btn-warning navbar-btn btn-action pull-right">
        <i class="fa fa-clock-o" aria-hidden="true"></i>
    </button>
@else
    <form id="join-club" class="inline pull-right" action="/club/add/{{$club->abbreviation}}" method="post">
        <button class="btn btn-success navbar-btn btn-action">
            <i class="fa fa-paper-plane" aria-hidden="true"></i>
        </button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
@endif