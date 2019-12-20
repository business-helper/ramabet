@extends('user.Layout.page_template')
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
                        <input id="id" name="id" type="hidden" value="{{$account_info['id']}}">
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

@section('script')
@stop