<!--SELECT USER FOR NEW CHAT-->
<!--Modal Fade-->
<div class="modal fade" id="selectUser" role="dialog">
    <!--Modal Dialog-->
    <div class="modal-dialog">
        <!--Modal Content-->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            	<h4 class="inline">Şuna mesaj at...</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            </div><!--/ Modal Header-->
            <!--Modal Body-->
            <div class="modal-body">

                <users :users="{{$friends}}"></users>
            </div><!--/ Modal Body-->
        </div><!--/ Modal Content-->
    </div><!--/ Modal Dialog-->
</div><!--/ Modal Fade-->


<!--SELECT CLUB FOR NEW CHAT-->
<!--Modal Fade-->
<div class="modal fade" id="selectClub" role="dialog">
    <!--Modal Dialog-->
    <div class="modal-dialog">
        <!--Modal Content-->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="inline">Şuna Kulübe mesaj at...</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div><!--/ Modal Header-->
            <!--Modal Body-->
            <div class="modal-body">
                @if(!empty(Auth::user()->clubs()->get()) && count(Auth::user()->clubs()->get()))    
                    <clubs :user="{{Auth::user()}}" :clubs="{{Auth::user()->clubs()->get()}}"></clubs>
                @else
                    <small class="text-center">Üyesi olduğun kulüp yok.</small>
                @endif
            </div><!--/ Modal Body-->
        </div><!--/ Modal Content-->
    </div><!--/ Modal Dialog-->
</div><!--/ Modal Fade-->


<!--SELECT EVENT FOR NEW CHAT-->
<!--Modal Fade-->
<div class="modal fade" id="selectEvent" role="dialog">
    <!--Modal Dialog-->
    <div class="modal-dialog">
        <!--Modal Content-->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="inline">Şuna Etkinliğe mesaj at...</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div><!--/ Modal Header-->
            <!--Modal Body-->
            <div class="modal-body">
                @if(!empty(Auth::user()->events()->get()) && count(Auth::user()->events()->get()))
                    <events :user="{{Auth::user()}}" :events="{{Auth::user()->events()->get()}}"></events>
                @else
                    <small class="text-center">Gitmekte olduğun etkinlik yok.</small>
                @endif
            </div><!--/ Modal Body-->
        </div><!--/ Modal Content-->
    </div><!--/ Modal Dialog-->
</div><!--/ Modal Fade-->

<!--SELECT PAGE FOR NEW CHAT-->
<!--Modal Fade-->
<div class="modal fade" id="selectPage" role="dialog">
    <!--Modal Dialog-->
    <div class="modal-dialog">
        <!--Modal Content-->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="inline">Şuna Sayfaya mesaj at...</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div><!--/ Modal Header-->
            <!--Modal Body-->
            <div class="modal-body">
                @if(count(Auth::user()->pages()->get()))
                    <pages :user="{{Auth::user()}}" :pages="{{Auth::user()->pages()->get()}}"></pages>
                @else
                    <small class="text-center">Takip ettiğin sayfa yok.</small>
                @endif
            </div><!--/ Modal Body-->
        </div><!--/ Modal Content-->
    </div><!--/ Modal Dialog-->
</div><!--/ Modal Fade-->