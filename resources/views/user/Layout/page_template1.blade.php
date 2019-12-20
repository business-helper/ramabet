<!DOCTYPE html >
<html  >

<head>
    @include('user.Layout.head')

</head>

<body class="theme-red">
<!-- Page Loader -->
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

@yield('head')
<!-- #Top Bar -->
    <section class="content">
        <div class="container-fluid" style="padding: 0;">
            @yield('content')
        </div>
    </section>

</section>
@include('user.Layout.script_file')
@yield('scrip_temp')
@yield('script')
</body>

</html>
