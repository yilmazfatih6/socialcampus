<div class="media share-at-club-media" data-id="{{$club->id}}">
    <a class="pull-left link">
        <img class="img-circle" src="/storage/avatars/{{$club->avatar}}" style="width:50px; height:50px;"/>
    </a>
    <div class="media-body">
        <h4 class="media-heading"><a class="link-header">{{ $club->name }}</a></h4>
        <p class="text-muted">{{ $club->abbreviation }}</p>
    </div>
</div>
