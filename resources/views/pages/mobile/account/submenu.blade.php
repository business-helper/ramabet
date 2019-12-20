<style>
    body{
        padding-top: 50px;
        padding-bottom: 50px;
    }
</style>
<div class="dropdown" style="position: fixed;top: 68px;width: 100%!important;z-index: 2">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;background-color: blue;color: white">
        MY ACCOUNT
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
        <a href="{{route('profile_mobile')}}" class="list-group-item">My profile</a>
        @if($general_setting['balance_menu']=='yes')
            <a href="{{route('summary_mobile')}}" class="list-group-item">Balance Overview</a>
        @endif

        <a href="{{route('transferredLog_mobile')}}" class="list-group-item">Transferred Log</a>
        <a href="{{route('current_bets_mobile')}}" class="list-group-item">My Bet</a>
        <a href="{{route('bet_history_mobile')}}" class="list-group-item">Bets History</a>
        <a href="{{route('profit_loss_mobile')}}" class="list-group-item">Profit & Loss</a>
        <a href="{{ route('user.logout') }}" class="list-group-item">Logout</a>
    </div>
</div>
