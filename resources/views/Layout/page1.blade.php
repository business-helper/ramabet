<!DOCTYPE html>
<html lang="en">
<head>
    @include('Layout.header')

    @yield("head")
</head>
<body>

@include("Layout.navmenu")

<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-3 sidenav" style="padding: 0">
            @yield("left_content")
        </div>
        <div class="col-sm-9 text-left" style="padding: 10px;min-height:768px">
            @yield("content")
        </div>
    </div>
</div>

@include("Layout.footer")
@yield("script")
</body>
</html>
