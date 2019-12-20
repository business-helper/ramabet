<!DOCTYPE html>
<html>

<head>
    @include('admin.Layout.head')
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
@include('admin.Layout.topbar')

<!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar" style="top: 64px">
            <ul class="nav nav-tabs tab-nav-right" role="tablist" style="display: flex">
                <li role="presentation" class="active" style="flex: 1"><a href="#tabpanl1" data-toggle="tab">Users</a></li>
                <li role="presentation" style="flex: 1"><a href="#tabpanl2" data-toggle="tab">Market</a></li>
            </ul>


            <leftsidebar is_super="{{Auth::user('admin')->is_super}}"></leftsidebar>
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
@include('admin.Layout.script')
@yield('script')

</body>
</html>
