@extends('Layout.page')
@section('head')

@stop
@section('left_content')
    @include('pages.home.left_content0')
@stop
@section('content')
    @php
    $account_info=json_decode($account,true);
    @endphp

    <div class="table_div" style="padding-left: 10px;padding-right: 10px">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="{{action('ApiController@update_user')}}" class="review-content-section" method="post">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h1>Change Password</h1>
                        <div class="devit-card-custom">
                            <div class="form-group">
                                <label>Old Password</label>
                                <input name="password" type="password" class="form-control" placeholder="Password" value="">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input name="password" type="password" class="form-control" placeholder="Password" value="">
                            </div>
                            <div class="form-group">
                                <label>Conform Password</label>
                                <input name="password" type="password" class="form-control" placeholder="Password" value="">
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Reset Password</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


@stop
@section('right_content')
    @include('pages.home.right_content')
@stop
@section('script')
    <script>
        $(document).ready(function() {

        });
    </script>
@stop