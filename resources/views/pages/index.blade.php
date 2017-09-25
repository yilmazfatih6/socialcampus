@extends('templates.default')

@section('content')


<div class="container">
	@if(Auth::check())

		<!--Header & Create Button-->
		<div class="row">
		    	<div class="col-lg-12 text-center">
				<h1 class="inline">Sayfalar</h1>
				<a href="/page/create" class="btn-create">
					<i class="fa fa-plus" aria-hidden="true"></i>
				</a>
			</div>
		</div> <!-- / Header & Create Button-->

		<hr>
		@if( isset($pages) )
			<!--Admined Pages-->
			@if(Auth::user()->isPageAdminAny())
				<div class="row">
					<div class="col-lg-12">
						<h4 ><b>Yönetici Olduğun Sayfalar</b></h4>
					</div>
					@foreach($pages as $page)
						@if($page->isAdmin(Auth::user()))
							<div class="col-lg-4 col-md-4" style="margin-bottom:10px;">
								@include('pages.partials.pageblock')
							</div>
						@endif
					@endforeach
				</div>
			@endif<!-- / Admined Pages-->

			<!--Folowed Pages-->
			@if(Auth::user()->isFollowingAny())
				<div class="row">
					<div class="col-lg-12">
						<h4><b>Takip Ettiğin Kulüpler</b></h4>
					</div>
					@foreach($pages as $page)
						@if($page->isFollowing(Auth::user()))
							<div class="col-lg-4 col-md-4" style="margin-bottom:10px;">
									@include('pages.partials.pageblock')
							</div>
						@endif
					@endforeach
				</div>
			@endif<!-- / Folowed Pages-->


			<!--Other Pages-->
			<div class="row">

				@if( isset($otherPages) )
					@foreach($otherPages as $pages)
						<div class="col-lg-4 col-md-4" style="margin-bottom:10px;">
							@include('pages.partials.pageblock')
						</div>
					@endforeach
				@else
					@if( count($pages) )
						@foreach($pages as $page)
							<div class="col-lg-4 col-md-4" style="margin-bottom:10px;">
								@include('pages.partials.pageblock')
							</div>
						@endforeach
					@else
						<div class="col-lg-12 text-center">
							<small>Site üzerinde henüz hiç bir sayfa yok.</small>
						</div>
					@endif
				@endif

			</div> <!-- / Other Pages-->
		@endif<!--/ Is pages set?-->

	@endif

	<!-- Non Authenticated-->
	@if(!Auth::check())
		<div class="row">
			@if( count($pages) )
				<div class="col-lg-12">
					<h4><b>Tüm Sayfalar</b></h4>
				</div>
				@foreach($otherPages as $page)
					<div class="col-lg-4 col-md-4" style="margin-bottom:10px;">
							@include('pages.partials.pageblock')
					</div>
				@endforeach
			@else
				<div class="col-lg-12 text-center">
					<small>Site üzerinde henüz hiçbir sayfa yok.</small>
				</div>
			@endif
		</div>
	@endif	<!-- / Non Authenticated-->

</div>
@endsection
