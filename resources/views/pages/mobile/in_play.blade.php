@extends('Layout.mobile.page')
@section('head')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
            height: 25px;!important;
            vertical-align: .3em;!important;
        }
        .footer p{
            margin:0;!important;
            margin-top:-20px;!important;
        }
    </style>
@stop

@section('content')
    <div style="padding-top: 20px;">
        <div class="btn-group" style="position: fixed;width: 100%;left: 1%;z-index: 1;top: 70px;">
            <button type="button" class="btn btn-primary active" style="width: 33%">In-Play</button>
            <button type="button" class="btn btn-primary" style="width: 33%">Today</button>
            <button type="button" class="btn btn-primary" style="width: 33%">Tomorrow</button>
        </div>
        <div id="play_in" style="">
            <div class="table_div" >
                @foreach($sport_list as $sport_item)
                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#play_in{{$sport_item['import_id']}}" style="border-color:#284257;font-size: 16px;margin-top:5px;background-color:#284257;width: 100%;"><img class="{{$sport_item['icon']}}">{{$sport_item['name']}}</button>
                    <div id="play_in{{$sport_item['import_id']}}" class="collapse">
                        <table class="table table-hover">
                        <thead class="table_head">
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sport_item['sport_events'] as $item)
                            @php
                                $odds=json_decode($item->runners,true);
                            @endphp
                            @if($odds<>null && $item->state=='progress')
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
                @endforeach
            </div>
        </div>

        <div id="today_div" class="" style="display: none">
            <div class="table_div" >
                @foreach($sport_list as $sport_item)
                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#today_div{{$sport_item['import_id']}}" style="border-color:#284257;font-size: 16px;margin-top:5px;background-color:#284257;width: 100%;"><img class="{{$sport_item['icon']}}">{{$sport_item['name']}}</button>
                    <div id="today_div{{$sport_item['import_id']}}" class="collapse">
                        <table class="table table-hover">
                            <thead class="table_head">
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sport_item['sport_events'] as $item)
                                @php
                                    $odds=json_decode($item->runners,true);
                                @endphp
                                @if($odds<>null && $item->state=='upcoming1')
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
                @endforeach
            </div>
        </div>
        <div id="tomorrow_div" class="" style="display: none">
            <div class="table_div" >
                @foreach($sport_list as $sport_item)
                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#tomorrow_div{{$sport_item['import_id']}}" style="border-color:#284257;font-size: 16px;margin-top:5px;background-color:#284257;width: 100%;"><img class="{{$sport_item['icon']}}">{{$sport_item['name']}}</button>
                    <div id="tomorrow_div{{$sport_item['import_id']}}" class="collapse">
                        <table class="table table-hover">
                            <thead class="table_head">
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sport_item['sport_events'] as $item)
                                @php
                                    $odds=json_decode($item->runners,true);
                                @endphp
                                @if($odds<>null && $item->state=='upcoming2')
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
                @endforeach
            </div>
        </div>

    </div>
    {{--content--}}
@stop

@section('script')

    <script type="text/javascript">
        /////////////////////////
        $('.btn-group button').click(function () {
            //alert('sdf');
            var btn=$(this).text();
            $('.btn-group button').removeClass('active');
            $(this).addClass('active');
            switch (btn) {
                case 'In-Play':
                    $('#today_div').css('display','none');
                    $('#play_in').css('display','block')
                    $('#tomorrow_div').css('display','none');
                    break;
                case 'Today':
                    $('#today_div').css('display','block');
                    $('#play_in').css('display','none');
                    $('#tomorrow_div').css('display','none');
                    //getEvent('today');
                    break;
                case 'Tomorrow':
                    $('#today_div').css('display','none');
                    $('#play_in').css('display','none');
                    $('#tomorrow_div').css('display','block');
                    //getEvent('tomorrow');
                    break;
                default:
                    break;
            }
        });

    </script>
    <script type="text/javascript">
        $('.footer #inPlay').addClass('footer_active');
    </script>
@stop