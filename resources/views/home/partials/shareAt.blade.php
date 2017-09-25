<!--Share At-->
<small data-toggle="modal" data-target="#share-at">
    <i class="fa fa-cog" aria-hidden="true"></i> <b>Şurada Paylaş:</b> <span class="share-at-name">Profilim</span>
</small>
<div id="share-at" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title"><b>Şurada Paylaş</b></h3>
            </div>
            <div class="modal-body" style="padding-top: 0px;">
                <!--Share At Clubs-->
                <h3 class="share-at-clubs" data-toggle="collapse" data-target="#my-clubs"><i class="fa fa-arrow-down" aria-hidden="true"></i> Kulüp</h3>
                <div id="my-clubs" class="collapse">
                    @foreach($clubs as $club)
                        @include('home.partials.clubblock')
                    @endforeach
                </div>
                <!--/ Share At Clubs-->
                <!--Share At Events-->
                <h3 class="share-at-events" data-toggle="collapse" data-target="#my-events"><i class="fa fa-arrow-down" aria-hidden="true"></i> Etkinlik</h3>
                <div id="my-events" class="collapse">
                    @foreach($events as $event)
                        @include('home.partials.eventblock')
                    @endforeach
                </div>
                <!--/ Share At Events-->
                <!-- Share At Pages-->
                <h3 class="share-at-pages" data-toggle="collapse" data-target="#my-pages"><i class="fa fa-arrow-down" aria-hidden="true"></i> Sayfa</h3>
                <div id="my-pages" class="collapse">
                    @foreach($pages as $page)
                        @include('home.partials.pageblock')
                    @endforeach
                </div>
                <!--/ Share At Pages-->
            </div>
        </div>
    </div>
</div>
<!--/ Share At-->
