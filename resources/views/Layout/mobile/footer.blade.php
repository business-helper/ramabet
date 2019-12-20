
<div style="width: 100%;display: flex;padding-top: 6px;">
    <div id="home" class="select">
        <a href="{{route('home_mobile')}}" class="ui-link">
            <span style="font-size: 30px"><i class="fas fa-home"></i></span>
            <p>Home</p>
        </a>
    </div>
    <div id="inPlay">
        <a href="{{route('in_play_mobile')}}" class="ui-link">
            <span style="font-size: 30px"><i class="fas fa-clock" ></i></span>
            <p>In-Play</p>
        </a>
    </div>
    <div id="sports" style="margin-top: 0.8px;">
        <a href="{{route('sports_mobile')}}" class="ui-link">
            <span style="font-size: 30px"><i class="fas fa-trophy"></i></span>
            <p>Sports</p>
        </a>
    </div>
    <div id="multiMarket">
        <a href="{{route('multiMarkets_mobile')}}">
            <span style="font-size: 30px"><i class="fas fa-thumbtack"></i></span>
            <p>My Markets</p>
        </a>
    </div>
    <div id="account" style="margin-top: 3px;">
        <a href="{{route('profile_mobile')}}" class="ui-link">
            <span style="font-size: 25px"><i class="fas fa-user"></i></span>
            <p>Account</p>
        </a>
    </div>
</div>
