<div class="media share-at-page-media" data-id="{{$page->id}}">
    <a class="pull-left link">
        <img class="img-circle" src="/storage/avatars/{{$page->avatar}}" style="width:50px; height:50px;"/>
    </a>
    <div class="media-body">
        <h4 class="media-heading"><a class="link-header">{{ $page->name }}</a></h4>
        <p class="text-muted">{{ $page->abbr }}</p>
    </div>
</div>
