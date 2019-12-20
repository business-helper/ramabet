{{--<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">--}}
<script src="{{asset('js/jquery.min.js')}}"></script>
{{--<script src="{{asset('js/bootstrap.min.js')}}"></script>--}}


<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
<style>
    .input_item{
        margin-top: 20px;
    }
</style>
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="{{url('/')}}">
                <div class="image" style="height: 200%;margin-top: -25px;">
                    <img src="{{asset('img/'.$general_setting['logo_image'])}}" style="height: 60px;width: auto" alt="User" />
                </div>
            </a>

        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                <li style="margin-top: 20px;margin-right: 20px;"><div id="google_translate_element" style="    height: 30px; overflow: hidden;"></div></li>
                <script type="text/javascript">
                    function googleTranslateElementInit() {
                        new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                    }
                </script>

                <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                <li style="margin-top: 30px;margin-right: 20px;" ><span class="notranslate" id="gmt_time" style="display: table-cell; vertical-align: middle; color: white"></span></li>

                @guest
                    <li class="nav-item">
                        <form method="POST" action="{{ route('login') }} " style="display: flex;height: 5px;">
                            {{ csrf_field() }}
                            <div class="input_item">
                                <span for="usr">Name:</span>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input_item">
                                <span for="pwd">Password:</span>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="input_item" style="background-color: rgba(0,0,0,0);color: white;border: 0">
                                        Login
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    {{--<button type="submit" class="input_item" style="background-color: rgba(0,0,0,0);color: white;border: 0">
                                        Login
                                    </button>--}}
                                    <a class="nav-link input_item" style="background-color: rgba(0,0,0,0);color: white;border: 0" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </div>

                            </div>
                        </form>

                    </li>

                @else
                <li>
                    <a style="margin-top:15px;padding: 0;font-size: 11px">Logged in as <span style="font-weight: bold;font-size: 14px;">{{ Auth::user()->name }}</span></a>
                    <a style="margin-top:0;padding: 0;font-size: 11px">Last logged in:<span style="font-weight: bold;font-size: 12px;">{{ Auth::user()->last_login }}</span></a>
                </li>
                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                <!-- #END# Call Search -->
                <!-- Notifications -->
                {{--<li class="dropdown">--}}
                    {{--<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">--}}
                        {{--<i class="material-icons">notifications</i>--}}
                        {{--<span class="label-count">7</span>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--<li class="header">NOTIFICATIONS</li>--}}
                        {{--<li class="body">--}}
                            {{--<ul class="menu">--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<div class="icon-circle bg-light-green">--}}
                                            {{--<i class="material-icons">person_add</i>--}}
                                        {{--</div>--}}
                                        {{--<div class="menu-info">--}}
                                            {{--<h4>12 new members joined</h4>--}}
                                            {{--<p>--}}
                                                {{--<i class="material-icons">access_time</i> 14 mins ago--}}
                                            {{--</p>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<div class="icon-circle bg-cyan">--}}
                                            {{--<i class="material-icons">add_shopping_cart</i>--}}
                                        {{--</div>--}}
                                        {{--<div class="menu-info">--}}
                                            {{--<h4>4 sales made</h4>--}}
                                            {{--<p>--}}
                                                {{--<i class="material-icons">access_time</i> 22 mins ago--}}
                                            {{--</p>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<div class="icon-circle bg-red">--}}
                                            {{--<i class="material-icons">delete_forever</i>--}}
                                        {{--</div>--}}
                                        {{--<div class="menu-info">--}}
                                            {{--<h4><b>Nancy Doe</b> deleted account</h4>--}}
                                            {{--<p>--}}
                                                {{--<i class="material-icons">access_time</i> 3 hours ago--}}
                                            {{--</p>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<div class="icon-circle bg-orange">--}}
                                            {{--<i class="material-icons">mode_edit</i>--}}
                                        {{--</div>--}}
                                        {{--<div class="menu-info">--}}
                                            {{--<h4><b>Nancy</b> changed name</h4>--}}
                                            {{--<p>--}}
                                                {{--<i class="material-icons">access_time</i> 2 hours ago--}}
                                            {{--</p>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<div class="icon-circle bg-blue-grey">--}}
                                            {{--<i class="material-icons">comment</i>--}}
                                        {{--</div>--}}
                                        {{--<div class="menu-info">--}}
                                            {{--<h4><b>John</b> commented your post</h4>--}}
                                            {{--<p>--}}
                                                {{--<i class="material-icons">access_time</i> 4 hours ago--}}
                                            {{--</p>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<div class="icon-circle bg-light-green">--}}
                                            {{--<i class="material-icons">cached</i>--}}
                                        {{--</div>--}}
                                        {{--<div class="menu-info">--}}
                                            {{--<h4><b>John</b> updated status</h4>--}}
                                            {{--<p>--}}
                                                {{--<i class="material-icons">access_time</i> 3 hours ago--}}
                                            {{--</p>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<div class="icon-circle bg-purple">--}}
                                            {{--<i class="material-icons">settings</i>--}}
                                        {{--</div>--}}
                                        {{--<div class="menu-info">--}}
                                            {{--<h4>Settings updated</h4>--}}
                                            {{--<p>--}}
                                                {{--<i class="material-icons">access_time</i> Yesterday--}}
                                            {{--</p>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li class="footer">--}}
                            {{--<a href="javascript:void(0);">View All Notifications</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                <!-- #END# Notifications -->
                <!-- Tasks -->
                {{--<li class="dropdown">--}}
                    {{--<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">--}}
                        {{--<i class="far fa-user-circle" style="font-size: 22px;"></i>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--<li class="header">TASKS</li>--}}
                        {{--<li class="body">--}}
                            {{--<ul class="menu tasks">--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<h4>--}}
                                            {{--Footer display issue--}}
                                            {{--<small>32%</small>--}}
                                        {{--</h4>--}}
                                        {{--<div class="progress">--}}
                                            {{--<div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<h4>--}}
                                            {{--Make new buttons--}}
                                            {{--<small>45%</small>--}}
                                        {{--</h4>--}}
                                        {{--<div class="progress">--}}
                                            {{--<div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<h4>--}}
                                            {{--Create new dashboard--}}
                                            {{--<small>54%</small>--}}
                                        {{--</h4>--}}
                                        {{--<div class="progress">--}}
                                            {{--<div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<h4>--}}
                                            {{--Solve transition issue--}}
                                            {{--<small>65%</small>--}}
                                        {{--</h4>--}}
                                        {{--<div class="progress">--}}
                                            {{--<div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0);">--}}
                                        {{--<h4>--}}
                                            {{--Answer GitHub questions--}}
                                            {{--<small>92%</small>--}}
                                        {{--</h4>--}}
                                        {{--<div class="progress">--}}
                                            {{--<div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li class="footer">--}}
                            {{--<a href="javascript:void(0);">View All Tasks</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            <li id="dropdown_menu" class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#dropdown_menu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" v-pre>
            <i class="fas fa-cog"></i> Account
            </a>
            <div  class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="">
            <a class="dropdown-item" href="{{route('current_bets')}}">My Bets</a>
            <a class="dropdown-item" href="{{route('profit_loss')}}">Betting Profit and Loss</a>
            @if($general_setting['balance_menu']=='yes')
            <a class="dropdown-item" href="{{route('summary')}}">Balance Overview</a>
            @endif
            <a class="dropdown-item" href="{{route('transferredLog')}}">Transfer Statement</a>
            <a class="dropdown-item" href="{{route('myprofile')}}">Change password</a>
            <a class="dropdown-item" href="{{route('bet_history')}}">Bet History</a>


            </div>
            </li>
            <li id="dropdown_menu" class="nav-item dropdown">
            <a class="nav-link" href="{{ route('user.logout') }}">
            <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            </li>

                <!-- #END# Tasks -->
            <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i><span id="bet_noti" class="label-count" style="margin-top:-6px;">0</span></a></li>
            @endguest
            </ul>
        </div>
        <div class="content flow-text"><span class="target" style="color: white;">{{$general_setting['banners']}}</span></div>
    </div>
</nav>
