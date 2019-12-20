
<div class="list-group">
    <a href="{{url('/favourites')}}" class="list-group-item">
        <img class="star"/>
        <span>Favourites</span>
    </a>
    <a href="{{url('/')}}" class="list-group-item">
        <span style="font-size: 14px;">
            <i class="fas fa-home"></i>
        </span>
        <span>Sports</span>
    </a>
    <a href="{{url('sport/'.$current_sport->id)}}" class="list-group-item current_sports">
        <img class="{{$current_sport->icon}}"/>
        <span>{{ucfirst($current_sport->name)}}</span>
    </a>
    <a class="list-group-item" onclick="window.history.go(-1); return false;" style="color: {{$current_sport->color}}">
        <span style="font-size: 14px;">
            <i class="fas fa-chevron-circle-left"></i>
        </span>
        <span>
            Previous
        </span>
    </a>
    @foreach($league as $item)
        <a href="{{url('/league/'.$item->id)}}" class="list-group-item" style="color: {{$current_sport->color}}">
            <span style="text-overflow: ellipsis;display: inline-block;
    overflow: hidden;
    width: 90%;
    height: 1.2em;
    white-space: nowrap;" title="{{$item->league_name}}">{{$item->league_name}}</span>
            <span style="float: right;"><i class="fas fa-chevron-right"></i></span>
        </a>
    @endforeach
    {{--<a class="link-lvl-prev" onclick="window.history.go(-1); return false;"><i class="apl-icon-chevron-sign-left"></i>Previous </a>--}}
    @guest
    @else

    @endguest

</div>