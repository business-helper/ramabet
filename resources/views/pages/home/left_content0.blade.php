<div class="list-group">
    <a href="{{url('/favourites')}}" class="list-group-item">
        <img class="star"/>
        <span>Favourites</span>
    </a>
    {{--<a href="{{url('/promotions')}}" class="list-group-item">
        <img class="promotions"/>
        <span>Promotions</span>
    </a>--}}
    @foreach($sports_list as $sport)
        <a href="{{url('/sport/'.$sport->link)}}" class="list-group-item notranslate">
            <img class="{{$sport->icon}}"/>
            <span >{{$sport->name}}</span>
        </a>
    @endforeach
    {{--<a href="{{url('/cricket/1')}}" class="list-group-item">
        <img class="cricket"/>
        <span>Cricket</span>
    </a>
    <a href="{{url('/tennis/1')}}" class="list-group-item">
        <img class="tennis"/>
        <span>Tennis</span>
    </a>--}}
    {{--<a class="link-lvl-prev" onclick="window.history.go(-1); return false;"><i class="apl-icon-chevron-sign-left"></i>Previous </a>--}}
    @guest
    @else

    @endguest

</div>