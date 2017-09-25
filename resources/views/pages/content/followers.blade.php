<div class="row">
    <div class="col-lg-12">
        <h3><b>Sayfayı Takip Edenler</b></h3>
    </div>
    @foreach($followers as $user)
        <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:10px;">
            @include('users.partials.userblock')
        </div>
    @endforeach
</div>
