@if(Auth::check() && Auth::user()->id === $user->id)
	<div class="row">
	    <div class="col-lg-8 col-lg-offset-2">
	        @include('users.header.partials.posting')
	        <hr>
	    </div>
	</div>
@endif
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <!--Starting of the User Statuses-->
        <h3><b>Paylaşımlar</b></h3>
        <section class="results">
            @include('statuses.load')
        </section>
        <!--End of the User Statuses-->
    </div>
</div>
