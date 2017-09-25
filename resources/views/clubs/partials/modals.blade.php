@if(Auth::user()->isAdmin($club))
<!--Uploading Avatar-->
    <!--Modal Fade-->
    <div class="modal fade" id="uploadAvatar" role="dialog">
        <!--Modal Dialog-->
        <div class="modal-dialog">
            <!--Modal Content-->
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Kulüp Profil Fotoğrafını Değiştir</h4>
                </div><!--/ Modal Header-->
                <!--Modal Body-->
                <div class="modal-body text-center">
                    <form action="/club/{{$club->abbreviation}}/upload/avatar" enctype="multipart/form-data" method="post">
                        <label  id="file-name-avatar" for="select-file-avatar">Fotoğraf Seç</label>
                        <input id="select-file-avatar" type="file" name="avatar" accept="image/*" class="hidden">
                        <button type="submit" class="btn btn-sm btn-success">Onayla</button>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div><!--/ Modal Body-->
            </div><!--/ Modal Content-->
        </div><!--/ Modal Dialog-->
    </div><!--/ Modal Fade-->
<!--End of Uploading Avatar-->

<!--Uploading Cover-->
    <!--Modal Fade-->
    <div class="modal fade" id="uploadCover" role="dialog">
        <!--Modal Dialog-->
        <div class="modal-dialog">
            <!--Modal Content-->
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Kapak Fotoğrafını Değiştir</h4>
                </div><!--/ Modal Header-->
                <!--Modal Body-->
                <div class="modal-body text-center">
                    <form action="/club/{{$club->abbreviation}}/upload/cover" enctype="multipart/form-data" method="post">
                        <label  id="file-name-cover" for="select-file-cover">Fotoğraf Seç</label>
                        <input id="select-file-cover" type="file" name="cover" accept="image/*" class="hidden">
                        <button type="submit" class="btn btn-sm btn-success">Onayla</button>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div><!--/ Modal Body-->
            </div><!--/ Modal Content-->
        </div><!--/ Modal Dialog-->
    </div><!--/ Modal Fade-->
<!--End of Uploading Cover-->
@endif


<!--Modal Fade-->
<div class="modal fade" id="quit" role="dialog">
    <!--Modal Dialog-->
    <div class="modal-dialog">
        <!--Modal Content-->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Bu Kulüpten Ayrılmak İstediğine Emin Misin?</h4>
            </div><!--/ Modal Header-->
            <!--Modal Body-->
            <div class="modal-body">
                <form class="inline" id="quit-club" action="/club/quit/{{$club->abbreviation}}" method="post">
                    <button class="btn btn-danger navbar-btn btn-block" type="submit" >Kulüpten Çık</button>
                    <input type="hidden" name="_token" value="{{ Session::token() }}"/>
                </form>
            </div><!--/ Modal Body-->
        </div><!--/ Modal Content-->
    </div><!--/ Modal Dialog-->
</div><!--/ Modal Fade-->
