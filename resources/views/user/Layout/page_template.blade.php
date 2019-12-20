<!DOCTYPE html>
<html >

<head>
    @include('user.Layout.head')
    @yield('head')
    <style>

    </style>
</head>
<body class="theme-indigo ls-closed">
<section id="app">
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
    {{-- <div class="overlay"></div>--}}

    {{--<div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>--}}

    @include('user.Layout.topbar')

    <leftsidebar></leftsidebar>
    {{--<rightsidebar></rightsidebar>--}}

    <section class="content ">
        <router-view :key="$route.fullPath"></router-view>
    </section>
    {{--@include('user.Layout.footer')--}}
</section>

@include('user.Layout.script_file')

</body>

@yield('script')
</html>
