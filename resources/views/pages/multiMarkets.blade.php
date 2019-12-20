@extends('Layout.page')
@section('head')
    <style>
        .tab-pane{background-color: #e1e1e1!important;}

        .selectTemp p{margin: 0;}
        .selectTemp span{font-size: 11px;}
        .left_item{width: 60px!important;}
        .right_item{width: 60px!important;}
        .deactive{width: 60px!important;}
        .match_odds table{}
        .refresh{border-radius: 50%;background-color: #b9bbbe;font-size: 15px;text-align: center;width: 20px;height: 20px;}

    </style>
@stop
@section('left_content')
    <div id="pathbackUI" style="">
        <div class="path_item">
            <div class="dropdown">
                <div class="dropdown-toggle" type="button" data-toggle="dropdown" style="display: flex">Sports
                    <span class="caret" style="margin-top: 9px"></span>
                </div>

            </div>
        </div>

    </div>
    <div class="list-group">
        <a href="{{url('/cricket')}}" class="list-group-item">Cricket</a>
        <a href="{{url('/soccer')}}" class="list-group-item">Soccer</a>
        <a href="{{url('/tennis')}}" class="list-group-item">Tennis</a>
        @guest
        @else
            <a href="{{url('/election')}}" class="list-group-item">Election</a>
        @endguest

    </div>
@stop
@section('content')
    @foreach($events as $key=>$event)
        @php
            //var_dump(json_decode($item['Odds'],true)[0]['Bets']);
            $runners=json_decode($event->runners);
            $teams=json_decode($event->home,true)['name'].' v '.json_decode($event->away,true)['name'];
        @endphp
        <div style="display:flex;background-color: #274156;height: 50px;">
            <div id="{{$event->event_id.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
            <div style="width: 35%;text-align: right;color: white;font-size:1.5em;    margin: auto;padding-right: 20px;">
                <span>{{json_decode($event->home,true)['name']}}</span>
            </div>
            <div style="width: 30%;text-align: center;background-color: white;height: 90%;border-radius: 0px 0px 40px 40px;padding-top: 5px;">
                <span>vs</span>
            </div>
            <div style="width: 35%;text-align: left;color: white;font-size:1.5em;margin: auto;padding-left: 20px;">
                <span>{{json_decode($event->away,true)['name']}}</span>
            </div>
            <div class="refresh"><i class="fas fa-sync-alt"></i></div>
        </div>
        <div style="margin-top: 20px" class="match_odds">
            <table class="table oddtable" style="background-color: transparent;">
                <thead>
                <tr>
                    <th>selections</th>
                    <th style="text-align: right;padding: 0;">
                        <div style="border-radius: 20px 0px 0px 0px;text-align: center;background-color: #1fda1f;width: 90px;margin-right: 0px;margin-left: auto;">
                            Back all
                        </div>
                    </th>
                    <th style="text-align: left;padding: 0;">
                        <div style="border-radius: 0px 20px 0px 0px;text-align: center;background-color: #da7d7a;width: 90px;margin-right: auto;margin-left: 0px;">
                            Lay all
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody style="background-color: white">
                @foreach($runners as $item)
                    @if(isset($item->exchange) && count($item->exchange)>0)
                        <tr>
                            <td><li>{{$item->description->runnerName}}</li></td>
                            <td style="width: 180px;height: 40px;padding: 2px">
                                <div class="selectTemp" style="width: 180px!important;height: 40px!important;">
                                    @for($i=2;$i>=0;$i--)
                                        @if(isset($item->exchange->availableToBack) && isset(json_decode(json_encode($item->exchange->availableToBack),true)[$i]))
                                            @php

                                                    @endphp
                                            <div id="{{$event->event_id}}_MATCH_ODDS_{{$item->selectionId}}_{{$i==0?'':'prev_'}}availableToBack_item" class="left_item {{$i==0?'betting_item':''}}" >
                                                <p>{{json_decode(json_encode($item->exchange->availableToBack),true)[$i]['price']}}</p>
                                                <span>{{json_decode(json_encode($item->exchange->availableToBack),true)[$i]['size']}}</span>
                                                <input id="eventId" type="hidden" value="{{$event->event_id}}">
                                                <input id="runnerName" type="hidden" value="{{$item->description->runnerName}}">
                                                <input id="runnerId" type="hidden" value="{{$item->description->metadata->runnerId}}">
                                                <input id="odd" type="hidden" value="{{json_decode(json_encode($item->exchange->availableToBack),true)[$i]['price']}}">
                                                <input id="market_type" type="hidden" value="MATCH_ODDS">
                                                <input id="market_name" type="hidden" value="Match Odds">
                                                <input id="teams" type="hidden" value="{{$teams}}">
                                                <input id="bet_type" type="hidden" value="availableToBack">

                                            </div>
                                        @else
                                            <div id="" class="deactive">
                                                --
                                            </div>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td style="width: 180px;height: 40px;padding: 2px">
                                <div class="selectTemp" style="width: 180px!important;height: 40px!important;">
                                    @for($i=0;$i<=2;$i++)
                                        @if(isset($item->exchange->availableToLay) && isset(json_decode(json_encode($item->exchange->availableToLay),true)[$i]))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($item->exchange->availableToLay),true));
                                            @endphp
                                            <div id="{{$event->event_id}}_MATCH_ODDS_{{$item->selectionId}}_availableToLay_item" class="right_item {{$i==0?'betting_item':''}}">
                                                <p>{{$runner[$i]['price']}}</p>
                                                <span>{{$runner[$i]['size']}}</span>
                                                <input id="eventId" type="hidden" value="{{$event->event_id}}">
                                                <input id="runnerName" type="hidden" value="{{$item->description->runnerName}}">
                                                <input id="runnerId" type="hidden" value="{{$item->description->metadata->runnerId}}">
                                                <input id="odd" type="hidden" value="{{json_decode(json_encode($item->exchange->availableToLay),true)[$i]['price']}}">
                                                <input id="market_type" type="hidden" value="MATCH_ODDS">
                                                <input id="market_name" type="hidden" value="Match Odds">
                                                <input id="teams" type="hidden" value="{{$teams}}">
                                                <input id="bet_type" type="hidden" value="availableToLay">
                                            </div>
                                        @else
                                            <div id="" class="deactive">
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

@stop
@section('right_content')
    <div class="right_title">
        <span>Bet Slip</span>
    </div>
    <div id="betSlipBoard">

    </div>
    <div id="betSlipFooter" style="display: none">
        <div style="text-align: right;">
            <span>Liability $</span>
            <span id="total_price">0</span>
        </div>
        <div style="display: flex;margin-top: 10px">
            <button id="cancelall" class="btn second" style="margin-right: auto;">Cancel All</button>
            <button id="placebets" class="btn third">Place Bets</button>
        </div>
        <div style="text-align: left">
            <input id="confirm" type="checkbox" value="Please confirm your bets.">
            <label for="confirm">Please confirm your bets.</label>
        </div>
    </div>
@stop
@section('script')
    <script>

    </script>
@stop