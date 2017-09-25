<!-- Upload Avatar Modal -->
<div class="modal fade" id="uploadAvatar" role="dialog">
    <!--modal dialog-->
    <div class="modal-dialog">
        <!--modal content-->
        <div class="modal-content" id="upload-avatar-modal-content">
            <!--modal header-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Profil Fotoğrafını Değiştir</h4>
            </div><!--/ modal header-->
            <!--modal body-->
            <div class="modal-body">
                <div class="text-center">
                    <form action="/profile/upload/avatar" method="post" enctype="multipart/form-data">
                        <label  id="file-name-avatar" for="select-file-avatar">Fotoğraf Seç</label>
                        <input id="select-file-avatar" type="file" name="avatar" accept="image/*" class="hidden">
                        <button type="submit" class="btn btn-sm btn-success">Onayla</button>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
            </div><!--/ modal body-->
        </div><!-- / modal content-->
    </div><!-- /modal dialog-->
</div><!-- / Modal fade-->

<!-- Upload Cover Modal -->
<div class="modal fade" id="uploadCover" role="dialog">
    <!--modal dialog-->
    <div class="modal-dialog">
        <!--modal content-->
        <div class="modal-content" id="upload-avatar-modal-content">
            <!--modal header-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Kapak Fotoğrafını Değiştir</h4>
            </div><!--/ modal header-->
            <!--modal body-->
            <div class="modal-body">
                <div class="text-center">
                    <form action="/profile/upload/cover" method="post" enctype="multipart/form-data">
                        <label  id="file-name-cover" for="select-file-cover">Fotoğraf Seç</label>
                        <input id="select-file-cover" type="file" name="cover" accept="image/*" class="hidden">
                        <button type="submit" class="btn btn-sm btn-success">Onayla</button>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
            </div><!--/ modal body-->
        </div><!-- / modal content-->
    </div><!-- /modal dialog-->
</div><!-- / Modal fade-->
