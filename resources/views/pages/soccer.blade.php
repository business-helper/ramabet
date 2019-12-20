@extends('Layout.page')
@section('head')

@stop
@section('left_content')
    <div id="pathbackUI" style="">
        <div class="path_item">
            <div class="dropdown">
                <div class="dropdown-toggle" type="button" data-toggle="dropdown" style="display: flex">Sports
                    <span class="caret" style="margin-top: 9px"></span>
                </div>
                <ul class="dropdown-menu">
                    <li><a href="{{url('/')}}">Sports</a></li>
                </ul>
            </div>
        </div>
        <div class="path_item">
            <svg height="10" width="10">
                <polyline points="0,0 5,5 0,10 " style="fill:none;stroke:#ffffff;stroke-width:1" />
                <polyline points="5,0 10,5 5,10 " style="fill:none;stroke:#ffffff;stroke-width:1" />
                Sorry, your browser does not support inline SVG.
            </svg>
            Soccer
        </div>
    </div>
    @php
        ini_set('memory_limit', '-1');
        //echo var_dump($jsondata['Body']['InPlayEvents']);
        $leaueArry=array();
        foreach($data as $item){
                array_push($leaueArry,$item->league);
        }
           //print_r(array_merge(array_unique($leaueArry)));
           $leaguearry=array_merge(array_unique($leaueArry));
    @endphp
    <div class="list-group">

        @for($i=0;$i<count($leaguearry);$i++)
            <a href="javascript:getLeague({{json_decode($leaguearry[$i],true)['id']}},{{json_encode($data)}})" class="list-group-item">{{json_decode($leaguearry[$i],true)['name']}}</a>
        @endfor
    </div>
@stop
@section('content')
    <div style="padding-left: 10px;padding-right: 10px">
        <div style="width: 100%;height: 200px;background-size: cover ;background-image: url('{{asset('img/'.$general_setting['soccer_image'])}}')">
        </div>
        <div class="table_div" style="padding: 10px">
            <div class="title">Highlights</div>
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
                @foreach($data as $item)
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