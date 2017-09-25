@extends('templates.default')

<!--Profile Infos-->
@section('header')
    <div class="row">
        <div class="col-lg-12">
            @include('users.header.index')
        </div>
    </div>
@endsection
<!--End Profile Infos-->

@section('content')
    @include('users.partials.modals')
    <div class="container">
        <div class="row">
            <!-- List Of Pills -->
            <ul class="nav nav-pills nav-justified tabs-nav"  id="tabs">
                <li class="active">
                    <a data-toggle="pill" href="#home">Paylaşımlar</a>
                </li>
                <li>
                    <a data-toggle="pill" href="#friends">Arkadaşlar</a>
                </li>
                <li>
                    <a data-toggle="pill" href="#clubs">Kulüpler</a>
                </li>
            </ul>
            <!-- Tab Content -->
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active"><br>
                    @include('users.content.home')
                </div>
                <div id="friends" class="tab-pane fade">
                    @include('users.content.friends')
                </div>
                <div id="clubs" class="tab-pane fade">
                    @include('users.content.clubs')
                </div>
            </div>
        </div>
    </div>
@stop
