<!-- Timeline statuses and replies -->
@if(!$statuses->count())
    <p class="small text-center">Henüz hiçbir şey paylaşılmamış.</p>
@else
    @foreach($statuses as $status)
        @include('statuses.partials.statusblock')
    @endforeach
@endif
{{ $statuses->links() }}
