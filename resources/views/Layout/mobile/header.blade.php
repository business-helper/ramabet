<style>
    ::placeholder {
        color: white;
        opacity: 0.6;
    }
    .input_item	i {
        display: none;
        position: absolute;
        width: 1px;
        height: 35%;
        background-color: white;
        left: 9px;
        top: 24%;
        animation-name: blink;
        animation-duration: 800ms;
        animation-iteration-count: infinite;
        opacity: 1;
    }
    @keyframes blink {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    .cursor input:focus + i {
        display: none;
    }
    .promotions{
        content: url("{{asset('img/ball/promotions.png')}}");
        width: 25px;
        height: 25px;
    }

    .soccer{
        content: url("{{asset('img/ball/soccer.png')}}");
        width: 25px;
        height: 25px;
    }
    .tennis{
        content: url("{{asset('img/ball/tennis.png')}}");
        width: 25px;
        height: 25px;
    }
    .cricket{
        content: url("{{asset('img/ball/cricket.png')}}");
        width: 25px;
        height: 25px;
    }
    .handball{
        content: url("{{asset('img/ball/handball.png')}}");
        width: 25px;
        height: 25px;
    }
    .basketball{
        content: url("{{asset('img/ball/basketball.png')}}");
        width: 25px;
        height: 25px;
    }
    .volleyball{
        content: url("{{asset('img/ball/volleyball.png')}}");
        width: 25px;
        height: 25px;
    }
    .ice_hockey{
        content: url("{{asset('img/ball/ice_hockey.png')}}");
        width: 25px;
        height: 25px;
    }
    .rugby_union{
        content: url("{{asset('img/ball/rugby_union.png')}}");
        width: 25px;
        height: 25px;
    }
    .list-group-item {
        transition: transform .2s;
        margin: 0 auto;
    }
    .navbar-inverse .navbar-nav>li>a{
        color: white;
    }
    .navbar-inverse {
        border-color: white;
    }
    .navbar-inverse .navbar-toggle {
        border-color: white;
    }
    .navbar-inverse .navbar-toggle:focus, .navbar-inverse .navbar-toggle:hover {
        background-color: #b02f28;
    }
    .navbar-inverse .navbar-collapse, .navbar-inverse .navbar-form {
        border-color: #c54646;
    }
    .navbar{
        min-height: 70px;
        margin: 0;
        background-color: #F44336;
        color: white;
        position: fixed;
        width: 100%;
        z-index: 10;
    }
</style>
<div class="navbar navbar-inverse" style="top: 0">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {{--<a class="navbar-brand" href="#">WebSiteName</a>--}}
            <a class="navbar-brand" href="{{url('/mobile')}}"><img class="icon-size" src="{{asset('img/'.$general_setting['logo_image'])}}" style="max-width:90%;max-height: 35px"></a>
            <div id="move_text" class="flow-text"><span class="target" style="color: white;">Welcome to oddsexch.com</span></div>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar" style="padding-top: 20px;">
            <ul class="nav navbar-nav navbar-right">
                {{--<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>--}}
                <li>
                    <a href="#">
                        <div id="google_translate_element" style="height: 30px; overflow: hidden; "></div>
                        <script type="text/javascript">
                            function googleTranslateElementInit() {
                                new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
                            }
                        </script>
                        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <li class="">
                    <a href="{{route('home_mobile')}}" class="ui-link" style="display: flex">
                        <span style="font-size: 30px"><i class="fas fa-home"></i></span>
                        <span>Home</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{route('promotions_mobile')}}" class="ui-link" style="display: flex">
                        <span style="font-size: 30px"><img class="promotions"></span>
                        <span>Promotion</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('in_play_mobile')}}" class="ui-link" style="display: flex">
                        <span style="font-size: 30px"><i class="fas fa-clock" ></i></span>
                        <span>In-Play</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('sports_mobile')}}" class="ui-link" style="display: flex">
                        <span style="font-size: 30px"><i class="fas fa-trophy"></i></span>
                        <span>Sports</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('multiMarkets_mobile')}}" style="display: flex">
                        <span style="font-size: 30px"><i class="fas fa-thumbtack"></i></span>
                        <span>My Markets</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('profile_mobile')}}" class="ui-link" style="display: flex">
                        <span style="font-size: 25px"><i class="fas fa-user"></i></span>
                        <span>Account</span>
                    </a>
                </li>
                {{--<li class="active"><a href="#">Home</a></li>--}}
                {{-- <li class="dropdown">
                     <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                     <ul class="dropdown-menu">
                         <li><a href="#">Page 1-1</a></li>
                         <li><a href="#">Page 1-2</a></li>
                         <li><a href="#">Page 1-3</a></li>
                     </ul>
                 </li>
                 <li><a href="#">Page 2</a></li>
                 <li><a href="#">Page 3</a></li>--}}
            </ul>
            <ul class="nav navbar-nav">
            @guest
                <div style="margin-left: auto;text-align: right;    position: absolute; right: 0; bottom: 10px;">
                    <div class="" style="display: table-cell;vertical-align: middle">
                        <a href="{{route('mobile_login')}}" class="myButton" style="width: 100px;font-size: 12px;">Login</a>
                        @if (Route::has('register'))
                            {{--<a href="{{ route('register') }}" class="myButton" style=""><span><i class="fas fa-user"></i> </span>Register</a>--}}
                            <a href="{{ route('register') }}" class="myButton" style="font-size:12px;margin-top: 15px;width: 100px;">Register</a>
                        @endif
                    </div>
                </div>
            @else
                <li><a href="{{ route('user.logout') }}"><span class="glyphicon glyphicon-log-in"></span> Log out</a></li>
                <div class="input_item" style="display: flex;position: relative;width: 70%;margin-left: 12%;">
                    <input id="input-text" type="text" style="outline:none;padding-left:10px;color:white;width: 80%;height: 30px;margin-top: 10px;border:none;font-size: 16px;font-color:white;display: none;background:none;" placeholder="search Events..."/>
                    <i id="pointer"></i>
                </div>
            @endguest
            </ul>
        </div>
    </div>




</div>
<script>
    $(document).ready(function() {
        $('#search_btn').click(function () {
            $('#icon-div').css('display','none');
            $('#move_text').css('display','none');
            $('#back').css('display','block');
            $('#input-text').css('display','block');
            $('#pointer').css('display','block');
        });
    });
    $('#back').click(function () {
        $('#back').css('display','none');
        $('#icon-div').css('display','block');
        $('#move_text').css('display','block');
        $('#input-text').css('display','none');
        $('#pointer').css('display','none');
    });
    $('#input-text').click(function () {
        $('#pointer').css('display','none');
    });
</script>