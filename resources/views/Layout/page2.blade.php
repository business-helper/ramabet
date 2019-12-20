<!DOCTYPE html>
<html lang="en">
<head>
@include('Layout.header')
    <!-- Styles -->
    @yield("head")
</head>
<body>

@include("Layout.navmenu")

<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-9 text-left" style="">
            @yield("content")
        </div>
        <div id="bet_slipe_div" class="col-sm-3 sidenav" style="">
            @yield("right_content")
        </div>
    </div>
</div>

@include("Layout.footer")
@yield("script")
</body>
</html>
