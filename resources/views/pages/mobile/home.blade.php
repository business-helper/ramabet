@extends('Layout.mobile.page')
@section('head')

    <style>
        .nav-tabs .active a{
            background: #757175;
            background: -moz-linear-gradient(top, #757175 0%, #000000 100%);
            background: -webkit-linear-gradient(top, #757175 0%, #000000 100%);
            background: linear-gradient(to bottom, #757175 0%, #000000 100%);
            color: #FFA40C!important;
        }
        .nav-tabs li a{
            font-weight: bold;
            font-size: 15px;
            background-color: #FFA40C!important;
            background: #FFA40C;
            background: -moz-linear-gradient(top, #FFA40C 0%, #FFA40C 100%);
            background: -webkit-linear-gradient(top, #FFA40C 0%, #FFA40C 100%);
            background: linear-gradient(to bottom, #FFA40C 0%, #FFA40C 100%);
            color: black!important;
            border: 0!important;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .nav-tabs li a span{
            font-size: 20px;
        }
        .nav-tabs li{
            margin-bottom: 0px;!important;
        }
        .active_market{
            background-color: #3ce97b!important;
        }
    </style>
    <style>
        .flow-text{
            position: absolute;
            overflow: hidden;
            width: 80%;
            top: 50px;!important;
            height: 30px;
            margin: auto;
        }
        .flow-text:hover .target{
            animation-play-state: paused;
        }
        .target {
            position: relative;
            -webkit-animation: mymove 5s infinite; /* Safari 4.0 - 8.0 */
            -webkit-animation-timing-function: linear; /* Safari 4.0 - 8.0 */
            animation: mymove 5s infinite;
            animation-timing-function: linear;
        }

        /* Safari 4.0 - 8.0 */
        @-webkit-keyframes mymove {
            from {right: 0;}
            to {left: 80%;}
        }

        @keyframes mymove {
            from {left: 80%;}
            to {left: 0%;}
        }
        .header {
            height: 70px;
            z-index: 1;
        }
        .icon-size{
            height: 160px;!important;
        }
        /*#icon-div{*/
        /*margin-top: 50px;!important;*/
        /*}*/
        .footer #sports:before {
            content: none;
        }
        .footer{
            height:55px;
        }
        .svg-inline--fa {
            height: 25px!important;
            vertical-align: .3em!important;
        }
        .footer p{
            margin:0!important;
            margin-top:-20px!important;
        }
        .table_div {
             margin-top: 0px!important;
        }

        .link_title{
            display: inline-block;
            margin-top: 100px;
        }
        .link_title h1{
            text-transform: uppercase;
            font-family: 'Squada One', cursive;
            font-weight: 800;
            display: block;
            background: #FFF;
            padding: 2px 10px;
            color: #333;
            font-size: 35px;
            text-align: center;
            text-decoration: none;
            position: relative;
            z-index: 1;
            text-shadow:
                    1px 1px 0px #FFF,
                    2px 2px 0px #999,
                    3px 3px 0px #FFF;
            background-image: -webkit-linear-gradient(top, transparent 0%, rgba(0,0,0,.05) 100%);
            -webkit-transition: 1s all;
            background-image: -webkit-linear-gradient(left top,
            transparent 0%, transparent 25%,
            rgba(0,0,0,.15) 25%, rgba(0,0,0,.15) 50%,
            transparent 50%, transparent 75%,
            rgba(0,0,0,.15) 75%);
            background-size: 4px 4px;
            box-shadow:
                    0 0 0 1px rgba(0,0,0,.4) inset,
                    0 0 20px -5px rgba(0,0,0,.4),
                    0 0 0px 3px #FFF inset;

        }
        .link_title h1hover {
            color: #d90075;
        }

        .link_title p{
            color: #443737;
            font-size: 12px;
            font-family: 'Cardo', serif;
            font-weight: normal;
            font-style: italic;
            letter-spacing: 0.1em;
            line-height: 2.2em;
            text-shadow: 0.07em 0.07em 0 rgba(207, 255, 15, 0.8);
        }

    </style>
    @stop

@section('content')
    <div style="">
        <div class="tab-content" style="background-color: white;padding-top: 10px;">
            @foreach($sport_list as $sport_item)
            <div id="cricket" class="tab-pane fade in active">
                <div class="table_div" style="">
                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo{{$sport_item['import_id']}}" style="border-color:#337ab7;font-size: 16px;margin-top:5px;background-color:#337ab7;border-radius:5px;width: 100%;"><img class="{{$sport_item['icon']}}">{{$sport_item['name']}}</button>
                    <div id="demo{{$sport_item['import_id']}}" class="collapse">
                    <table class="table table-hover">
                        <thead class="table_head">
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sport_item[$sport_item['link'].'_inplay'] as $item)
                            @php
                                //$item=json_decode(json_encode($football_inplay[$i]),true);

                                $odds=json_decode($item->runners,true);
                                //var_dump($odds['1_1']);
                                //$event_odd=null;
                            @endphp
                            @if($odds<>null)
                                <tr>
                                    <td>
                                        <a id="{{$item->id}}" href="{{url('mobile/event/detail/'.$item->id.'?market_type=MATCH_ODDS')}}" class="{{$item->state=='progress'?'active_make':'deactive_make'}}">
                                            <div class="event_title">
                                                <p class="score_span">{{$item->time}}</p>
                                                <span class="title_span">{{json_decode($item->home,true)['name']}}</span>
                                                <span class="score_span">v</span>
                                                <span class="title_span">{{json_decode($item->away,true)['name']}}</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div id="{{$item->id.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        @foreach($sport_item[$sport_item['link'].'_coming'] as $item)
                            @php
                                //$item=json_decode(json_encode($football_inplay[$i]),true);

                                $odds=json_decode($item->runners,true);
                                //var_dump($odds['1_1']);
                                //$event_odd=null;
                            @endphp
                            @if($odds<>null)
                                <tr>
                                    <td>
                                        <a id="{{$item->id}}" href="{{url('mobile/event/detail/'.$item->id.'?market_type=MATCH_ODDS')}}" class="{{$item->state=='progress'?'active_make':'deactive_make'}}">
                                            <div class="event_title">
                                                <p class="score_span">{{$item->time}}</p>
                                                <span class="title_span">{{json_decode($item->home,true)['name']}}</span>
                                                <span class="score_span">v</span>
                                                <span class="title_span">{{json_decode($item->away,true)['name']}}</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div id="{{$item->id.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            @endforeach
            {{--<div id="soccer" class="tab-pane fade1">
                <div class="table_div" style="padding: 0px">
                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo2" style="border-color:#337ab7;font-size: 16px;margin-top:5px;background-color:#337ab7;border-radius:5px;width: 100%;"><i class="fas fa-futbol" style="margin-right: 8px;margin-bottom: -10.5px;"></i>Soccer</button>
                    <div id="demo2" class="collapse">
                    <table class="table table-hover">
                        <thead class="table_head">
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($football_inplay as $item)
                            @php
                                //$item=json_decode(json_encode($football_inplay[$i]),true);

                                $odds=json_decode($item->runners,true);
                                //var_dump($odds['1_1']);
                                //$event_odd=null;
                            @endphp
                            @if($odds<>null)
                                <tr>
                                    <td>
                                        <a id="{{$item->id}}" href="{{url('mobile/event/detail/'.$item->id.'?market_type=MATCH_ODDS')}}" class="{{$item->state=='progress'?'active_make':'deactive_make'}}">
                                            <div class="event_title">
                                                <p class="score_span">{{$item->time}}</p>
                                                <span class="title_span">{{json_decode($item->home,true)['name']}}</span>
                                                <span class="score_span">v</span>
                                                <span class="title_span">{{json_decode($item->away,true)['name']}}</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div id="{{$item->id.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        @foreach($football_coming as $item)
                            @php
                                //$item=json_decode(json_encode($football_inplay[$i]),true);

                                $odds=json_decode($item->runners,true);
                                //var_dump($odds['1_1']);
                                //$event_odd=null;
                            @endphp
                            @if($odds<>null)
                                <tr>
                                    <td>
                                        <a id="{{$item->id}}" href="{{url('mobile/event/detail/'.$item->id.'?market_type=MATCH_ODDS')}}" class="{{$item->state=='progress'?'active_make':'deactive_make'}}">
                                            <div class="event_title">
                                                <p class="score_span">{{$item->time}}</p>
                                                <span class="title_span">{{json_decode($item->home,true)['name']}}</span>
                                                <span class="score_span">v</span>
                                                <span class="title_span">{{json_decode($item->away,true)['name']}}</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div id="{{$item->id.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div id="tennis" class="tab-pane fade2">
                <div class="table_div" style="padding: 0px">
                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo3" style="border-color:#337ab7;font-size: 16px;margin-top:5px;background-color:#337ab7;border-radius:5px;width: 100%"><i class="fas fa-table-tennis" style="margin-right: 8px;margin-bottom: -10.5px;"></i>Tennis</button>
                    <div id="demo3" class="collapse">
                    <table class="table table-hover">
                        <thead class="table_head">
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tennis_inplay as $item)
                            @php
                                $odds=json_decode($item->runners,true);
                            @endphp
                            @if($odds<>null)
                                <tr>
                                    <td>
                                        <a id="{{$item->id}}" href="{{url('mobile/event/detail/'.$item->id.'?market_type=MATCH_ODDS')}}" class="{{$item->state=='progress'?'active_make':'deactive_make'}}">
                                            <div class="event_title">
                                                <p class="score_span">{{$item->time}}</p>
                                                <span class="title_span">{{json_decode($item->home,true)['name']}}</span>
                                                <span class="score_span">v</span>
                                                <span class="title_span">{{json_decode($item->away,true)['name']}}</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div id="{{$item->id.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        @foreach($tennis_coming as $item)
                            @php
                                $odds=json_decode($item->runners,true);
                            @endphp
                            @if($odds<>null)
                                <tr>
                                    <td>
                                        <a id="{{$item->id}}" href="{{url('mobile/event/detail/'.$item->id.'?market_type=MATCH_ODDS')}}" class="{{$item->state=='progress'?'active_make':'deactive_make'}}">
                                            <div class="event_title">
                                                <p class="score_span">{{$item->time}}</p>
                                                <span class="title_span">{{json_decode($item->home,true)['name']}}</span>
                                                <span class="score_span">v</span>
                                                <span class="title_span">{{json_decode($item->away,true)['name']}}</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div id="{{$item->id.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>--}}
        </div>
        <div class="row" style="padding: 5px;">
            @foreach($link_list as $item)
                <a href="{{$item->link}}" class="" target="_self">
                    <div class="col-md-6 col-lg-4" style="background-image: url('{{asset('img/link').'/'.$item->img}}');height: 300px;    background-size: cover;background-repeat: no-repeat;background-position: center;margin: 5px">
                           {{-- <h1 class="">{{$item->name}}
                                <p class="">{{$item->description}}</p>
                            </h1>--}}
                    </div>
                </a>
            @endforeach
        </div>
    </div>


@stop

@section('script')
    <script type="text/javascript">
        $('.footer #home').addClass('footer_active');
        $('#soccer').css('display','block');
        $('#tennis').css('display','block');
    </script>
@stop