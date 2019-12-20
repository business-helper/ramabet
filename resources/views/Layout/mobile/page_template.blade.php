<!DOCTYPE html>
<html>

<head>
    @include('Layout.mobile.head')
<style>
    .footer {width: 100%;background-color: #F44336;border-color: #F44336;color: white;position: fixed;bottom: 0%;}
    .footer div div{text-align: center;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;width: 20%;}
    .footer div div a{color: white;}
    .footer #sports:before{content: '';position: absolute;top: -4.26667vw;width: 20%;height: 8.53333vw;background-color: #F44336;pointer-events: none;z-index: -1;left: 40%;border-radius: 50% 50% 0px 0px;}
    .footer_active{background: #F44336;background: -moz-linear-gradient(top, #F44336 0%, #89ADA9 100%);background: -webkit-linear-gradient(top, #F44336 0%, #89ADA9 100%);background: linear-gradient(to bottom, #F44336 0%, #89ADA9 100%);}
    .footer #sports:before {
        content: none;
    }
    .footer{
        height:55px;
    }
    .svg-inline--fa {
        height: 25px;!important;
        vertical-align: .3em;!important;
    }
    .footer p{
        margin:0!important;
        margin-top:-20px!important;
    }
</style>
</head>

<body class="theme-red">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="START TYPING...">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->
<!-- Top Bar -->
@include('Layout.mobile.topbar')
@yield('head')
<!-- #Top Bar -->
@include('Layout.mobile.sidebar')

<section class="content">
    <div class="container-fluid" style="padding: 0;">
        @yield('content')
    </div>
</section>
<div class="footer">
    @include("Layout.mobile.footer")
</div>
@include('Layout.mobile.script_file')
@yield('scrip_temp')
</body>

</html>
