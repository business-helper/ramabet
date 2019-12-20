<!DOCTYPE html>
<html lang="en">
<head>
    <title>RamaBet</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js" integrity="sha384-0pzryjIRos8mFBWMzSSZApWtPl/5++eIfzYmTgBBmXYdhvxPc+XcFEk+zJwDgWbP" crossorigin="anonymous"></script>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->

    <style>
        html {
            height: 100%;
            display: table;
            width: 100%;
        }
        body{

            display: contents;
        }
        @media screen and (max-width: 767px) {

        }
        form{
            color: black;

            border-radius: 10px;
            padding: 22px;
            text-align: center;
            max-width: 511px;
            margin-left: auto;
            margin-right: auto;
        }
        .mobile_show form .form-control{
            border-radius: 30px;
            background-color: #0b5ca0;
            color: #fffafa;
            border: 0;
        }
        .mobile_hide form{
            background-color: white;
        }
        .login_image{
            position: relative;
            background-image: url("{{asset('img/login.jpg')}}");
            height: 50%;
            background-position: top;
            background-size: cover;
            z-index: 100;
            border-radius: 61%/0 0 92px 92px;
        }
        @media (max-width: 767px) {
            .mobile_hide {
                display: none !important;
            }

            .mobile_show {
                display: block !important;
            }
        }
        .mobile_show {
            display: none;
        }
        .login-page {
            /*background-image: url("/public/img/admin_login.jpg") !important;*/
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            padding-left: 0;
            margin: auto !important;
            height: 100%;
            padding-top: 16%;
            overflow-x: hidden;
        }
    </style>
</head>
<body>
<div class="mobile_show">
    <div class="login_image">
        <div class="" style="min-width:300px;width: 60%;margin-bottom: 20px; margin: auto;text-align: center;color: white;padding-top: 184px" >
            <a class="" href="{{url('/')}}"><img height="35px" src="{{asset('img/logo1.png')}}" style="width: 100%;height: auto;max-width: 500px"></a>
            {{-- <img src="{{asset('img/powered.png')}}" style="width: 60%"/>--}}
        </div>
    </div>
    <div class="container-fluid" style="position: absolute;top: 24%;width: 100%;background-color: rgb(11,56,98);">
        <div class="row" style="border-radius: 50px; margin-top: 50%; padding: 20px; height: 50%;">
            @if ($errors->has('lock'))
                <span class="help-block">
                        <strong>{{ $errors->first('lock') }}</strong>
                                    </span>
            @endif
                @if ($errors->has('v_code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('v_code') }}</strong>
                                    </span>
                @endif
            <form method="POST" action="{{ route('login') }}">
                {{csrf_field()}}
                {{--  <div class="form-group" style="text-align: center;font-size: 20px;">
                      Login to skbefair.com
                  </div>--}}
                <div class="form-group{{ $errors->has('identity') ? ' has-error' : '' }}">
                    {{-- <p for="email" class="control-label"></p>--}}

                    <div class="">
                        <input id="identity" type="text" class="form-control" name="identity" value="{{ old('email') }}" placeholder="User name" required autofocus>

                        @if ($errors->has('identity'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('identity') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" style="margin-top: 20px">
                    {{-- <p for="password" class=" control-label">Password</p>--}}

                    <div class="">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" style="margin-top: 20px">
                    {{-- <p for="password" class=" control-label">Validation code</p>--}}
                    <div class="" style="position: relative">
                        @php
                            $code=rand(10000,99999);
                        @endphp
                        <input type="hidden" class="form-control" name="v_code1" value="{{$code}}">
                        <input type="text" class="form-control" name="v_code" placeholder="Validation code" required>
                        <span style="position: absolute; top: 5px; right: 10px; font-size: 18px; font-weight: bold;">{{$code}}</span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                </div>
                <div class="row" style="color: #b9bbbe">
                    ©️ RamaBet.com
                    {{-- <div class="col-sm-12" style="text-align: center">
                         For assistance please contact us at
                     </div>
                     <div class="col-sm-6">
                         <i class="far fa-envelope"></i>test@gmail.com
                     </div>
                     <div class="col-sm-6">
                         <i class="fas fa-mobile-alt"></i>+1 123123123
                     </div>--}}

                </div>
            </form>
        </div>

    </div>
</div>
<div class="mobile_hide login-page">
    <div class="login-box">
        <div class="logo">
            <div class=""
                 style="min-width:300px;width: 60%;margin-bottom: 20px; margin: auto;text-align: center;color: white;">
                <a class="" href="{{url('/')}}"><img height="35px" src="{{asset('img/logo1.png')}}"
                                                     style="width: 100%;height: auto;max-width: 500px"></a>
                {{-- <img src="{{asset('img/powered.png')}}" style="width: 60%"/>--}}
            </div>
        </div>
        <div class="card" style="opacity: .8">
            <div class="body">
                <div class="row" style="border-radius: 50px; height: 50%;">
                    <form method="POST" action="{{ route('login') }}">
                        {{csrf_field()}}
                        {{--  <div class="form-group" style="text-align: center;font-size: 20px;">
                              Login to skbefair.com
                          </div>--}}
                        <div class="form-group{{ $errors->has('identity') ? ' has-error' : '' }}">
                            {{-- <p for="email" class="control-label"></p>--}}

                            <div class="">
                                <input id="identity" type="text" class="form-control" name="identity" value="{{ old('email') }}" placeholder="User name" required autofocus>

                                @if ($errors->has('identity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('identity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" style="margin-top: 20px">
                            {{-- <p for="password" class=" control-label">Password</p>--}}

                            <div class="">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" style="margin-top: 20px">
                            {{-- <p for="password" class=" control-label">Validation code</p>--}}
                            <div class="" style="position: relative">
                                @php
                                    $code=rand(10000,99999);
                                @endphp
                                <input type="hidden" class="form-control" name="v_code1" value="{{$code}}">
                                <input type="text" class="form-control" name="v_code" placeholder="Validation code" required>
                                <span style="position: absolute; top: 5px; right: 10px; font-size: 18px; font-weight: bold;">{{$code}}</span>
                                @if ($errors->has('v_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('v_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>
                        <div class="row" style="color: #b9bbbe">
                            ©️ RamaBet.COM
                            {{-- <div class="col-sm-12" style="text-align: center">
                                 For assistance please contact us at
                             </div>
                             <div class="col-sm-6">
                                 <i class="far fa-envelope"></i>test@gmail.com
                             </div>
                             <div class="col-sm-6">
                                 <i class="fas fa-mobile-alt"></i>+1 123123123
                             </div>--}}

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
