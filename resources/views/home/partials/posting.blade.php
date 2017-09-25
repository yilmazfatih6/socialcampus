<h3><b>Paylaşım Yap</b></h3>
<form role="form" enctype="multipart/form-data" action="/status" method="post">
    <!--Sharing Text-->
    <div class="form-group{{ $errors->has('post') ? ' has-error' : '' }}">
        <textarea placeholder="Bir şeyler paylaşmaya ne dersin {{Auth::user()->getFirstNameOrUsername()}}?" name="post" class="form-control" rows="2"></textarea>
        @if($errors->has('post'))
            <span class="help-block">{{$errors->first('post')}}</span>
        @endif
    </div>
    <!--Sharing Image-->
    <div class="form-group{{$errors->has('image') ? ' has-error' : ''}}" style="display:inline; margin-right:5px;">
        <label for="image">
            <span class="glyphicon glyphicon-camera"></span> Fotoğraf
        </label>
        <input type="file" name="image" id="image" accept="image/*" style="opacity:0; z-index: -1; position: absolute;">
        @if($errors->has('image'))
            <span class="help-block">{{$errors->first('image')}}</span>
        @endif
    </div>
    <!--Sharing Video-->
    <div class="form-group{{$errors->has('video') ? ' has-error' : ''}}" style="display: inline;">
        <label for="video">
                <span class="glyphicon glyphicon-facetime-video"></span> Video
        </label>
        <input type="file" name="video" accept="video/*" id="video" style="opacity:0; z-index:-1; position:absolute;">
        @if($errors->has('video'))
            <span class="help-block">{{$errors->first('video')}}</span>
        @endif
    </div>
    <div class="pull-right">
        <button type="submit" class="btn btn-default btn-purple">Paylaş</button>
    </div>
    <input type="hidden" name="_token" value="{{Session::token()}}">
</form>
