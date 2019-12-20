<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{$general_setting['website_name']}}</title>
    <!-- Favicon-->
    <link rel="icon" href="{{asset('user/favicon.ico')}}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('user/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('user/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('user/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('user/css/style.css')}}" rel="stylesheet">
    <style>
        html{
            height: 100%;
        }
        .login-page {
            background-image: url("/public/img/admin_login.jpg")!important;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            padding-left: 0;
            margin: auto!important;
            max-width: 360px;
            height: 100%;

            padding-top: 16%;
            overflow-x: hidden;
        }
    </style>
</head>

<body class="login-page">
<div class="login-box">
    <div class="logo">
        <div class="" style="min-width:300px;width: 60%;margin-bottom: 20px; margin: auto;text-align: center;color: white;" >
            <a class="" href="{{url('/')}}"><img height="35px" src="{{asset('img/logo1.png')}}" style="width: 100%;height: auto;max-width: 500px"></a>
            {{-- <img src="{{asset('img/powered.png')}}" style="width: 60%"/>--}}
        </div>
    </div>
    <div class="card" style="opacity: .8">
        <div class="body">
            <form id="sign_in" method="POST" action="{{ route('admin.login.submit') }}">
                {{ csrf_field() }}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="msg">Sign in to start your session</div>
                @if ($errors->has('LockAccount'))
                    <span class="help-block">
                        <strong>{{ $errors->first('LockAccount') }}</strong>
                                    </span>
                @endif
                <div class="input-group">
                    {{--<span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>--}}
                    <div class="form-line">
                        <input type="text" placeholder="User Name" title="Please enter you username" required="" value="" name="email" id="name" class="form-control">
                        @if ($errors->has('identity'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="input-group">
                    {{--  <span class="input-group-addon">
                          <i class="material-icons">lock</i>
                      </span>--}}
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                {{--<div class="input-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                        <label class="form-check-label" for="remember">
                            Multi Login/Single login
                        </label>
                    </div>
                </div>--}}
                <button type="submit" class="btn btn-success btn-block loginbtn" style="width: 100px;margin: auto">
                    Login
                </button>
                <p style="text-align: center; margin-top: 10px;"> ©️ sport.rama333.com</p>
                <div class="col-xs-6">


                </div>
                <div class="col-xs-6 align-right">

                </div>
        </div>
        </form>
    </div>
</div>
</div>

<!-- Jquery Core Js -->
<script src="{{asset('user/plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core Js -->
<script src="{{asset('user/plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{asset('user/plugins/node-waves/waves.js')}}"></script>

<!-- Validation Plugin Js -->
<script src="{{asset('user/plugins/jquery-validation/jquery.validate.js')}}"></script>

<!-- Custom Js -->
<script src="{{asset('user/js/admin.js')}}"></script>
<script src="{{asset('user/js/pages/examples/sign-in.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>

</html>