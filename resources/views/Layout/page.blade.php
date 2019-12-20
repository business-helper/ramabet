<!DOCTYPE html>
<html lang="en">
<head>
    @include('Layout.header')
    @yield("head")
<body>

@include("Layout.navmenu")
<div class="content" style="">
    <div class="row " style="display: flex;height: 93%;margin: 0">
        <div class="sidenav" style="background-color: white;border-left: 1px solid #ddd; border-right: 1px solid #ddd;width: 20%;overflow: auto;">
            @yield("left_content")
        </div>
        <div class="text-left" style="width: 50%;">
            @yield("content")
        </div>
        <div id="bet_slipe_div" class="sidenav" style="width: 30%;">
            @yield("right_content")
        </div>
    </div>
</div>

@include("Layout.footer")
@yield("script")
</body>
</html>
