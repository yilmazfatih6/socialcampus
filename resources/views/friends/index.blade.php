@extends('templates.default')

@section('content')
    <div id="friends-wrapper">
        <div class="row" id="friends">
            <div class="col-lg-8">
                <h3>Arkadaş Listesi</h3>
            @if(!$friends->count())
                <p class="text-muted">Arkadaş listesine henüz hiç kimse eklenmemiş.<p>
            @else
                @foreach($friends as $user)
                    <div class="col-lg-6 col-md-6" style="margin:0 0 13px -13px;">
                        @include('users.partials.userblock')
                    </div>
                @endforeach
            @endif
            </div>
            <div class="col-lg-4 col-md-6">
                <h4 class="inline">Arkadaşlık İstekleri</h4>
                @if(Auth::user()->friendRequests()->count())
                    <span class="badge badge-nav">{{Auth::user()->friendRequests()->count()}}</span>
                @endif    
                @if(!$requests->count())
                    <p class="text-muted">Şuanda herhangi bir arkadaşlık isteğiniz yok.</p>
                @else
                    @foreach($requests as $user)
                        @include('users.partials.userblock')
                    @endforeach
                @endif
            </div>
        </div>
    </div>    
@endsection
