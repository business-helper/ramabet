<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rredexchange</title>
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
            background-color: #222;
            display: table-cell;vertical-align:middle;
        }
        @media screen and (max-width: 767px) {

        }
        form{
            color: white;
            background-color: #373737;
            border-radius: 20px;
            padding: 10px;
            text-align: center;
            margin: 30px;
        }
        form .form-control{
            border-radius: 30px;
            background-color: #3d3c3c;
            color: #fffafa;
            border: 0;
        }


    </style>
</head>
<body>
<div class="container-fluid" style="padding-left: 10%;padding-right: 10%;">
    <div class="" style="min-width:300px;width: 60%;margin-bottom: 20px; margin: auto;" >
        <a class="" href="https://odds24ex.com"><img height="35px" src="{{asset('/img/logo-skyexchange.png')}}" style="width: 100%;height: auto"></a>
    </div>
    <div class="row" style="border-radius: 50px;margin-top: 30px">
        <form method="POST" action="{{ route('register') }} ">
            {{csrf_field()}}
            <div class="form-group" style="text-align: center;font-size: 20px;">
                Register to odds24ex.com
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row" style="">
                <div class="col-sm-12">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-sm-12 offset-sm-4" style="text-align: center">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
            <div class="row" style="color: #b9bbbe">
                <div class="col-sm-12" style="text-align: center">
                    For assistance please contact us at
                </div>
                <div class="col-sm-6">
                    <i class="far fa-envelope"></i>test@gmail.com
                </div>
                <div class="col-sm-6">
                    <i class="fas fa-mobile-alt"></i>+1 123123123
                </div>

            </div>
        </form>
    </div>

</div>

</body>
</html>
