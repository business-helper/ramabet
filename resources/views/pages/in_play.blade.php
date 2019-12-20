@extends('Layout.page2')
@section('head')

    <style>
        .filter{width: 100%;height: auto;margin-top: 10px;border-bottom: solid 2px cadetblue;background-color: white;padding-left: 20px;position: relative;}
        .filter span{line-height: 40px;margin-right: 10px;position: relative;}
        .filter .filter-item:after{content: '';position: absolute;width: 6px;height: 6px;top: 40%;right: -10px;border-radius: 3px;background-color: black;}
        .filter_btn {position: absolute;right: 10px;top: 5px;height: 30px;padding:5px 10px 5px 10px;}
        /*modal css*/
        button {cursor: pointer;}
        .trigger i {
            margin-right: 0.3125rem;
        }
        .modal {position: fixed;top: 0;left: 0;display: flex;align-items: center;justify-content: center;height: 0vh;background-color: transparent;overflow: hidden;transition: background-color 0.25s ease;z-index: 9999;}
        .modal.open {position: fixed;width: 100%;height: 100vh;background-color: rgba(0, 0, 0, 0.5);transition: background-color 0.25s;}
        .modal.open > .content-wrapper {transform: scale(1);}
        .modal .content-wrapper {position: relative;display: flex;flex-direction: column;align-items: center;justify-content: flex-start; /*width: 50%;*/margin: 0;padding: 2.5rem;background-color: white;border-radius: 0.3125rem;box-shadow: 0 0 2.5rem rgba(0, 0, 0, 0.5);transform: scale(0);transition: transform 0.25s;transition-delay: 0.15s;}
        .modal .content-wrapper .close {position: absolute;top: 0.5rem;right: 0.5rem;display: flex;align-items: center;justify-content: center;width: 2.5rem;height: 2.5rem;border: none;background-color: transparent;font-size: 1.5rem;transition: 0.25s linear;}
        .modal .content-wrapper .close:before, .modal .content-wrapper .close:after {position: absolute;content: '';width: 1.25rem;height: 0.125rem;background-color: black;}
        .modal .content-wrapper .close:before {transform: rotate(-45deg);}
        .modal .content-wrapper .close:after {transform: rotate(45deg);}
        .modal .content-wrapper .close:hover {transform: rotate(360deg);}
        .modal .content-wrapper .close:hover:before, .modal .content-wrapper .close:hover:after {background-color: tomato;}
        .modal .content-wrapper .modal-header {position: relative;display: flex;flex-direction: row;align-items: center;justify-content: space-between;width: 100%;margin: 0;padding: 0 0 1.25rem;}
        .modal .content-wrapper .modal-header h2 {font-size: 1.5rem;font-weight: bold;}
        .modal .content-wrapper .content {position: relative;display: flex;}
        .modal .content-wrapper .content p {font-size: 0.875rem;line-height: 1.75;}
        .modal .content-wrapper .modal-footer {position: relative;display: flex;align-items: center;justify-content: flex-end;width: 100%;margin: 0;padding: 1.875rem 0 0;}
        .modal .content-wrapper .modal-footer .action {position: relative;margin-left: 0.625rem;padding: 0.625rem 1.25rem;border: none;background-color: slategray;border-radius: 0.25rem;color: white;font-size: 1.5rem;font-weight: 300;overflow: hidden;z-index: 1;}
        .modal .content-wrapper .modal-footer .action:before {position: absolute;content: '';top: 0;left: 0;width: 0%;height: 100%;background-color: rgba(255, 255, 255, 0.2);transition: width 0.25s;z-index: 0;}
        .modal .content-wrapper .modal-footer .action:first-child {background-color: #2ecc71;}
        .modal .content-wrapper .modal-footer .action:last-child {background-color: #e74c3c;}
        .modal .content-wrapper .modal-footer .action:hover:before {width: 100%;}
        /*checkbox css*/
        .checkbox label:after,
        .radio label:after {content: '';display: table;clear: both;}

        .checkbox .cr,
        .radio .cr {position: relative;display: inline-block;border: 1px solid #a9a9a9;border-radius: .25em;width: 1.3em;height: 1.3em;float: left;margin-right: .5em;}
        .radio .cr {border-radius: 50%;}
        .checkbox .cr .cr-icon,
        .radio .cr .cr-icon {position: absolute;font-size: .8em;line-height: 0;top: 50%;left: 20%;}
        .radio .cr .cr-icon {margin-left: 0.04em;}
        .checkbox{margin-top: 0!important;}
        .checkbox label input[type="checkbox"],
        .radio label input[type="radio"] {display: none;}
        .checkbox label input[type="checkbox"] + .cr > .cr-icon,
        .radio label input[type="radio"] + .cr > .cr-icon {transform: scale(3) rotateZ(-20deg);opacity: 0;transition: all .3s ease-in;}

        .checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
        .radio label input[type="radio"]:checked + .cr > .cr-icon {transform: scale(1) rotateZ(0deg);opacity: 1;}
        .checkbox label input[type="checkbox"]:disabled + .cr,
        .radio label input[type="radio"]:disabled + .cr {opacity: .5;}

    </style>
@stop

@section('content')
    <div style="padding: 20px;">
        <div class="btn-group">
            <button type="button" class="btn btn-primary active">In-Play</button>
            <button type="button" class="btn btn-primary">Today</button>
            <button type="button" class="btn btn-primary">Tomorrow</button>
        </div>
        <div id="play_in">
            <div class="table_div" style="padding: 10px">
                <div class="title">Cricket</div>
                <table class="table table-hover">
                    <thead class="table_head">
                    <tr>
                        <th></th>
                        <th>1</th>
                        <th>x</th>
                        <th>2</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cricket as $item)
                        @php
                            //$item=json_decode(json_encode($football_inplay[$i]),true);

                            $odds=json_decode($item->runners,true);
                            //var_dump($odds['1_1']);
                            //$event_odd=null;
                        @endphp
                        @if($odds<>null)
                            <tr>
                                <td>
                                    <a id="{{$item->id}}" href="{{url('/event/detail/'.$item->id.'?market_type=MATCH_ODDS')}}" class="{{$item->state=='progress'?'active_make':'deactive_make'}}">
                                        <div class="event_title">
                                            <p class="score_span">{{$item->time}}</p>
                                            <span class="title_span">{{json_decode($item->home,true)['name']}}</span>
                                            <span class="score_span">v</span>
                                            <span class="title_span">{{json_decode($item->away,true)['name']}}</span>
                                        </div>
                                    </a>
                                </td>
                                <td >
                                    <div class="selectTemp">
                                        @if(isset($odds[0]['exchange']['availableToBack']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[0]['exchange']['availableToBack']),true),true);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[0]['selectionId']}}_availableToBack_item" class="left_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                        @if(isset($odds[0]['exchange']['availableToLay']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[0]['exchange']['availableToLay']),true),false);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[0]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
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
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                        @if(isset($odds[2]['exchange']['availableToLay']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[2]['exchange']['availableToLay']),true),false);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[2]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
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
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                        @if(isset($odds[1]['exchange']['availableToLay']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[1]['exchange']['availableToLay']),true),false);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[1]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <div id="{{$item->id.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <div class="title">Soccer</div>
                <table class="table table-hover">
                    <thead class="table_head">
                    <tr>
                        <th></th>
                        <th>1</th>
                        <th>x</th>
                        <th>2</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($football as $item)
                        @php
                            //$item=json_decode(json_encode($football_inplay[$i]),true);

                            $odds=json_decode($item->runners,true);
                            //var_dump($odds['1_1']);
                            //$event_odd=null;
                        @endphp
                        @if($odds<>null)
                            <tr>
                                <td>
                                    <a id="{{$item->id}}" href="{{url('/event/detail/'.$item->id.'?market_type=MATCH_ODDS')}}" class="{{$item->state=='progress'?'active_make':'deactive_make'}}">
                                        <div class="event_title">
                                            <p class="score_span">{{$item->time}}</p>
                                            <span class="title_span">{{json_decode($item->home,true)['name']}}</span>
                                            <span class="score_span">v</span>
                                            <span class="title_span">{{json_decode($item->away,true)['name']}}</span>
                                        </div>
                                    </a>
                                </td>
                                <td >
                                    <div class="selectTemp">
                                        @if(isset($odds[0]['exchange']['availableToBack']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[0]['exchange']['availableToBack']),true),true);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[0]['selectionId']}}_availableToBack_item" class="left_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                        @if(isset($odds[0]['exchange']['availableToLay']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[0]['exchange']['availableToLay']),true),false);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[0]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
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
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                        @if(isset($odds[2]['exchange']['availableToLay']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[2]['exchange']['availableToLay']),true),false);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[2]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
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
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                        @if(isset($odds[1]['exchange']['availableToLay']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[1]['exchange']['availableToLay']),true),false);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[1]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <div id="{{$item->id.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <div class="title">Tennis</div>
                <table class="table table-hover">
                    <thead class="table_head">
                    <tr>
                        <th></th>
                        <th>1</th>
                        <th>x</th>
                        <th>2</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tennis as $item)
                        @php
                            //$item=json_decode(json_encode($football_inplay[$i]),true);

                            $odds=json_decode($item->runners,true);
                            //var_dump($odds['1_1']);
                            //$event_odd=null;
                        @endphp
                        @if($odds<>null)
                            <tr>
                                <td>
                                    <a id="{{$item->id}}" href="{{url('/event/detail/'.$item->id.'?market_type=MATCH_ODDS')}}" class="{{$item->state=='progress'?'active_make':'deactive_make'}}">
                                        <div class="event_title">
                                            <p class="score_span">{{$item->time}}</p>
                                            <span class="title_span">{{json_decode($item->home,true)['name']}}</span>
                                            <span class="score_span">v</span>
                                            <span class="title_span">{{json_decode($item->away,true)['name']}}</span>
                                        </div>
                                    </a>
                                </td>
                                <td >
                                    <div class="selectTemp">
                                        @if(isset($odds[0]['exchange']['availableToBack']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[0]['exchange']['availableToBack']),true),true);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[0]['selectionId']}}_availableToBack_item" class="left_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                        @if(isset($odds[0]['exchange']['availableToLay']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[0]['exchange']['availableToLay']),true),false);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[0]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
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
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                        @if(isset($odds[2]['exchange']['availableToLay']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[2]['exchange']['availableToLay']),true),false);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[2]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
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
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                        @if(isset($odds[1]['exchange']['availableToLay']))
                                            @php
                                                $runner=array_reverse(json_decode(json_encode($odds[1]['exchange']['availableToLay']),true),false);
                                                $teams=json_decode($item->home,true)['name'].' v '.json_decode($item->away,true)['name'];
                                            @endphp
                                            <div id="{{$item->id}}_MATCH_ODDS_{{$odds[1]['selectionId']}}_availableToLay_item" class="right_item betting_item" >
                                                <p>{{$runner[0]['price']}}</p>
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
                                            <div id="{{$item->id}}_1_0_item" class="deactive" >
                                                <span>--</span>
                                            </div>
                                        @endif
                                    </div>
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
        <div id="today_div" class="" style="display: none">
            <div class="filter">
                <span><strong>Sport Filters:</strong></span>
                <span id="span_cricket" class="filter-item">Cricket</span>
                <span id="span_soccer" class="filter-item">Soccer</span>
                <span id="span_tennis">Tennis</span>
                <button type="button" class="btn btn-default filter_btn" data-modal-trigger="trigger-1">Filter</button>
            </div>
            <table class="table table-hover">
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>


    </div>
    {{--content--}}

    {{--modal dialog--}}
    <div id="trigger1" data-modal="trigger-1" class="modal" >
        <article class="content-wrapper">
            <button class="close"></button>
            <div class="content">
                <div class="checkbox ">
                    <label>
                        <input id="checkbox_all" type="checkbox" value="" checked>
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                        All
                    </label>
                </div>
                <div class="checkbox ">
                    <label>
                        <input id="checkbox_cricket" class="checkbox_item" type="checkbox" value="" checked>
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                        Cricket
                    </label>
                </div>
                <div class="checkbox ">
                    <label>
                        <input id="checkbox_soccer" class="checkbox_item" type="checkbox" value="" checked>
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                        Soccer
                    </label>
                </div>
                <div class="checkbox ">
                    <label>
                        <input id="checkbox_tennis" class="checkbox_item" type="checkbox" value="" checked>
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                        Tennis
                    </label>
                </div>
            </div>
            <footer class="modal-footer" style="background-color: white">
                <button class="action " >Save</button>
                <button class="action" >Cancel</button>
            </footer>
        </article>
    </div>
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
    <script type="text/javascript">
        /////////////////////////
        var filter= new Object();
        filter['All']=true;
        filter['Cricket']=true;
        filter['Soccer']=true;
        filter['Tennis']=true;

        //modal
        const buttons = document.querySelectorAll(`button[data-modal-trigger]`);
        for(let button of buttons) {
            modalEvent(button);
        }
        function modalEvent(button) {

            button.addEventListener('click', () => {
                const trigger = button.getAttribute('data-modal-trigger');
                const modal = document.querySelector(`[data-modal=${trigger}]`);
                const contentWrapper = modal.querySelector('.content-wrapper');
                const close = modal.querySelector('.close');
                close.addEventListener('click', () => modal.classList.remove('open'));
                modal.addEventListener('click', () => modal.classList.remove('open'));
                contentWrapper.addEventListener('click', (e) => e.stopPropagation());
                modal.classList.toggle('open');
                ///
                //console.log(modal);
                $('#checkbox_all').prop('checked', filter.All);
                $('#checkbox_tennis').prop('checked', filter.Tennis);
                $('#checkbox_soccer').prop('checked', filter.Soccer);
                $('#checkbox_cricket').prop('checked', filter.Cricket);
            });
        }
        //checkbox
        $('.checkbox_item').change(function () {
            //alert('d');
            if($("#checkbox_cricket").is(':checked')==true && $("#checkbox_soccer").is(':checked')==true && $("#checkbox_tennis").is(':checked')==true){
                $("#checkbox_all").prop('checked',true);
            }
            else{
                $("#checkbox_all").prop('checked',false);
            }
        });
        $('#checkbox_all').change(function() {
            //alert('d');
            if($(this).is(":checked")) {
                $('#checkbox_tennis').prop('checked', true);
                $('#checkbox_soccer').prop('checked', true);
                $('#checkbox_cricket').prop('checked', true);
            }
            else{
                $('#checkbox_tennis').prop('checked', false);
                $('#checkbox_soccer').prop('checked', false);
                $('#checkbox_cricket').prop('checked', false);
            }


        });
        //button group
        $('.btn-group button').click(function () {
            //alert('sdf');
            var btn=$(this).text();
            $('.btn-group button').removeClass('active');
            $(this).addClass('active');
            switch (btn) {
                case 'In-Play':
                    $('#today_div').css('display','none');
                    $('#play_in').css('display','block')
                    //$('#tomorrow_div').css('display','none');
                    break;
                case 'Today':
                    $('#today_div').css('display','block');
                    $('#play_in').css('display','none');
                    //$('#tomorrow_div').css('display','none');
                    getEvent('today');
                    break;
                case 'Tomorrow':
                    $('#today_div').css('display','block');
                    $('#play_in').css('display','none');
                    //$('#tomorrow_div').css('display','block');
                    getEvent('tomorrow');
                    break;
                default:
                    break;
            }
        });
        function getEvent(date){
            var filter=[];
            if($("#checkbox_cricket").is(':checked')==true){
                filter.push('4');
            }
            if($("#checkbox_soccer").is(':checked')==true){
                filter.push('1');
            }
            if($("#checkbox_tennis").is(':checked')==true){
                filter.push('2');
            }
            //console.log(filter);
            $.ajax({
                url: 'https://odds24ex.com/api/getEvent',
                type: 'post',
                data: { filter:filter,date:date} ,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function(response){
                    //console.log(response);
                    var obj = JSON.parse(response);
                    console.log(obj);
                    var events=obj.data;
                    $('#today_div tbody').html('');
                    for (var i=0;i<events.length;i++){
                        var item=events[i];
                        var sport_name;
                        switch (item['sport_id']) {
                            case '1':
                                sport_name='Soccer';
                                break;
                            case '4':
                                sport_name='Cricket';
                                break;
                            case '2':
                                sport_name='Tennis';
                                break;
                            default:
                                break;
                        }

                        $('#today_div tbody').append('<tr>' +
                            '<td>' +
                            '<span>' +item['time']+
                            '</span>' +
                            '</td><td>' +
                            '<span class="path_span">'+sport_name+'</span>' +
                            '<a href="https://odds24ex.com/event/detail/'+item['id']+'?market_type=MATCH_ODDS'+'" style="padding: 0">' +
                            '<span class="item_span">'+JSON.parse(item['home'])['name']+'</span>' +
                            '<span class="item_span">v</span>' +
                            '<span class="item_span">'+JSON.parse(item["away"])['name']+'</span>' +
                            '</a></td></tr>');
                    }
                },
                error: function(response){
                    console.log(response);
                    //alert('error');
                }
            });
        }
        function timeConverter(UNIX_timestamp){
            var a = new Date(UNIX_timestamp * 1000);
            var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var year = a.getFullYear();
            var month = months[a.getMonth()];
            var date = a.getDate();
            var hour = a.getHours();
            var min = a.getMinutes();
            var sec = a.getSeconds();
            var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
            return time;
        }
        $('.modal-footer .action').click(function () {
            //alert($(this).text());
            var btn_text=$(this).text();
            switch (btn_text) {
                case 'Save':
                    //alert($(this).text());
                    filter['All']=$("#checkbox_all").is(':checked');
                    filter['Cricket']=$("#checkbox_cricket").is(':checked');
                    filter['Soccer']=$("#checkbox_soccer").is(':checked');
                    filter['Tennis']=$("#checkbox_tennis").is(':checked');
                    $('#trigger1').modal('hide');
                    if(filter['All']==true){
                        $('#span_cricket').css('display','inline');
                        $('#span_cricket').addClass('filter-item');
                        $('#span_soccer').css('display','inline');
                        $('#span_soccer').addClass('filter-item');
                        $('#span_tennis').css('display','inline');
                        //$('#span_tennis').addClass('filter-item');
                    }
                    else{
                        if (filter.Cricket==true){
                            $('#span_cricket').css('display','inline');
                            //$('#span_cricket').addClass('filter-item');
                        }
                        else{
                            $('#span_cricket').css('display','none');
                        }
                        if (filter.Soccer==true){
                            $('#span_soccer').css('display','inline');
                            $('#span_cricket').addClass('filter-item');
                            //$('#span_cricket').addClass('filter-item');
                        }
                        else{
                            $('#span_soccer').css('display','none');
                        }
                        if (filter.Tennis==true){
                            $('#span_tennis').css('display','inline');
                            $('#span_cricket').addClass('filter-item');
                            $('#span_soccer').addClass('filter-item');
                            //$('#span_cricket').addClass('filter-item');
                        }
                        else{
                            $('#span_tennis').css('display','none');
                            $('#span_soccer').removeClass('filter-item');
                            if (filter.Soccer==false){
                                //$('#span_soccer').css('display','inline');
                                $('#span_cricket').removeClass('filter-item');
                            }
                        }
                    }
                    break;
                case 'Cancel':
                    //alert($(this).text());
                    break;
            }
            $('#trigger1').removeClass('open');
        });



    </script>
    <script>



    </script>
@stop