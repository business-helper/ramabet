
<nav class="navbar" style="background-color: #F44F3B;width: 100%;z-index: 100;min-height: 96px!important;">
    <div class="content" style="height: 60px;margin-top: 10px">
        <div class="navbar-header" style="height: 100%">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" style="padding: 0;height: 100%;"><div style="background-image: url('{{asset('img/ikon-bets.png')}}');background-size: 70%;
                        background-repeat: no-repeat;
                        background-position: 0px -5px;
                        height: 100%;
                        width: 200px;"></div></a>
            <div style="padding-top: 20px;display: table; height: 100%;">
                <span id="gmt_time" style="display: table-cell; vertical-align: middle; color: white"></span>
            </div>

        </div>
        <div class="collapse navbar-collapse" id="myNavbar" style="margin-top: 15px;overflow: visible">
            <ul class="nav navbar-nav navbar-right">
                @guest
                    <li class="nav-item">
                        <form method="POST" action="{{ route('login') }} " style="display: flex">
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
                    <div class="input_item" style="display: flex">
                        <label class="form-label" for="search">Search Events</label>
                        <input style="padding-left: 25px;width: 100%;height:35px" type="text" class="form-control" id="search" placeholder="">
                        <span style="color: black;position: absolute;left: 5px"><i class="fa fa-search"></i></span>
                    </div>
                    <div id="searchResult" class="suggestion-wrap" style="display: none">
                        <ul id="searchList">
                            <li id="noMatching" ><p class="no-matching">No events found matching ...</p></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a style="padding: 0;font-size: 11px">Logged in as {{ Auth::user()->name }}</a>
                    <a style="padding: 0;font-size: 11px">Last logged in:{{ Auth::user()->last_login }}</a>
                </li>
                    {{--<li>
                        <a href="#">
                            <span>{{ Auth::user()->wallet }}:USD</span>
                        </a>

                    </li>--}}
                    {{--<li id="notification1" class="nav-item dropdown">
                        <a id="noti_count" class="nav-link dropdown-toggle" href="#notification1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" v-pre>
                            <i class="fas fa-bell"></i><span class="notification_count"></span> <span class="caret"></span>
                        </a>
                        <div  class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="position:initial;padding-left:10px;width: 300px;max-height: 300px;overflow-y: auto;">
                            <ul id="notification" class="notification-menu">

                            </ul>
                        </div>
                    </li>--}}
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
                            {{--<a class="dropdown-item" href="{{route('bet_history')}}">Bet History</a>--}}


                        </div>
                    </li>
                    <li id="dropdown_menu" class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('user.logout') }}">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                @endguest

            </ul>
        </div>
    </div>
    <div class="content flow-text"><span class="target" style="color: white">Welcome to odds24ex.com</span></div>

</nav>
{{--<div class="child_menu" >
    <div class="left_item">
        <div class=""><a href="{{url('/')}}">Home</a></div>
        <div><a href="{{url('/in-play')}}"><span>In_Play</span></a></div>
        <div><a href="{{url('/multiMarkets')}}">Multi_Markets</a></div>
        <div><a href="{{url('/cricket')}}">Cricket</a></div>
        <div><a href="{{url('/soccer')}}">Soccer</a></div>
        <div><a href="{{url('/tennis')}}">Tennis</a></div>
        @guest
        @else
            --}}{{--<div><a href="{{url('/election')}}">Election</a></div>--}}{{--
        @endguest

    </div>
    <div class="right_item;" style="cursor: pointer;display: flex;">
        <div>Time Zone : <span id="gmt_time"></span></div>
        <div>One Click Bet</div>
        --}}{{--<div class="refresh">Refresh</div>--}}{{--
    </div>


</div>--}}
{{--<div id="preloader" style="position: fixed;z-index: 200;width: 100%;height: 100%;background-color: rgba(0, 0, 0, 0.48);top: 0%;display: table;text-align: center;">
    <div style="display: table-cell;vertical-align: middle" class="lds-hourglass" ></div>
</div>--}}


