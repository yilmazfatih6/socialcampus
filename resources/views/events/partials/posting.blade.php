<h3><strong>Paylaşım Yap</strong></h3>
<form role="form" action="/event/{{$event->id}}/post" enctype="multipart/form-data" method="post">
    <div class="form-group{{$errors->has('status') ? ' has-error' : ''}}">
        <textarea placeholder="{{$event->name}} hakkında paylaşımda bulun..." name="status" class="form-control" rows="2"></textarea>
        @if($errors->has('status'))
            <span class="help-block">{{$errors->first('status')}}</span>
        @endif
    </div>
    
    <!--Select File & Share-->
    <div class="row container-fluid">
        <!--Sharing Image-->
        <div class="inline posting-file form-group{{$errors->has('image') ? ' has-error' : ''}}">
            <label for="image" class="posting-image">
                     <i class="fa fa-camera" aria-hidden="true"></i> Fotoğraf
            </label>
            <input type="file" name="image" accept="image/*" id="image" class="hidden posting-select-image">
            @if($errors->has('image'))
                <span class="help-block">{{$errors->first('image')}}</span>
            @endif
        </div>
        <!--Sharing Video-->
        <div class="inline posting-file form-group{{$errors->has('video') ? ' has-error' : ''}}">
            <label for="video" class="posting-video">
                   <i class="fa fa-video-camera" aria-hidden="true"></i> Video
            </label>
            <input type="file" name="video" accept="video/*" id="video" class="hidden posting-select-video">
            @if($errors->has('video'))
                <span class="help-block">{{$errors->first('video')}}</span>
            @endif
        </div>
        <div class="pull-right">
            <button type="submit" class="btn btn-default btn-share btn-sm">Paylaş</button>
        </div>
    </div>

    <!--Selected File Name-->
    <div class="row container-fluid">
        <span class="selected-file-name"></span>
    </div>
    
    <input type="hidden" name="_token" value="{{Session::token()}}">
</form>
