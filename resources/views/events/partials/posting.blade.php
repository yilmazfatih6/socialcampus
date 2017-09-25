<h3><strong>Paylaşım Yap</strong></h3>
<form role="form" action="/event/{{$event->id}}/post" enctype="multipart/form-data" method="post">
    <div class="form-group{{$errors->has('status') ? ' has-error' : ''}}">
        <textarea placeholder="{{$event->name}} hakkında paylaşımda bulun..." name="status" class="form-control" rows="2"></textarea>
        @if($errors->has('status'))
            <span class="help-block">{{$errors->first('status')}}</span>
        @endif
    </div>
    <!--Sharing Image-->
    <div class="form-group{{$errors->has('image') ? ' has-error' : ''}}" style="display: inline; margin-right:5px;">
        <label for="image">
                <span class="glyphicon glyphicon-camera"></span> Fotoğraf
        </label>
        <input type="file" name="image" accept="image/*" id="image" style="opacity:0; z-index:-1; position:absolute;">
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
