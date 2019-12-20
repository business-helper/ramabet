@extends('user.Layout.page_template')
@section('head')
<style>

</style>

@stop
@section('content')

    <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:250px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="{{asset('img/spin.svg')}}" />
        </div>
        <div data-u="slides" style="cursor:pointer;position:relative;top:0px;left:0px;width:980px;height:250px;overflow:hidden;">
            @foreach($link_list as $link_item)
                <div style="margin: 5px">
                    <a href="{{$link_item->link}}">
                        <img data-u="image" src="{{asset('img/link/'.$link_item->img)}}" style="padding: 10px"/>
                    </a>
                    <div style="position:absolute;top:23px;left:6px;width:300px;height:195px;">
                        <div style="position:absolute;top:50px;left:50px;width:200px;height:40px;font-size:32px;color:#000000;line-height:1.2;text-align:center;">Text</div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb112" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:24px;height:24px;font-size:12px;line-height:24px;">
                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:-1;">
                    <circle class="b" cx="8000" cy="8000" r="3000"></circle>
                </svg>
                <div data-u="numbertemplate" class="n"></div>
            </div>
        </div>
        <!-- Arrow Navigator -->
        <div data-u="arrowleft" class="jssora081" style="width:30px;height:40px;top:0px;left:30px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
            <svg viewbox="2000 0 12000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <path class="c" d="M4800,14080h6400c528,0,960-432,960-960V2880c0-528-432-960-960-960H4800c-528,0-960,432-960,960 v10240C3840,13648,4272,14080,4800,14080z"></path>
                <path class="a" d="M6860.8,8102.7l1693.9,1693.9c28.9,28.9,63.2,43.4,102.7,43.4s73.8-14.5,102.7-43.4l379-379 c28.9-28.9,43.4-63.2,43.4-102.7c0-39.6-14.5-73.8-43.4-102.7L7926.9,8000l1212.2-1212.2c28.9-28.9,43.4-63.2,43.4-102.7 c0-39.6-14.5-73.8-43.4-102.7l-379-379c-28.9-28.9-63.2-43.4-102.7-43.4s-73.8,14.5-102.7,43.4L6860.8,7897.3 c-28.9,28.9-43.4,63.2-43.4,102.7S6831.9,8073.8,6860.8,8102.7L6860.8,8102.7z"></path>
            </svg>
        </div>
        <div data-u="arrowright" class="jssora081" style="width:30px;height:40px;top:0px;right:30px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
            <svg viewbox="2000 0 12000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <path class="c" d="M11200,14080H4800c-528,0-960-432-960-960V2880c0-528,432-960,960-960h6400 c528,0,960,432,960,960v10240C12160,13648,11728,14080,11200,14080z"></path>
                <path class="a" d="M9139.2,8102.7L7445.3,9796.6c-28.9,28.9-63.2,43.4-102.7,43.4c-39.6,0-73.8-14.5-102.7-43.4 l-379-379c-28.9-28.9-43.4-63.2-43.4-102.7c0-39.6,14.5-73.8,43.4-102.7L8073.1,8000L6860.8,6787.8 c-28.9-28.9-43.4-63.2-43.4-102.7c0-39.6,14.5-73.8,43.4-102.7l379-379c28.9-28.9,63.2-43.4,102.7-43.4 c39.6,0,73.8,14.5,102.7,43.4l1693.9,1693.9c28.9,28.9,43.4,63.2,43.4,102.7S9168.1,8073.8,9139.2,8102.7L9139.2,8102.7z"></path>
            </svg>
        </div>
    </div>
    <div style="text-align: center;" class="sports_list">
        <div style="display: inline-flex;overflow-x: auto;">
            @foreach($sports_list as $sport)
                <a href="{{url('sport/'.$sport->id)}}" class="sport_item ">
                    <img class="{{$sport->icon}}"/>
                    <p >{{$sport->name}}</p>
                </a>
            @endforeach
        </div>
    </div>
    @if($root==3)
        <eventdetail page="{{$page}}" market_id="{{$sel_market}}"></eventdetail>
        @else
        <events page="{{$page}}" target_id="{{$target_id}}"></events>
    @endif
@stop


@section('script')
   {{-- <script type="text/javascript">jssor_1_slider_init();</script>--}}
    <script>

    </script>
@stop
