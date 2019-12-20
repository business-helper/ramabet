<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>{{$general_setting['website_name']}}</title>
<!-- Favicon-->
<link rel="icon" href="favicon.ico" type="image/x-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

<!-- Bootstrap Core Css -->
<link href="{{asset('user/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

<!-- Waves Effect Css -->
<link href="{{asset('user/plugins/node-waves/waves.css')}}" rel="stylesheet" />

<!-- Animation Css -->
<link href="{{asset('user/plugins/animate-css/animate.css')}}" rel="stylesheet" />

<!-- Morris Chart Css-->
<link href="{{asset('user/plugins/morrisjs/morris.css')}}" rel="stylesheet" />

<!-- Custom Css -->
<link href="{{asset('user/css/style.css')}}" rel="stylesheet">

<!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
<link href="{{asset('user/css/themes/all-themes.css')}}" rel="stylesheet" />


<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<style>

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
        .sidenav {height: auto;padding: 15px;}
        .row.content {height:auto;}
    }
    .width_thead{width: 90px;}
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

    /*.list-group a::before {content: "";position: absolute;top:30%;right: 4px;width: 9px;height: 9px;background-color: red;border-radius: 50%;}*/
    /*table*/
    sidenav .btn {box-sizing: border-box;-webkit-appearance: none;-moz-appearance: none;appearance: none;background-color: transparent; /* border-radius: 0.6em; */color: white;cursor: pointer; /* display: flex; */align-self: center; /* font-size: 1rem; */ /* font-weight: 400; */line-height: 1; /* margin: 20px; */ /* padding: 1.2em 2.8em; */text-decoration: none;text-align: center;text-transform: uppercase;font-family: 'Montserrat', sans-serif; /* font-weight: 700; */}
    sidenav .btn:hover, .btn:focus {color: black;outline: 0;}
    .oddtable>thead>tr>th{padding-top: 0!important;padding-bottom: 0!important;}
    .sidenav_fixed_pos{padding: 10px;position: fixed;right: 0;top: 100px;overflow: auto;padding-bottom: 100px!important;}
</style>

