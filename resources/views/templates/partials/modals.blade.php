<!--Modal Fade-->
<div class="modal fade" id="signin-modal" role="dialog">
    <!--Modal Dialog-->
    <div class="modal-dialog">
        <!--Modal Content-->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
	        	<h2 class="inline">Giriş Yap</h2>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            </div><!--/ Modal Header-->
            <!--Modal Body-->
            <div class="modal-body">
            	<form class="form-horizontal signin-form" role="form" method="post" action="/signin">
        			<!--Username Input-->
        			<label for="username" class="control-label">Kullanıcı Adı</label>
        			<div class="input-group{{ $errors->has('username') ? ' has-error' : ''}}">
        				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        				<input type="text" class="form-control username"  name="username" placeholder="Kullanıcı Adı" value="{{old('username')}}" required autofocus>
        				@if($errors->has('username'))
		            		<span class="help-block">{{ $errors->first('username') }}</span>
		        		@endif
        			</div>
        			<!--Password Input-->
        			<label for="password" class="control-label" style="margin-top: 5px;">Şifre</label>
        			<div class="input-group{{ $errors->has('password') ? ' has-error' : ''}}">
        				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        				<input type="password" class="form-control password" name="password" placeholder="Şifre" id="password" required>
        				@if($errors->has('password'))	
    		            		<span class="help-block">{{ $errors->first('password') }}</span>
    		       		@endif
        			</div><br>
        			
        			<!--Remember Me
        			<div class="checkbox inline">
        				<label class="link">
        					<input type="checkbox" id="remember" name="remember"> Beni Hatırla
        				</label>
        			</div>-->

        			<!--Submit Button-->
        			<div class="form-gorup inline">
        				<button type="submit" class="btn btn-success btn-block">Giriş Yap</button>
        			</div><br>
        		
                	<div role="alert" class="signin-alert"></div>

          			<input type="hidden" name="_token" value="{{ Session::token() }}"/>
        		
                </form>
            </div><!--/ Modal Body-->
        </div><!--/ Modal Content-->
    </div><!--/ Modal Dialog-->
</div><!--/ Modal Fade-->
