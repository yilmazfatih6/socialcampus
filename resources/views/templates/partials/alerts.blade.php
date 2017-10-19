<!--Adding Popup Alert After This-->
<div id="after"></div>

@if (Session::has('info'))

    <div class="alert alert-info alert-dismissable fade in text-center" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('info') }}
    </div>

@endif
@if (Session::has('danger'))

    <div class="alert alert-danger alert-dismissable fade in text-center" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('danger') }}
    </div>

@endif
@if (Session::has('success'))

    <div class="alert alert-success alert-dismissable fade in text-center" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('success') }}
    </div>

@endif
@if (Session::has('warning'))

    <div class="alert alert-warning alert-dismissable fade in text-center" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('warning') }}
    </div>

@endif
