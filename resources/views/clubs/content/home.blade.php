<!--Posting-->
@if(Auth::user())
    @if(Auth::user()->isMember($club))
        <!--Posting Status-->
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
		@include('clubs.header.partials.posting')
		<br>
        	</div>
        </div>
    @endif
@endif

<!--Statuses-->
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <!--Starting of the Club Statuses-->
        <h3><b>Kulüp İçi Paylaşımlar</b></h3>
        <section class="results">
            @include('statuses.load')
        </section>
        <!--End of the Club Statuses-->
    </div>
</div>
<!-- / Statuses-->
