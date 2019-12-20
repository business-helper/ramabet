<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<script src="{{ asset('js/app.js') }}" defer></script>

<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{$general_setting['website_name']}}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>


<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">


<!-- Styles -->
<style>
    .row-eq-height {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display:         flex;
    }

    body{
        background-image: url("{{asset('img/white-ppt-background-30.jpg')}}");
        height: 100%;
        font-size: 12px;
        min-width: 1060px;
    }
    .content{
        max-width: 1224px;
        margin-right: auto;
        margin-left: auto;
        height: calc(100% - 97px);
    }
    html{
        height: 100%;
    }
    .text-center{padding-bottom: 70px;padding-top: 100px;}
    /* Remove the navbar's default margin-bottom and rounded borders */


    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {min-height: 700px}

    /* Set gray background color and 100% height */
    .sidenav {padding: 0px;}
    .text-left{}

    /* Set black background color, white text and some padding */
    footer {background-color: #F44F3B;color: white;padding: 15px;}

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
        .sidenav {height: auto;padding: 15px;}
        .row.content {height:auto;}
    }

    .selectTemp{display: flex;width: 100%;height:100%;margin: auto;position: absolute}
    .selectTemp .left_item{background-color: #a7d8fd;}
    .selectTemp .right_item{background-color: #f9c9d4;}
    .selectTemp .deactive{background-color: #ddd;}
    .selectTemp div{margin: 0;text-align: center;cursor: pointer;width: 100%;height: 100%;border-right: 1px solid #ddd;display: table}
    .selectTemp p{margin: 0;font-size: 12px;font-weight: 600}
    .selectTemp span{display: table-cell;vertical-align: middle;}
    .selectTemp span .size{
        display: unset;
    }
    .event_title{padding-left: 10px;}
    .event_title p{font-weight:100;color: #93A2AA;margin: 0;}
    .event_title .title_span{color: #2789CE;}
    .progress_title{
        font-weight:100;margin-left: 10px;align-self: center;
        margin-left: auto;text-align: right;
    }
    .inplay{color: #019722;    min-width: 53px;
    }
    .right_title{text-align: left;background-color: rebeccapurple;color: white;}
    #pathbackUI{display: flex;background-color: #212121;width: 100%;padding-left: 5px;}
    .path_item{color: #fe950e;display: flex;}
    .path_item svg{margin-top: 5px;}
    .list-group{
        animation: 1s ease-out 0s 1 slideInFromLeft;
    }
    @keyframes slideInFromLeft {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(0);
        }
    }
    .disappear{
        animation: 1s ease-out 0s 1 slideInToLeft;
    }
    @keyframes slideInToLeft {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-100%);
        }
    }
    .list-group-item{    position: relative;height: 60px;cursor: pointer;transition: all .1s ease-out;padding-top: 20px}
    .list-group-item1{    position: relative;height: 30px;cursor: pointer;transition: all .1s ease-out;padding-top: 20px}
    .star{
        content: url("{{asset('img/ball/star.png')}}");
        width: 25px;
        height: 25px;
    }
    .deactive_market{
        content: url("{{asset('img/ball/star1.png')}}");
        width: 15px;
        height: 15px;
    }
    .active_market{
        content: url("{{asset('img/ball/star.png')}}");
        width: 15px;
        height: 15px;
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
    .list-group-item {
        transition: transform .2s;
        margin: 0 auto;
    }

    .list-group-item:hover {
        -ms-transform: scale(1.1); /* IE 9 */
        -webkit-transform: scale(1.1); /* Safari 3-8 */
        transform: scale(1.1);
    }
    /*.list-group a::before {content: "";position: absolute;top:30%;right: 4px;width: 9px;height: 9px;background-color: red;border-radius: 50%;}*/
    /*table*/
    .account_table table thead tr{
        background-color: #DCDCDC;
    }
    .account_table table tbody{
        background-color: white;
    }
    .table_div table tbody{
        background-color: white;
    }
    .table_div table>thead>tr>th{
        padding: 4px 8px!important;
        line-height: 1.42857143!important;;
        vertical-align: middle!important;;
        text-align: center;font-weight:100!important;;
    }
    .table_div .title{padding: 10px;background-color: #284257;color: white;}
    .table_div{margin-top: 20px;}
    .table_div .table>tbody>tr>td {padding: 0;}
    .table>tbody>tr>td{
        position: relative!important;
    }
    .set_market{width: 20px!important;height: 20px!important;justify-content: center;
        align-self: center;}

    .table_div table tbody tr td{position: relative;}
/*    .table_div table tbody tr td .active_make:before{position: absolute;content: '';background-color: #81d973;border-radius: 4px;width: 8px;height: 8px;left: 10px;top: 35%;}*/
    .table_div table tbody tr td .deactive_make:before{position: absolute;content: '';background-color: #898989;border-radius: 4px;width: 8px;height: 8px;left: 10px;top: 35%;}
    .active1{/*background-color: #3c6586 !important*/;}
    .active2{/*background-color: #a4707b !important;*/}
    .hide{display: none;}
    /*today table*/
    .path_span{position: relative;margin-right: 20px;}
    .path_span:after{content: '';position: absolute;right: -15px;top: 20%;width: 0;height: 0;border-top: 5px solid transparent;border-left: 10px solid black;border-bottom: 5px solid transparent;}
    .table_div .title{padding: 10px;background-color: #284257;color: white;}
    /*bet slip*/
    .betslip_btn{
        background-color: #ff3b29;
        color: #fff;
        border-bottom-color: #ff3b29;
        border-right-color: #ff3b29;
        flex-grow: 1;
        max-width: 70px;
        width: 77px;
        margin: 1px;
        height: 28px;
        font-size: 11px;
    }
    .betslip_close{
        padding: 2px 2px;
        font-size: 11px;
        width: 20px;
        height: 20px;
    }
    .clear{
        align-self: center;width: 70px;text-align: right;padding-right: 3px;
    }
    #betSlipBoard .itemleft{width:60%;text-align: left;}
    #betSlipBoard .item20{width: 20%;text-align: center}
    #betSlipBoard .itemright{width: 20%;text-align: right}
    .backSlipHeader{/*background-color: #b9bbbe;*/}
    .bet_input{background-color: #a1cbef;}

    /*button*/
    .third { /* border-color: #1c4d6d; */color: #fff;box-shadow: 0 0 40px 40px #616562 inset, 0 0 0 0 #3ce97b;transition: all 150ms ease-in-out;}
    .third:hover {box-shadow: 0 0 10px 0 #3ce97b inset, 0 0 10px 4px #3ce97b;}
    .second { /* border-color: #1c4d6d; */color: #fff;box-shadow: 0 0 40px 40px #616562 inset, 0 0 0 0 #3ce97b;transition: all 150ms ease-in-out;}
    .second:hover {box-shadow: 0 0 10px 0 #e94a45 inset, 0 0 10px 4px #e94a45;}
    sidenav .btn {box-sizing: border-box;-webkit-appearance: none;-moz-appearance: none;appearance: none;background-color: transparent; /* border-radius: 0.6em; */color: white;cursor: pointer; /* display: flex; */align-self: center; /* font-size: 1rem; */ /* font-weight: 400; */line-height: 1; /* margin: 20px; */ /* padding: 1.2em 2.8em; */text-decoration: none;text-align: center;text-transform: uppercase;font-family: 'Montserrat', sans-serif; /* font-weight: 700; */}
    sidenav .btn:hover, .btn:focus {color: black;outline: 0;}
    .oddtable>thead>tr>th{padding-top: 0!important;padding-bottom: 0!important;}
    .sidenav_fixed_pos{padding: 10px;position: fixed;right: 0;top: 100px;overflow: auto;padding-bottom: 100px!important;}
</style>

<style>
    .navbar {margin-bottom: 0;border-radius: 0;}
    .navbar ul{margin-top: 10px;}
    .child_menu{display: flex;background: #ccc;justify-content: space-between;box-shadow:inset 0 1px 3px 0 rgba(255,255,255,0.5);}
    .child_menu .right_item{display: flex;height: 100%;}
    .child_menu .left_item{display: flex;left: 0;height: 100%;}
    .child_menu .left_item a{color: black;}
    .child_menu div div{border-right: 1px solid rgba(33, 6, 83, 0.93);height: 100%;padding-right: 10px;padding-left: 10px;line-height: 30px;}
    .input_item{color: white;padding-top: 0px;display: flex;line-height: 35px;}
    .input_item input{width: 100px;height: 25px;margin-right: 20px;}
    /*preloader*/
    .lds-hourglass {display: inline-block;position: relative;width: 64px;height: 64px;}
    .lds-hourglass:after {content: " ";display: inline-block;border-radius: 50%;width: 0;height: 0;margin: 6px;box-sizing: border-box;border: 26px solid #fff;border-color: #fff transparent #fff transparent;animation: lds-hourglass 1.2s infinite;}
    @keyframes lds-hourglass {
        0% {transform: rotate(0);animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);} 50% {transform: rotate(900deg);animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);} 100% {transform: rotate(1800deg);} }
    .suggestion-wrap {position: absolute;z-index: 4;top: 43px;width: 100%;background: #fff;border-top: 1px solid #E0E6E6;border-radius: 0 0 4px 4px;box-shadow: 0 4px 4px rgba(0,0,0,0.5);box-sizing: border-box;}
    .suggestion-wrap ul {max-height: 210px;overflow: hidden;overflow-y: auto;padding-left: 0;}
    .suggestion-wrap li {height: 32px;line-height: 32px;list-style: none;text-indent: 6px;}
    .suggestion-wrap .no-matching, .suggestion-wrap p, .suggestion-wrap a {margin: 0;color: #666666;cursor: default;}
    .suggestion-wrap p, .suggestion-wrap a {color: #1E1E1E;cursor: pointer;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}
    .navbar-nav>li>a {
        color: white;
    }

    .navbar .nav .open>a, .nav .open>a:focus, .nav .open>a:hover,.nav>li>a:focus, .nav>li>a:hover {
        background-color: unset!important;
    }
    #bet_slipe_div .nav .open>a,#bet_slipe_div .nav .open>a:hover,#bet_slipe_div .nav>li>a:focus,#bet_slipe_div .nav>li>a:hover {
        background-color: #E7F3FD!important;
    }
    #bet_slipe_div .navbar-nav>li>a,#bet_slipe_div .nav>li>a:focus {
        background-color: white!important;
    }
    .target{
        animation: flowing 8s linear infinite;
        position: relative;
    }
    .flow-text{
        overflow: hidden;
        width: 80%;
        margin: auto;
    }
    .flow-text:hover .target{
        animation-play-state: paused;
    }

    @keyframes flowing {
        from {left: 100%;}
        to {left: -100px;}
    }

    @media (max-width: 768px){
        .container>.navbar-collapse, .container>.navbar-header, .container>.navbar-collapse, .container>.navbar-header {
            margin-right: 0;
            margin-left: 0;
            background: #F44F3B;
            overflow-y: hidden;
        }

        .container{
            padding: 0;
        }
        .navbar-nav{
            margin: 0;
        }
        .navbar-right{
            display: flex;
        }
    }
    .icon-bar{
        background-color: white;
    }
    .navbar-nav>li>.dropdown-menu:before{
        content: "";
        height: 0;
        position: absolute;
        bottom: 100%;
        right: 50%;
        margin-right: -5px;
        border-width: 0 6px 6px;
        border-style: solid;
        border-color: #fff transparent;
    }
    .navbar-right .dropdown-menu {
        left: -20px!important;
        border-radius: 7px;
    }
    .dropdown-item{
        display: block;
        padding: 10px;
        text-decoration: none;
        border-bottom: 1px solid #DDD;
        box-shadow: inset 0 1px 0 #fff;
        cursor: pointer;
        color: #000;
    }
    .dropdown-item:hover{
        background-color: #eee;
        text-decoration: none
    }


    .form-label {
        position: absolute;
        left: 30px;
        top: 0px;
        color: #999;
        /*background-color: rgba(0,0,0,0);*/
        z-index: 10;
        transition: transform 150ms ease-out, font-size 150ms ease-out;
        font-weight: 100;
    }
    .focused .form-label {
        transform: translateY(-80%);
        font-size: .8em;
        color: white;
    }
    /*
    */
    .arrow{
        background: #fff;
        padding: 2px 4px;
        margin: 2px 6px 0 0;
        float: right;
        color: #ff3b29;
        font-size: 10px;
        height: 16px;
    }
    .collapsed i:after{
        content: "\f107"!important;
    }
    .toggleable-list-title i:after{
        content: "\f106";
    }
    .onoffswitch {
        position: relative; width: 60px;
        -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
    }
    .onoffswitch-checkbox {
        display: none;
    }
    .onoffswitch-label {
        display: block; overflow: hidden; cursor: pointer;
        border: 2px solid #999999; border-radius: 20px;
    }
    .onoffswitch-inner {
        display: block; width: 200%; margin-left: -100%;
        transition: margin 0.3s ease-in 0s;
    }
    .onoffswitch-inner:before, .onoffswitch-inner:after {
        display: block; float: left; width: 50%; height: 22px; padding: 0; line-height: 22px;
        font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
        box-sizing: border-box;
    }
    .onoffswitch-inner:before {
        content: "ON";
        padding-left: 10px;
        background-color: #ff5040; color: #FFFFFF;
        font-size: 12px;
    }
    .onoffswitch-inner:after {
        content: "OFF";
        padding-right: 5px;
        background-color: #EEEEEE; color: #999999;
        text-align: right;
        font-size: 12px;
    }
    .onoffswitch-switch {
        display: block; width: 18px;
        background: #FFFFFF;
        position: absolute; top: 0; bottom: 0;
        height: 25px;
        right: 40px;
        border: 2px solid #999999; border-radius: 20px;
        transition: all 0.3s ease-in 0s;
    }
    .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
        margin-left: 0;
    }
    .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
        right: 0px;
    }
    #onebet .btn-default.active,.focus{
        color: #fff;
        background: #ff5040;
        box-shadow: inset 1px 1px 1px 1px rgba(0,0,0,.2);
        text-align: center;

    }
    #onebet .btn-default{
        color: #000;
        background: rgba(29,127,30,.1);
        border: 2px solid #ff3b29;
        width: 54px;
        line-height: 22px;
        min-height: 22px;
        height: 22px;
        padding: 0;
    }
    .disappear1{
        transform: translateX(-80%) scaleX(0);
    }
    .appear1{
        transform: translateX(0) scaleX(1);
    }
    #oneclick_bet_div{
        transition: transform .3s
    }
    h4,h1{

        padding: 0 0 10px;
        color: #084e83;
        margin-bottom: 10px;
        border-bottom: 1px solid rgba(8,78,131,.4);
    }
    h1{
        font-size: 24px;
        line-height: 36px;
    }
    h4{
        font-size: 14px;
        line-height: 19px;
    }
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
        border-radius:unset;
        border: 1px solid #fff;
    }
    .nav-tabs>li>a{
        background-color: #d0e9fc;
        color: #084e83;
        padding: 8px 20px;
    }

    ::-webkit-scrollbar {
        width: 5px;
        height: 5px;
        border-radius: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px #ffecec;
        border-radius: 10px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #5e6a71;
        border-radius: 10px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #959095;
    }
    /*open bets*/
    .open_bets_header{
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        padding: 5px 4px 0;
    }
    .open_bets_header .bet_match_name{
        text-align: left;
        width: 29%;
        flex: none;
    }
    .open_bets_header .bet_odd{
        width: 17%;
        flex: none;
    }
    .open_bets_header .bet_stake{
        flex: 1;
        text-align: center;
    }
    .open_bets_header .bet_profit{
        flex: 1;
        text-align: center;
    }
    .open_bets_body{
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        margin: 2px 0;
        padding: 5px 4px 0;
    }
    .open_bets_body .bet_match_name{
        flex: none;
        width: 29%;
        font-weight: 700;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .open_bets_body .bet_odd{
        flex: none;
        width: 17%;
    }
    .open_bets_body .bet_stake{
        flex: 1;
        text-align: center;
    }
    .open_bets_body .bet_profit{
        flex: 1;
        text-align: center;
    }
</style>
