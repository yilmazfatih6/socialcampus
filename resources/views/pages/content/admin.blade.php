<div class="row margin-top-ten">

    <!--Change Avatar and Cover-->
    <div class="col-md-12">
        
        <!--Hidden on xs and sm devices-->
        <div class="btn-group btn-group-justified hidden-xs">
        
            <a class="btn btn-success" href="/page/{{$page->abbr}}/edit">Bilgileri Değiştir</a>
        
            <a data-toggle="modal" data-target="#uploadAvatar" class="btn btn-info">
                Fotoğrafı Değiştir
            </a>

            <a data-toggle="modal" data-target="#uploadCover" class="btn btn-success">
                Kapağı Değiştir
            </a>

        </div>

        <div class="btn-group-vertical btn-block hidden-lg hidden-md hidden-sm">
            <a class="btn btn-success">Bilgileri Değiştir</a>
        
            <a class="btn btn-success" data-toggle="modal" data-target="#uploadAvatar">
                Fotoğrafı Değiştir
            </a>

            <a class="btn btn-success" data-toggle="modal" data-target="#uploadCover">
                Kapağı Değiştir
            </a>
        </div>

    </div>

</div>
