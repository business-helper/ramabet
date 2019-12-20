@extends('Layout.page')
@section('head')
    {{--<link rel="stylesheet" href="{{asset('admin/css/notifications/Lobibox.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/notifications/notifications.css')}}">
    <script src="{{asset('admin/js/notifications/Lobibox.js')}}"></script>
    <script src="{{asset('admin/js/notifications/notification-active.js')}}"></script>--}}

    <style>
    </style>
@stop
@section('left_content')
    @include('pages.home.left_content'.$root)
@stop
@section('content')
    <div style="padding-left: 10px;padding-right: 10px;height: 100%;overflow: auto;">
        {{--<div style="width: 100%;height: 200px;background-size: cover ;background-image: url('{{asset('img/'.$general_setting['main_image'])}}')">

        </div>--}}
        @if($sports=='favourites')
            @foreach($favourite_arry as $favourite)
                <h1>{{$favourite['event']['teams']}}</h1>
                <div style="margin-top: 20px" class="match_odds">
                    <table class="table oddtable" style="background-color: transparent;">
                        <thead>
                        <tr>
                            <th style="display: flex">
                                <div id="{{$favourite['apidata']->event->eventId.'_market'}}" class="set_market">
                                    <img class="deactive_market"/>
                                    <span style="display: none;">{{$favourite['seleted_market']->description->marketType}}</span>
                                </div>
                                <span>{{$favourite['seleted_market']->description->marketName}}</span>
                            </th>
                            <th style="text-align: right;padding: 0;">
                                <div style="text-align: center;width: 40px;margin-right: 0px;margin-left: auto;">
                                    Back
                                </div>
                            </th>
                            <th style="text-align: left;padding: 0;">
                                <div style="text-align: center;width: 40px;margin-right: auto;margin-left: 0px;">
                                    Lay
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody style="background-color: white">
                        @foreach($favourite['event']['runners'] as $item)
                            @if(isset($item->exchange) && count($item->exchange)>0)
                                <tr>
                                    <td>{{$item->description->runnerName}}</td>
                                    <td style="width: 180px;height: 40px;padding: 1px">
                                        <div class="selectTemp" style="width: 180px!important;height: 100%!important;">
                                            @for($i=2;$i>=0;$i--)
                                                @if(isset($item->exchange->availableToBack) && isset(json_decode(json_encode($item->exchange->availableToBack),true)[$i]))
                                                    <div id="{{$favourite['apidata']->event->eventId}}_{{$favourite['seleted_market']->description->marketType}}_{{$item->selectionId}}_{{$i==0?'':'prev_'}}availableToBack_item" class="left_item {{$i==0?'betting_item':''}}" >

                                                        <span>
                                                            <p class="price">{{json_decode(json_encode($item->exchange->availableToBack),true)[$i]['price']}}</p>
                                                            <span class="size">{{json_decode(json_encode($item->exchange->availableToBack),true)[$i]['size']}}</span>
                                                        </span>
                                                        <input id="eventId" type="hidden" value="{{$favourite['apidata']->event->eventId}}">
                                                        <input id="runnerName" type="hidden" value="{{$item->description->runnerName}}">
                                                        <input id="runnerId" type="hidden" value="{{$item->description->metadata->runnerId}}">
                                                        <input id="odd" type="hidden" value="{{json_decode(json_encode($item->exchange->availableToBack),true)[$i]['price']}}">
                                                        <input id="market_type" type="hidden" value="{{$favourite['seleted_market']->description->marketType}}">
                                                        <input id="market_name" type="hidden" value="{{$favourite['seleted_market']->description->marketName}}">
                                                        <input id="teams" type="hidden" value="{{$favourite['apidata']->event->name}}">
                                                        <input id="bet_type" type="hidden" value="availableToBack">

                                                    </div>
                                                @else
                                                    <div id="{{$favourite['apidata']->event->eventId}}_{{$item->selectionId}}_item" class="left_item">
                                                        --
                                                    </div>
                                                @endif
                                            @endfor
                                        </div>
                                    </td>
                                    <td style="width: 180px;height: 40px;padding: 1px">
                                        <div class="selectTemp" style="width: 180px!important;height: 100%!important;">
                                            @for($i=0;$i<=2;$i++)
                                                @if(isset($item->exchange->availableToLay) && isset(json_decode(json_encode($item->exchange->availableToLay),true)[$i]))
                                                    @php
                                                        $runner=array_reverse(json_decode(json_encode($item->exchange->availableToLay),true));
                                                    @endphp
                                                    <div id="{{$favourite['apidata']->event->eventId}}_{{$favourite['seleted_market']->description->marketType}}_{{$item->selectionId}}_availableToLay_item" class="right_item {{$i==0?'betting_item':''}}">
                                                        <span>
                                                            <p class="price">{{$runner[$i]['price']}}</p>
                                                            <span class="size">
                                                                {{$runner[$i]['size']}}
                                                            </span>
                                                        </span>
                                                        <input id="eventId" type="hidden" value="{{$favourite['apidata']->event->eventId}}">
                                                        <input id="runnerName" type="hidden" value="{{$item->description->runnerName}}">
                                                        <input id="runnerId" type="hidden" value="{{$item->description->metadata->runnerId}}">
                                                        <input id="odd" type="hidden" value="{{$runner[$i]['price']}}">
                                                        <input id="market_type" type="hidden" value="{{$favourite['seleted_market']->description->marketType}}">
                                                        <input id="market_name" type="hidden" value="{{$favourite['seleted_market']->description->marketName}}">
                                                        <input id="teams" type="hidden" value="{{$favourite['apidata']->event->name}}">
                                                        <input id="bet_type" type="hidden" value="availableToLay">
                                                    </div>
                                                @else
                                                    <div id="{{$favourite['apidata']->event->eventId}}_{{$item->selectionId}}_item" class="right_item">
                                                        --
                                                    </div>
                                                @endif
                                            @endfor
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            @if(count($data)==0)
                <h1>No Match Found In {{ucfirst($sports)}}</h1>
            @else

                @if(isset($event['runners']))
                    {{--event detain page--}}
                    <h1>{{$event['teams']}}</h1>

                    <div style="margin-top: 20px" class="match_odds">
                        <table class="table oddtable" style="background-color: transparent;">
                            <thead>
                            <tr>
                                <th style="display: flex">
                                    <div id="{{$event_id.'_market'}}" class="set_market">
                                        <img class="deactive_market"/>
                                        <span style="display: none;">{{$seleted_market->description->marketType}}</span>
                                    </div>
                                    <span>{{$seleted_market->description->marketName}}</span>
                                </th>
                                <th style="text-align: right;padding: 0;">
                                    <div style="text-align: center;width: 40px;margin-right: 0px;margin-left: auto;">
                                        Back
                                    </div>
                                </th>
                                <th style="text-align: left;padding: 0;">
                                    <div style="text-align: center;width: 40px;margin-right: auto;margin-left: 0px;">
                                        Lay
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody style="background-color: white">
                            @foreach($event['runners'] as $item)
                                @if(isset($item->exchange) && count($item->exchange)>0)
                                    <tr>
                                        <td>{{$item->description->runnerName}}</td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div class="selectTemp" style="width: 180px!important;height: 100%!important;">
                                                @for($i=2;$i>=0;$i--)
                                                    @if(isset($item->exchange->availableToBack) && isset(json_decode(json_encode($item->exchange->availableToBack),true)[$i]))
                                                        <div id="{{$apidata->event->eventId}}_{{$seleted_market->description->marketType}}_{{$item->selectionId}}_{{$i==0?'':'prev_'}}availableToBack_item" class="left_item {{$i==0?'betting_item':''}}" >

                                                        <span>
                                                            <p class="price">{{json_decode(json_encode($item->exchange->availableToBack),true)[$i]['price']}}</p>
                                                            <span class="size">
                                                                {{json_decode(json_encode($item->exchange->availableToBack),true)[$i]['size']}}
                                                            </span>
                                                        </span>
                                                            <input id="eventId" type="hidden" value="{{$apidata->event->eventId}}">
                                                            <input id="runnerName" type="hidden" value="{{$item->description->runnerName}}">
                                                            <input id="runnerId" type="hidden" value="{{$item->description->metadata->runnerId}}">
                                                            <input id="odd" type="hidden" value="{{json_decode(json_encode($item->exchange->availableToBack),true)[$i]['price']}}">
                                                            <input id="market_type" type="hidden" value="{{$seleted_market->description->marketType}}">
                                                            <input id="market_name" type="hidden" value="{{$seleted_market->description->marketName}}">
                                                            <input id="teams" type="hidden" value="{{$apidata->event->name}}">
                                                            <input id="bet_type" type="hidden" value="availableToBack">

                                                        </div>
                                                    @else
                                                        <div id="{{$apidata->event->eventId}}_{{$item->selectionId}}_item" class="left_item">
                                                            --
                                                        </div>
                                                    @endif
                                                @endfor
                                            </div>
                                        </td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div class="selectTemp" style="width: 180px!important;height: 100%!important;">
                                                @for($i=0;$i<=2;$i++)
                                                    @if(isset($item->exchange->availableToLay) && isset(json_decode(json_encode($item->exchange->availableToLay),true)[$i]))
                                                        @php
                                                            $runner=array_reverse(json_decode(json_encode($item->exchange->availableToLay),true));
                                                        @endphp
                                                        <div id="{{$apidata->event->eventId}}_{{$seleted_market->description->marketType}}_{{$item->selectionId}}_availableToLay_item" class="right_item {{$i==0?'betting_item':''}}">
                                                        <span>
                                                            <p class="price">{{$runner[$i]['price']}}</p>
                                                            <span class="size">
                                                                {{$runner[$i]['size']}}
                                                            </span>

                                                        </span>
                                                            <input id="eventId" type="hidden" value="{{$apidata->event->eventId}}">
                                                            <input id="runnerName" type="hidden" value="{{$item->description->runnerName}}">
                                                            <input id="runnerId" type="hidden" value="{{$item->description->metadata->runnerId}}">
                                                            <input id="odd" type="hidden" value="{{$runner[$i]['price']}}">
                                                            <input id="market_type" type="hidden" value="{{$seleted_market->description->marketType}}">
                                                            <input id="market_name" type="hidden" value="{{$seleted_market->description->marketName}}">
                                                            <input id="teams" type="hidden" value="{{$apidata->event->name}}">
                                                            <input id="bet_type" type="hidden" value="availableToLay">
                                                        </div>
                                                    @else
                                                        <div id="{{$apidata->event->eventId}}_{{$item->selectionId}}_item" class="right_item">
                                                            --
                                                        </div>
                                                    @endif
                                                @endfor
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    {{--sport page--}}
                    <h1>{{ucfirst($sports)}}</h1>
                    <div  class="" style="    height: calc(100% - 77px);overflow-y: auto">
                        <div id="menu1" class="">
                            <div class="table_div" >
                                <table class="table table-hover" >
                                    <thead class="table_head">
                                    <tr>
                                        <th style="text-align: left">Match</th>
                                        <th class="width_thead">1</th>
                                        <th class="width_thead">x</th>
                                        <th class="width_thead">2</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $item)
                                        @php
                                            $odds=json_decode($item->runners,true);
                                        @endphp
                                        @if($odds<>null)
                                            <tr>
                                                <td style="    padding: 4px 8px;">
                                                    <div style="display: flex">
                                                        <div id="{{$item->id.'_market'}}" class="set_market"><img class="deactive_market"/>
                                                            <span style="display: none">MATCH_ODDS</span>
                                                        </div>
                                                        <a id="{{$item->id}}" href="{{url('/'.$sports.'/3/'.json_decode($item->league)->id.'/'.$item->id.'/MATCH_ODDS')}}" >
                                                            <div class="event_title">
                                                                <span class="title_span">{{json_decode($item->home,true)['name']}}</span>
                                                                <span class="score_span">v</span>
                                                                <span class="title_span">{{json_decode($item->away,true)['name']}}</span>
                                                            </div>
                                                        </a>
                                                        @if($item->state=='progress')
                                                            <span class="progress_title inplay"><i class="fas fa-play-circle"></i>InPlay</span>
                                                        @else
                                                            <span class="progress_title">{{$item->time}}</span>
                                                        @endif
                                                    </div>

                                                </td>
                                                <td >
                                                    <div class="selectTemp">
                                                        @if(isset($odds[0]['exchange']['availableToBack']))
                                                            @php
                                                                $runner=array_reverse(json_decode(json_encode($odds[0]['exchange']['availableToBack']),true),true);
                                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                                            @endphp
                                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[0]['selectionId']}}_availableToBack_item" class="left_item betting_item" >
                                                                <span class="price">{{$runner[0]['price']}}</span>
                                                                {{--<span>{{$runner[0]['size']}}</span>--}}
                                                                <input id="eventId" type="hidden" value="{{$item->id}}">
                                                                <input id="runnerName" type="hidden" value="{{$odds[0]['description']['runnerName']}}">
                                                                <input id="runnerId" type="hidden" value="{{$odds[0]['description']['metadata']['runnerId']}}">
                                                                <input id="odd" type="hidden" value="{{$runner[0]['price']}}">
                                                                <input id="market_type" type="hidden" value="MATCH_ODDS">
                                                                <input id="market_name" type="hidden" value="Match Odds">
                                                                <input id="teams" type="hidden" value="{{$teams}}">
                                                                <input id="bet_type" type="hidden" value="availableToBack">
                                                            </div>
                                                        @else
                                                            <div id="{{$item->id}}_1_0_item" class="left_item" >
                                                                <span>--</span>
                                                            </div>
                                                        @endif
                                                        @if(isset($odds[0]['exchange']['availableToLay']))
                                                            @php
                                                                $runner=array_reverse(json_decode(json_encode($odds[0]['exchange']['availableToLay']),true),false);
                                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                                            @endphp
                                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[0]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                                <span class="price">{{$runner[0]['price']}}</span>
                                                                {{--<span>{{$runner[0]['size']}}</span>--}}
                                                                <input id="eventId" type="hidden" value="{{$item->id}}">
                                                                <input id="runnerName" type="hidden" value="{{$odds[0]['description']['runnerName']}}">
                                                                <input id="runnerId" type="hidden" value="{{$odds[0]['description']['metadata']['runnerId']}}">
                                                                <input id="odd" type="hidden" value="{{$runner[0]['price']}}">
                                                                <input id="market_type" type="hidden" value="MATCH_ODDS">
                                                                <input id="market_name" type="hidden" value="Match Odds">
                                                                <input id="teams" type="hidden" value="{{$teams}}">
                                                                <input id="bet_type" type="hidden" value="availableToLay">
                                                            </div>
                                                        @else
                                                            <div id="{{$item->id}}_1_0_item" class="right_item" >
                                                                <span>--</span>
                                                            </div>
                                                        @endif


                                                    </div>
                                                </td>
                                                <td >
                                                    <div class="selectTemp">
                                                        @if(isset($odds[2]['exchange']['availableToBack']))
                                                            @php
                                                                $runner=array_reverse(json_decode(json_encode($odds[2]['exchange']['availableToBack']),true),true);
                                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                                            @endphp
                                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[2]['selectionId']}}_availableToBack_item" class="left_item betting_item" >
                                                                <span class="price">{{$runner[0]['price']}}</span>
                                                                {{--<span>{{$runner[0]['size']}}</span>--}}
                                                                <input id="eventId" type="hidden" value="{{$item->id}}">
                                                                <input id="runnerName" type="hidden" value="{{$odds[2]['description']['runnerName']}}">
                                                                <input id="runnerId" type="hidden" value="{{$odds[2]['description']['metadata']['runnerId']}}">
                                                                <input id="odd" type="hidden" value="{{$runner[0]['price']}}">
                                                                <input id="market_type" type="hidden" value="MATCH_ODDS">
                                                                <input id="market_name" type="hidden" value="Match Odds">
                                                                <input id="teams" type="hidden" value="{{$teams}}">
                                                                <input id="bet_type" type="hidden" value="availableToBack">
                                                            </div>
                                                        @else
                                                            <div id="{{$item->id}}_1_0_item" class="left_item" >
                                                                <span>--</span>
                                                            </div>
                                                        @endif
                                                        @if(isset($odds[2]['exchange']['availableToLay']))
                                                            @php
                                                                $runner=array_reverse(json_decode(json_encode($odds[2]['exchange']['availableToLay']),true),false);
                                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                                            @endphp
                                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[2]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                                <span class="price">{{$runner[0]['price']}}</span>
                                                                {{--<span>{{$runner[0]['size']}}</span>--}}
                                                                <input id="eventId" type="hidden" value="{{$item->id}}">
                                                                <input id="runnerName" type="hidden" value="{{$odds[2]['description']['runnerName']}}">
                                                                <input id="runnerId" type="hidden" value="{{$odds[2]['description']['metadata']['runnerId']}}">
                                                                <input id="odd" type="hidden" value="{{$runner[0]['price']}}">
                                                                <input id="market_type" type="hidden" value="MATCH_ODDS">
                                                                <input id="market_name" type="hidden" value="Match Odds">
                                                                <input id="teams" type="hidden" value="{{$teams}}">
                                                                <input id="bet_type" type="hidden" value="availableToLay">
                                                            </div>
                                                        @else
                                                            <div id="{{$item->id}}_1_0_item" class="right_item" >
                                                                <span>--</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td  >
                                                    <div class="selectTemp">
                                                        @if(isset($odds[1]['exchange']['availableToBack']))
                                                            @php
                                                                $runner=array_reverse(json_decode(json_encode($odds[1]['exchange']['availableToBack']),true),true);
                                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                                            @endphp
                                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[1]['selectionId']}}_availableToBack_item" class="left_item betting_item" >
                                                                <span class="price">{{$runner[0]['price']}}</span>
                                                                {{--<span>{{$runner[0]['size']}}</span>--}}
                                                                <input id="eventId" type="hidden" value="{{$item->id}}">
                                                                <input id="runnerName" type="hidden" value="{{$odds[1]['description']['runnerName']}}">
                                                                <input id="runnerId" type="hidden" value="{{$odds[1]['description']['metadata']['runnerId']}}">
                                                                <input id="odd" type="hidden" value="{{$runner[0]['price']}}">
                                                                <input id="market_type" type="hidden" value="MATCH_ODDS">
                                                                <input id="market_name" type="hidden" value="Match Odds">
                                                                <input id="teams" type="hidden" value="{{$teams}}">
                                                                <input id="bet_type" type="hidden" value="availableToBack">
                                                            </div>
                                                        @else
                                                            <div id="{{$item->id}}_1_0_item" class="left_item" >
                                                                <span>--</span>
                                                            </div>
                                                        @endif
                                                        @if(isset($odds[1]['exchange']['availableToLay']))
                                                            @php
                                                                $runner=array_reverse(json_decode(json_encode($odds[1]['exchange']['availableToLay']),true),false);
                                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                                            @endphp
                                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[1]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                                <span class="price">{{$runner[0]['price']}}</span>
                                                                {{--<span>{{$runner[0]['size']}}</span>--}}
                                                                <input id="eventId" type="hidden" value="{{$item->id}}">
                                                                <input id="runnerName" type="hidden" value="{{$odds[1]['description']['runnerName']}}">
                                                                <input id="runnerId" type="hidden" value="{{$odds[1]['description']['metadata']['runnerId']}}">
                                                                <input id="odd" type="hidden" value="{{$runner[0]['price']}}">
                                                                <input id="market_type" type="hidden" value="MATCH_ODDS">
                                                                <input id="market_name" type="hidden" value="Match Odds">
                                                                <input id="teams" type="hidden" value="{{$teams}}">
                                                                <input id="bet_type" type="hidden" value="availableToLay">
                                                            </div>
                                                        @else
                                                            <div id="{{$item->id}}_1_0_item" class="right_item" >
                                                                <span>--</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                @endif
            @endif
        @endif

    </div>
@stop
@section('right_content')
    @include('pages.home.right_content')
@stop
@section('script')
    <script>

    </script>
@stop