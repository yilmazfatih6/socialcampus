<!--Sharing Reply Row-->
<div class="row">
    <div class="col-lg-12">
        <form id="make-comment" action="/status/{{$status->id}}/reply" method="post" role="form">
            <div class="form-group{{ $errors->has('reply-{$status->id}') ? ' has-error' : '' }}">
                <textarea name="reply-{{$status->id}}" class="form-control" rows="2" placeholder="Bu paylaşım hakkında yorum yaz"></textarea>
                @if($errors->has("reply-{$status->id}"))
                    <span class="help-block">{{$errors->first("reply-{$status->id}")}}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-default btn-sm btn-share pull-right">Yorum Yap</button>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
        <!--Ending of the Sharing Comment-->
    </div>
</div>
<!--End of the Sharing Reply Row-->
