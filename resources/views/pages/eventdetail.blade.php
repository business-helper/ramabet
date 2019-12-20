@extends('Layout.page')
@section('head')

    <style>
        .tab-pane{background-color: #e1e1e1!important;}


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
        @php
            $markets=$apidata->markets;
            $market_type=app('request')->input('market_type');
            $seleted_market=$markets[0];
            foreach ($markets as $item){
                if ($item->market->marketType==$market_type){
                    $seleted_market=$item;
                    break;
                }

            }
        @endphp
        @foreach($markets as $item)
        <a href="{{url('/event/detail/'.$apidata->event->eventId.'?market_type='.$item->market->marketType)}}" class="list-group-item">{{$item->market->marketName}}</a>
        @endforeach
    </div>
@stop
@section('content')
    @php
        //var_dump(json_decode($item['Odds'],true)[0]['Bets']);
            //$data1=json_decode(json_encode($apidata),true);
            //$data=json_decode($item['Odds'],true);
            //var_dump(json_decode($item['Participants'],true)[0]['Name']);
            //var_dump($apidata->event->name);
            $teams=explode("v",$apidata->event->name);
    @endphp
    <div style="padding-left: 10px;padding-right: 10px;">
        <div style="display:flex;background-color: #274156;height: 50px;">
            <div id="{{$apidata->event->eventId.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
            <div style="width: 35%;text-align: right;color: white;font-size:1.5em;    margin: auto;padding-right: 20px;">
                <span>{{$teams[0]}}</span>
            </div>
            <div style="width: 30%;text-align: center;background-color: white;height: 90%;border-radius: 0px 0px 40px 40px;padding-top: 5px;">
                <span>{{$seleted_market->market->marketName}}</span><br>
                <span>vs</span>
            </div>
            <div style="width: 35%;text-align: left;color: white;font-size:1.5em;margin: auto;padding-left: 20px;">
                <span>{{$teams[1]}}</span>
            </div>
            <div id="{{$apidata->event->eventId.'_market'}}" class="set_market"><i class="fas fa-sync-alt"></i></div>
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
                @foreach($event['runners'] as $item)
                    @if(isset($item->exchange) && count($item->exchange)>0)
                    <tr>
                        <td><li>{{$item->description->runnerName}}</li></td>
                        <td style="width: 180px;height: 40px;padding: 2px">
                            <div class="selectTemp" style="width: 180px!important;height: 40px!important;">
                            @for($i=2;$i>=0;$i--)
                                @if(isset($item->exchange->availableToBack) && isset(json_decode(json_encode($item->exchange->availableToBack),true)[$i]))
                                    <div id="{{$apidata->event->eventId}}_{{$seleted_market->description->marketType}}_{{$item->selectionId}}_{{$i==0?'':'prev_'}}availableToBack_item" class="left_item {{$i==0?'betting_item':''}}" >
                                        <p>{{json_decode(json_encode($item->exchange->availableToBack),true)[$i]['price']}}</p>
                                        <span>{{json_decode(json_encode($item->exchange->availableToBack),true)[$i]['size']}}</span>
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
                                    <div id="{{$apidata->event->eventId}}_{{$item->selectionId}}_item" class="deactive">
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
                                        <div id="{{$apidata->event->eventId}}_{{$seleted_market->description->marketType}}_{{$item->selectionId}}_availableToLay_item" class="right_item {{$i==0?'betting_item':''}}">
                                            <p>{{$runner[$i]['price']}}</p>
                                            <span>{{$runner[$i]['size']}}</span>
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
                                        <div id="{{$apidata->event->eventId}}_{{$item->selectionId}}_item" class="deactive">
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
        <div class="row">
            @if(isset($apidata->event))
                @php
                    $dt=new DateTime($apidata->event->openDate);
                @endphp
                <h4 style="text-align: center;" id="">Start Time:{{$dt->format('Y-m-d H:i:s')}}</h4>
            @endif

            @php
                $dt=Carbon\Carbon::now();
            @endphp
            <h4 style="text-align: center;" id="">Current Time:{{$dt->format('Y-m-d H:i:s')}}</h4>
        </div>
        <ul class="nav nav-tabs" style="margin-bottom: 10px;border-bottom: double;">
            <li class="active"><a data-toggle="tab" href="#popular">Popular</a></li>
            <li><a data-toggle="tab" href="#goals">Goals</a></li>
        </ul>

        <div class="tab-content" style="background-color: white">
            <div id="popular" class="tab-pane fade in active">
                <div class="row">
                    @foreach ($markets as $seleted_market)
                        <div class="col-sm-6">
                            {{--@if ($item->market->marketType==$market_type)
                                @endif--}}
                            @if(substr_count($seleted_market->market->marketName, 'Goal')==0)
                            <div style="background-color: #284257;color: white;padding-left: 10px">{{$seleted_market->market->marketName}}</div>
                            <table class="table oddtable" style="background-color: transparent;">
                                <thead style="background-color: #CED5DA;">
                                <tr>
                                    <th>selections</th>
                                    <th style="text-align: right;padding: 0;">
                                        <div style="border-radius: 20px 0px 0px 0px;text-align: center;margin-right: 0px;margin-left: auto;">
                                            Back
                                        </div>
                                    </th>
                                    <th style="text-align: left;padding: 0;">
                                        <div style="border-radius: 0px 20px 0px 0px;text-align: center;margin-right: auto;margin-left: 0px;">
                                            Lay
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody style="background-color: white">
                                @foreach($seleted_market->runners as $item)
                                    @if(isset($item->exchange) && count($item->exchange)>0)
                                        <tr>
                                            <td><li>{{$item->description->runnerName}}</li></td>
                                            <td style="width: 60px;height: 40px;padding: 2px">
                                                <div class="selectTemp" style="width: 60px!important;height: 40px!important;">
                                                    @for($i=0;$i<=0;$i++)
                                                        @if(isset($item->exchange->availableToBack) && isset(json_decode(json_encode($item->exchange->availableToBack),true)[$i]))
                                                            @php
                                                                $runner=array_reverse(json_decode(json_encode($item->exchange->availableToBack),true),true);
                                                            @endphp
                                                            <div id="{{$apidata->event->eventId}}_{{$seleted_market->description->marketType}}_{{$item->selectionId}}_availableToBack_item" class="left_item betting_item">
                                                                <p>{{$runner[$i]['price']}}</p>
                                                                <span>{{$runner[$i]['size']}}</span>
                                                                <input id="eventId" type="hidden" value="{{$apidata->event->eventId}}">
                                                                <input id="runnerName" type="hidden" value="{{$item->description->runnerName}}">
                                                                <input id="runnerId" type="hidden" value="{{$item->description->metadata->runnerId}}">
                                                                <input id="odd" type="hidden" value="{{$runner[$i]['price']}}">
                                                                <input id="market_type" type="hidden" value="{{$seleted_market->description->marketType}}">
                                                                <input id="market_name" type="hidden" value="{{$seleted_market->description->marketName}}">
                                                                <input id="teams" type="hidden" value="{{$apidata->event->name}}">
                                                                <input id="bet_type" type="hidden" value="availableToBack">
                                                            </div>
                                                        @else
                                                            <div id="{{$apidata->event->eventId}}_{{$item->selectionId}}_item" class="deactive">
                                                                --
                                                            </div>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </td>
                                            <td style="width: 60px;height: 40px;padding: 2px">
                                                <div class="selectTemp" style="width: 60px!important;height: 40px!important;">
                                                    @for($i=0;$i<=0;$i++)
                                                        @if(isset($item->exchange->availableToLay) && isset(json_decode(json_encode($item->exchange->availableToLay),true)[$i]))
                                                            @php
                                                                $runner=array_reverse(json_decode(json_encode($item->exchange->availableToLay),true));
                                                            @endphp
                                                            <div id="{{$apidata->event->eventId}}_{{$seleted_market->description->marketType}}_{{$item->selectionId}}_availableToLay_item" class="right_item betting_item" >
                                                                <p>{{$runner[$i]['price']}}</p>
                                                                <span>{{$runner[$i]['size']}}</span>
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
                                                            <div id="{{$apidata->event->eventId}}_{{$item->selectionId}}_item" class="deactive">
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
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="goals" class="tab-pane fade">
                {{--<h3 style="text-align: center;" id="">Game Score:{{$apidata->ss}}</h3>--}}
                <div class="row">
                    @foreach ($markets as $seleted_market)
                        <div class="col-sm-6">
                            {{--@if ($item->market->marketType==$market_type)
                                @endif--}}
                            @if(substr_count($seleted_market->market->marketName, 'Goal')>0)
                                <div style="background-color: #284257;color: white;padding-left: 10px">{{$seleted_market->market->marketName}}</div>
                                <table class="table oddtable" style="background-color: transparent;">
                                    <thead style="background-color: #CED5DA;">
                                    <tr>
                                        <th>selections</th>
                                        <th style="text-align: right;padding: 0;">
                                            <div style="border-radius: 20px 0px 0px 0px;text-align: center;margin-right: 0px;margin-left: auto;">
                                                Back
                                            </div>
                                        </th>
                                        <th style="text-align: left;padding: 0;">
                                            <div style="border-radius: 0px 20px 0px 0px;text-align: center;margin-right: auto;margin-left: 0px;">
                                                Lay
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody style="background-color: white">
                                    @foreach($seleted_market->runners as $item)
                                        @if(isset($item->exchange) && count($item->exchange)>0)
                                            <tr>
                                                <td><li>{{$item->description->runnerName}}</li></td>
                                                <td style="width: 60px;height: 40px;padding: 2px">
                                                    <div class="selectTemp" style="width: 60px!important;height: 40px!important;">
                                                        @for($i=0;$i<=0;$i++)
                                                            @if(isset($item->exchange->availableToBack) && isset(json_decode(json_encode($item->exchange->availableToBack),true)[$i]))
                                                                @php
                                                                    $runner=array_reverse(json_decode(json_encode($item->exchange->availableToBack),true),true);
                                                                @endphp
                                                                <div id="{{$apidata->event->eventId}}_{{$seleted_market->description->marketType}}_{{$item->selectionId}}_availableToBack_item" class="left_item betting_item">
                                                                    <p>{{$runner[$i]['price']}}</p>
                                                                    <span>{{$runner[$i]['size']}}</span>
                                                                    <input id="eventId" type="hidden" value="{{$apidata->event->eventId}}">
                                                                    <input id="runnerName" type="hidden" value="{{$item->description->runnerName}}">
                                                                    <input id="runnerId" type="hidden" value="{{$item->description->metadata->runnerId}}">
                                                                    <input id="odd" type="hidden" value="{{$runner[$i]['price']}}">
                                                                    <input id="market_type" type="hidden" value="{{$seleted_market->description->marketType}}">
                                                                    <input id="market_name" type="hidden" value="{{$seleted_market->description->marketName}}">
                                                                    <input id="teams" type="hidden" value="{{$apidata->event->name}}">
                                                                    <input id="bet_type" type="hidden" value="availableToBack">
                                                                </div>
                                                            @else
                                                                <div id="{{$apidata->event->eventId}}_{{$item->selectionId}}_item" class="deactive">
                                                                    --
                                                                </div>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </td>
                                                <td style="width: 60px;height: 40px;padding: 2px">
                                                    <div class="selectTemp" style="width: 60px!important;height: 40px!important;">
                                                        @for($i=0;$i<=0;$i++)
                                                            @if(isset($item->exchange->availableToLay) && isset(json_decode(json_encode($item->exchange->availableToLay),true)[$i]))
                                                                @php
                                                                    $runner=array_reverse(json_decode(json_encode($item->exchange->availableToLay),true));
                                                                @endphp
                                                                <div id="{{$apidata->event->eventId}}_{{$seleted_market->description->marketType}}_{{$item->selectionId}}_availableToLay_item" class="right_item betting_item" >
                                                                    <p>{{$runner[$i]['price']}}</p>
                                                                    <span>{{$runner[$i]['size']}}</span>
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
                                                                <div id="{{$apidata->event->eventId}}_{{$item->selectionId}}_item" class="deactive">
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
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
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