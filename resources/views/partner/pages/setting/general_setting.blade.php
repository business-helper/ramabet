@extends('admin.Layout.pagetemplate')
@section('head')

    <style>
        .avatar-upload {
            position: relative;
        }
        .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }
        .avatar-upload .avatar-edit input {
            display: none;
        }
        .avatar-upload .avatar-edit input + label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: normal;
            transition: all 0.2s ease-in-out;
        }
        .avatar-upload .avatar-edit input + label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }
        .avatar-upload .avatar-edit input + label:after {
            content: "\f040";
            font-family: 'FontAwesome';
            color: #757575;
            position: absolute;
            top: 10px;
            left: 0;
            right: 0;
            text-align: center;
            margin: auto;
        }
        .avatar-upload .avatar-preview {

            position: relative;

            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
        }
        .avatar-upload .avatar-preview > div {
            width: auto;
            height: 270px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

    </style>
@stop
@section('content')
    <div class="block-header">
        <h2>General Setting</h2>
    </div>
    <div class="clearfix">
        <div class="card">
            <div class="header">
                General Setting
            </div>
            <div class="body">
                <form class="form-horizontal" method="post" action="{{route('admin.general_setting_post')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <fieldset>
                        <!-- Website Name-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="textinput">Website Name</label>
                                    <div class="col-md-9">
                                        <input id="website_name" name="website_name" type="text" placeholder="Website Name" class="form-control input-md" value="{{$data['website_name']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Copyright-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="textinput">Copyright</label>
                                    <div class="col-md-9">
                                        <input id="copyright" name="copyright" type="text" placeholder="Copyright" class="form-control input-md" value="{{$data['copyright']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Copyright-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="textinput">Contact Email	</label>
                                    <div class="col-md-9">
                                        <input id="contact_email" name="contact_email" type="email" placeholder="Contact Email" class="form-control input-md" value="{{$data['contact_email']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Login -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="login">Login</label>
                                    <div class="col-md-9">
                                        <select id="login" name="login" class="form-control show-tick">
                                            <option value="yes" {{$data['login']=='yes'?'selected':''}}>Yes</option>
                                            <option value="no" {{$data['login']=='yes'?'':'selected'}}>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Password reset -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="selectbasic">Password reset</label>
                                    <div class="col-md-9">
                                        <select id="password_rest" name="password_rest" class="form-control show-tick">
                                            <option value="yes" {{$data['password_rest']=='yes'?'selected':''}}>Yes</option>
                                            <option value="no" {{$data['password_rest']=='yes'?'':'selected'}}>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Password reset -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="selectbasic">Balance Menu</label>
                                    <div class="col-md-9">
                                        <select id="balance_menu" name="balance_menu" class="form-control show-tick">
                                            <option value="yes" {{$data['balance_menu']=='yes'?'selected':''}}>Yes</option>
                                            <option value="no" {{$data['balance_menu']=='yes'?'':'selected'}}>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Service fee-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="textinput">Service fee</label>
                                    <div class="col-md-9">
                                        <input id="service_fee" name="service_fee" type="number" placeholder="Service fee in % from stake" class="form-control input-md" value="{{$data['service_fee']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Min Stake -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="selectbasic">Min Stake</label>
                                    <div class="col-md-9">
                                        <select id="min_stake" name="min_stake" class="form-control show-tick">
                                            <option value="1" {{$data['min_stake']=='1'?'selected':''}}>1</option>
                                            <option value="100" {{$data['min_stake']=='100'?'selected':''}}>100</option>
                                            <option value="200" {{$data['min_stake']=='200'?'selected':''}}>200</option>
                                            <option value="300" {{$data['min_stake']=='300'?'selected':''}}>300</option>
                                            <option value="400" {{$data['min_stake']=='400'?'selected':''}}>400</option>
                                            <option value="500" {{$data['min_stake']=='500'?'selected':''}}>500</option>
                                            <option value="600" {{$data['min_stake']=='600'?'selected':''}}>600</option>
                                            <option value="700" {{$data['min_stake']=='700'?'selected':''}}>700</option>
                                            <option value="800" {{$data['min_stake']=='800'?'selected':''}}>800</option>
                                            <option value="900" {{$data['min_stake']=='900'?'selected':''}}>900</option>
                                            <option value="1000" {{$data['min_stake']=='1000'?'selected':''}}>1000</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Max Stake -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="selectbasic">Max Stake</label>
                                    <div class="col-md-9">
                                        <select id="max_stake" name="max_stake" class="form-control show-tick">
                                            <option value="100" {{$data['max_stake']=='100'?'selected':''}}>100</option>
                                            <option value="200" {{$data['max_stake']=='200'?'selected':''}}>200</option>
                                            <option value="300" {{$data['max_stake']=='300'?'selected':''}}>300</option>
                                            <option value="400" {{$data['max_stake']=='400'?'selected':''}}>400</option>
                                            <option value="500" {{$data['max_stake']=='500'?'selected':''}}>500</option>
                                            <option value="600" {{$data['max_stake']=='600'?'selected':''}}>600</option>
                                            <option value="700" {{$data['max_stake']=='700'?'selected':''}}>700</option>
                                            <option value="800" {{$data['max_stake']=='800'?'selected':''}}>800</option>
                                            <option value="900" {{$data['max_stake']=='900'?'selected':''}}>900</option>
                                            <option value="1000" {{$data['max_stake']=='1000'?'selected':''}}>1000</option>
                                            <option value="nolimit" {{$data['max_stake']=='nolimit'?'selected':''}}>No Limit</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{--Max Profit--}}
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="textinput">Max Profit</label>
                                    <div class="col-md-9">
                                        <input id="max_profit" name="max_profit" type="number" placeholder="Max Profit" class="form-control input-md" value="{{$data['max_profit']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{--Max Loss--}}
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="textinput">Max Loss</label>
                                    <div class="col-md-9">
                                        <input id="max_loss" name="max_loss" type="number" placeholder="Max Loss" class="form-control input-md" value="{{$data['max_loss']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{--Max Rate--}}
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="max_rate">Max Rate</label>
                                    <div class="col-md-9">
                                        <input id="max_rate" name="max_rate" type="number" placeholder="Max Rate" class="form-control input-md" value="{{$data['max_rate']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{--Session Min Stake--}}
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="session_min_stake">Session Min Stake</label>
                                    <div class="col-md-9">
                                        <input id="session_min_stake" name="session_min_stake" type="number" placeholder="session_min_stake" class="form-control input-md" value="{{$data['session_min_stake']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{--session_max_stake--}}
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="session_max_stake">Session Max Stake</label>
                                    <div class="col-md-9">
                                        <input id="session_min_stake" name="session_max_stake" type="number" placeholder="session_max_stake" class="form-control input-md" value="{{$data['session_max_stake']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{--session_per_rate_max--}}
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="session_per_rate_max">Session per rate max</label>
                                    <div class="col-md-9">
                                        <input id="session_min_stake" name="session_per_rate_max" type="number" placeholder="session_per_rate_max" class="form-control input-md" value="{{$data['session_per_rate_max']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{--session_max_loss--}}
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="session_max_loss">Session max loss</label>
                                    <div class="col-md-9">
                                        <input id="session_min_stake" name="session_max_loss" type="number" placeholder="session_max_loss" class="form-control input-md" value="{{$data['session_max_loss']}}">
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-md-6">
                                --}}{{--api token--}}{{--
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="session_max_loss">Api token</label>
                                    <div class="col-md-9">
                                        <input id="api_token" name="api_token" type="text" placeholder="api token" class="form-control input-md" value="{{$data['api_token']}}">
                                    </div>
                                </div>
                            </div>--}}
                            <div class="col-md-6">
                                {{--banners--}}
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="session_max_loss">Banners</label>
                                    <div class="col-md-9">
                                        <input id="api_token" name="banners" type="text" placeholder="abanners" class="form-control input-md" value="{{$data['banners']}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Main Image-->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="textinput">Logo Image</label>
                            <div class="col-md-9" style="border-radius: 20px">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="logo_image" name="logo_image" class="input_image" accept=".png, .jpg, .jpeg" />
                                        <label for="logo_image"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="logo_imagePreview" style="background-image: url({{asset('img/'.$data['logo_image'])}});">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Footer Text -->
                        <div class="form-group">
                            <label class="col-md-12" for="footer_text">Footer Text</label>
                            <div class="col-md-12">
                                <textarea class="form-control" id="footer_text" name="footer_text" value="">{{$data['footer_text']}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" style="text-align: center">{{isset($msg)?$msg:''}}</label>

                        </div>
                        <!-- Button -->
                        <div class="form-group">
                            <div class="col-md-12" style="text-align: center;">
                                <button id="submit" type="submit" name="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    {{--<div class="admintab-wrap edu-tab1 mg-t-30">
        <ul class="nav nav-tabs custom-menu-wrap custon-tab-menu-style1">
            <li class="active"><a data-toggle="tab" href="#TabProject"><span class="edu-icon edu-analytics tab-custon-ic"></span>Universal Setting</a>
            </li>
            <li><a data-toggle="tab" href="#TabDetails"><span class="edu-icon edu-analytics-arrow tab-custon-ic"></span>General Fules & Conditions</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="TabProject" class="tab-pane in active animated flipInX custon-tab-style1">
                --}}{{----}}{{--
            </div>
            <div id="TabDetails" class="tab-pane animated flipInX custon-tab-style1">
                <div class="tinymce-single mg-t-30 rule">
                    <div class="alert-title">
                        <h2>Rules</h2>
                    </div>
                    <div id="summernote4">
                        @php( print_r($data['rules']))
                    </div>
                </div>
                <div class="tinymce-single condition">
                    <div class="alert-title">
                        <h2>Terms and Conditions</h2>
                        <p></p>
                    </div>
                    <div id="summernote2">
                        @php( print_r($data['conditions']))
                    </div>
                    <div class="form-group">
                        <div class="col-md-12" style="text-align: center;">
                            <button id="save" type="button" name="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
@stop
@section('script')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('user/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
    <script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>

    <script>
        function readURL(input) {
            //alert("asdf");
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#'+input.id+'Preview').css('background-image', 'url('+e.target.result +')');
                    //alert(e.target.result);
                    $('#'+input.id+'Preview').hide();
                    $('#'+input.id+'Preview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".input_image").change(function() {
            //alert("asdf");
            //console.log(this.id);
            readURL(this);
        });
        $('#save').click(function () {
            var rules=$('.rule .panel-body').html();
            var conditions=$('.condition .panel-body').html();
            //console.log(rule_source);
            //console.log(condition);
            $.ajax({
                url: 'https://odds24ex.com/api/check_set',
                type: 'post',
                data: { id:26,value:rules,field:'value',table_name:'general_setting'} ,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function(response){
                    //console.log(response);
                    var obj = JSON.parse(response);
                    console.log(obj);
                },
                error: function(response){
                    console.log(response);
                    //alert('error');
                }
            });
            $.ajax({
                url: 'https://odds24ex.com/api/check_set',
                type: 'post',
                data: { id:27,value:conditions,field:'value',table_name:'general_setting'} ,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function(response){
                    //console.log(response);
                    var obj = JSON.parse(response);
                    console.log(obj);
                },
                error: function(response){
                    console.log(response);
                    //alert('error');
                }
            });
        });
    </script>
@stop
