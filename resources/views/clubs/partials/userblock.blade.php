<div class="media" id="userblock-{{$user->id}}">
    <div class="media-left media-top">
        <a class="pull-left" href="/user/{{$user->username}}">
            <img class="img-circle" alt=" {{ $user->getNameOrUsername() }} " src="/storage/avatars/{{$user->avatar}}" style="width:85px; height:85px;"/>
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading"><a href="/user/{{$user->username}}">{{ $user->getNameOrUsername() }}</a></h4>
        <span class="text-muted"><span>@</span>{{ $user->username }}</span><br>
      
        <!--Kick User-->
        @if($user->id !== Auth::user()->id && !$club->isAdmin($user) && $club->isMember($user))
            <form id="club-kick-user" action="/club/{{$club->abbreviation}}/kick/{{$user->username}}" method="post" class="inline">
                <div class="form-group inline"> 
                    <button type="submit" class="btn btn-sm btn-danger">
                        Kulüpten At
                    </button>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                </div>
            </form>
        @endif    
        
        @if($club->hasRequest($user))
            <form id="club-accept-member" action="/club/{{$club->abbreviation}}/accept/{{$user->username}}" method="post" class="inline">
                <button type="submit" class="btn btn-success btn-sm">Kabul Et</button>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
            <form id="club-reject-member" action="/club/{{$club->abbreviation}}/reject/{{$user->username}}" method="post" class="inline">
                <button type="submit" class="btn btn-danger btn-sm">Reddet</button>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
        @endif

    </div>
</div>
