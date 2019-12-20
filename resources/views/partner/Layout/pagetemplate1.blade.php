<!DOCTYPE html>
<html>

<head>
    @include('partner.Layout.head')
    @yield('head')
</head>
<body class="theme-indigo ls-closed">
<section id="app">
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
{{--    <div class="overlay"></div>--}}
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
@include('partner.Layout.topbar')

<!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar" style="top: 64px">
            <leftsidebar is_super="{{Auth::user('partner')->is_super}}"></leftsidebar>



        </aside>
        <!-- #END# Left Sidebar -->

    </section>

    <section class="content">
        <div class="container-fluid" style="padding-bottom: 200px">
            {{--<div style="text-align: right"><a href="javascript:history.back()" class=" btn btn-success">back</a></div>--}}
            <router-view :key="$route.fullPath"></router-view>
        </div>
    </section>
    {{--@include('user.Layout.footer')--}}
</section>
@include('partner.Layout.script')
@yield('script')

</body>
</html>
