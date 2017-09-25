<div class="media">
    <a class="pull-left link" href="/event/create/{{$club->abbreviation}}">
        <img class="img-rounded" alt=" {{ $club->name }} " src="/storage/avatars/{{$club->avatar}}" style="width:50px; height:50px;"/>
    </a>
    <div class="media-body">
        <h4 class="media-heading"><a class="link-header" href="/event/create/{{$club->abbreviation}}">{{ $club->name }}</a></h4>
        <p class="text-muted">{{ $club->abbreviation }}</p>
    </div>
</div>
