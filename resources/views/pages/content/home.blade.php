<!--Posting Status-->
<div class="row">
    <div class="col-lg-6 col-md-offset-3">
        <!--Posting Status-->
        @if(Auth::user()->isPageAdmin($page))
            @include('pages.header.partials.posting')
        @endif
        <!--Starting of the Page Statuses-->
        <h3 class="text-center"><b>Sayfa Paylaşımları</b></h3>
        <section class="results">
            @include('statuses.load')
        </section>
    </div>
</div>
