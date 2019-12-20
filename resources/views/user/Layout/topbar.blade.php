
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="javascript:void(0)" style="    margin-left: 35px!important;">
                <div class="image" style="margin-top: -25px;">
                    <img src="{{asset('img/'.$general_setting['logo_image'])}}?v=1.01"
                         style="" alt="User"/>
                </div>
            </a>
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
               data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>

        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <balance style="text-align: right" class="navbar-right"></balance>
        </div>

    </div>
    <div class="flow-text"><span class="target" style="color: white;">{{$general_setting['banners']}}</span></div>
    <div class="mobile_hide1 left" style="background-color: #59e721;
    width: 100%;padding-top: 6px;
    height: 30px;
    padding-left: 10px;">
        <ul class="navbar-nav" style="padding: 0">
            <li>
                <router-link to="/inplay" class="nav-link waves-effect waves-block" href="" role="button"
                >
                    In Play
                </router-link>
            </li>
            <li>
                <router-link to="/my_market" class="nav-link waves-effect waves-block" href="" role="button"
                >
                    My Markets
                </router-link>
            </li>
            <li>
                <router-link to="/multi_market" class="nav-link waves-effect waves-block" href="" role="button"
                >
                    Multi Markets
                </router-link>
            </li>
            <li>
                <router-link to="/fancyMarkets" class="nav-link waves-effect waves-block" href="" role="button"
                >
                    Fancy Markets
                </router-link>
            </li>
            <li>
                <router-link to="/sport/4" class="nav-link waves-effect waves-block" href="" role="button"
                >
                    Cricket
                </router-link>
            </li>
            <li>
                <router-link to="/sport/1" class="nav-link waves-effect waves-block" href="" role="button"
                >
                    Soccer
                </router-link>
            </li>
            <li>
                <router-link to="/sport/2" class="nav-link waves-effect waves-block" href="" role="button"
                >
                    Tennis
                </router-link>
            </li>
            <li id="dropdown_menu2" class="nav-item dropdown ">
                <a id="navbarDropdown" class="nav-link dropdown-toggle waves-effect waves-block" href="#dropdown_menu2" role="button"
                   data-toggle="dropdown">
                    Report
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"
                     >
                    <router-link class="dropdown-item  waves-effect waves-block" :to="'/report/acc_status'">
                        Account Status
                    </router-link>
                    <router-link class="dropdown-item waves-effect waves-block" :to="'/report/acc_statement'">
                        Account Statement
                    </router-link>
                    <router-link class="dropdown-item waves-effect waves-block" :to="'/report/profitAndLoss'">
                        Profit & Loss Report
                    </router-link>
                    <router-link class="dropdown-item waves-effect waves-block" :to="'/report/commission'">
                        Commission Report
                    </router-link>
                    <router-link class="dropdown-item waves-effect waves-block" :to="'/report/wallet'">
                        Wallet Report
                    </router-link>
                    <router-link class="dropdown-item waves-effect waves-block" :to="'/report/settlement'">
                        Settlement Report
                    </router-link>
                    <router-link class="dropdown-item waves-effect waves-block" :to="'/report/bethistory'">
                        Bet log
                    </router-link>
                    <router-link class="dropdown-item waves-effect waves-block" :to="'/report/result'">
                        result
                    </router-link>

                </div>
            </li>
        </ul>
    </div>

</nav>
