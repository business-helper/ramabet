
@extends('Layout.mobile.page')
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
        .table>tbody>tr>td{vertical-align: middle}
        .nav-tabs .active a{
            background: #757175;
            background: -moz-linear-gradient(top, #757175 0%, #000000 100%);
            background: -webkit-linear-gradient(top, #757175 0%, #000000 100%);
            background: linear-gradient(to bottom, #757175 0%, #000000 100%);
            color: #FFA40C!important;
        }
        .nav-tabs li a{font-weight: bold;font-size: 15px;background-color: #FFA40C!important;background: #FFA40C;background: -moz-linear-gradient(top, #FFA40C 0%, #FFA40C 100%);background: -webkit-linear-gradient(top, #FFA40C 0%, #FFA40C 100%);background: linear-gradient(to bottom, #FFA40C 0%, #FFA40C 100%);color: black!important;border: 0!important;padding-top: 5px;padding-bottom: 5px;}
        .nav-tabs li a span{font-size: 20px;}
        .nav-tabs li{margin-bottom: 0px;!important;}
        .active_market{background-color: #3ce97b!important;}
        .content{padding-top: 85px}
        /******keyboard*******/
        ul.keyboard {list-style-type: none;margin-bottom: 1.86667vw;background-image: linear-gradient(-180deg, #32617F 20%, #1F4258 91%);display: flex;padding: 0;flex: 1;flex-wrap: wrap;}
        .keyboard li {border-right: 1px solid rgba(255, 255, 255, 0.15)}
        .char {flex: 1 1 16.66667%;font-size: 18px;color: #1E1E1E;background-color: #fff;border: 1px solid #aaa;height: 50px;padding-top: 15px;}
        .backspace {flex: 0 1 14.66667vw;justify-content: center;align-items: center;color: #1E1E1E;line-height: 10.4vw;background-color: #fff;border: 1px solid #aaa;display: table;height: 100px;}
        .backspace span{display: table-cell;vertical-align: middle;}
        .string{flex: 1;width: 16px;margin: 5px 1px;color: #fff;line-height: 2.46;background-image: linear-gradient(-180deg, #32617F 20%, #1F4258 91%);}
        .keyboard .touch {background-color: #CA4200;}
        .modal-dialog {position: fixed;width: auto;bottom: 22%;}
        .list-group{display: flex;overflow: auto;height: 30px;}
        .list-group a span{    white-space: nowrap;
            overflow: hidden;
            padding-right: 20px;font-size: 14px;
            color:white;
        }
        a.list-group-item, button.list-group-item {
            color: #555;
            background: -webkit-linear-gradient(top, #757175 0%, #000000 100%);
            cursor: pointer;
        }
        .list-group-item {
            padding: 3px 0 0 15px!important;
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
            /*height: 25px;!important;*/
            vertical-align: .3em;!important;
        }
        .footer p{
            margin:0;!important;
            margin-top:-20px;!important;
        }
        .modal-dialog {
            position: relative;!important;
            max-width: 500px;!important;
            bottom: 22%;!important;
            margin: auto;!important;
            margin-top: -70px;
        }
        @media only screen and (max-width: 650px) {
            .modal-dialog {
                margin-top:100px;
            }
            }
        .content {
            padding-top: 70px;!important;
        }
        .nav-tabs .active a {
            background: linear-gradient(to bottom, #fb7474 0%, #f70808 100%);
            color: #fff!important;
        }
        .nav-tabs li a {
            /* font-weight: bold; */
            /* font-size: 15px; */
            /* background-color: #FFA40C!important; */
            /* background: #FFA40C; */
            background: -moz-linear-gradient(top, #FFA40C 0%, #FFA40C 100%);
            /* background: -webkit-linear-gradient(top, #FFA40C 0%, #FFA40C 100%); */
            background: linear-gradient(to bottom, #fff 0%, #ddd 100%);
            color: #f30303!important;
            /* border: 0!important; */
            /* padding-top: 5px; */
            /* padding-bottom: 5px; */
        }
        .nav-tabs li{
            width:90px;!important;
        }
        .itemleft{width:60%;text-align: left;}
        .item20{width: 50%;text-align: center!important;
        }
        .itemright{width: 50%;text-align: right}
        .betslip_close{
            padding: 2px 2px;
            font-size: 11px;
            width: 20px;
            height: 20px;
        }
        .input-group-addon{
            padding: 6px 4px!important;
        }
        .betslip_btn{
            width: 20%;
            margin: 1px;
            background-image: linear-gradient(-180deg, #32617F 20%, #1F4258 91%)!important;
        }
    </style>

@stop

@section('content')

    @php
            $teams=explode("v",$apidata->event->name);
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
    <div class="list-group">
        @foreach($markets as $item)
            @if (!isset($item->market->marketName))
                @continue
            @endif
            <a href="{{url('mobile/event/detail/'.$apidata->event->eventId.'?market_type='.$item->market->marketType)}}" class="list-group-item"><span>{{$item->market->marketName}}</span></a>
        @endforeach
    </div>
    <div style="padding-left: 10px;padding-right: 10px;">
        <div style="display:flex;background-color: #274156;height: 50px;">
            <div id="{{$apidata->event->eventId.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
            <div style="width: 35%;text-align: right;color: white;font-size:1.2em;    margin: auto;padding-right: 20px;">
                <span>{{$teams[0]}}</span>
            </div>
            <div style="width: 30%;text-align: center;background-color: white;height: 90%;border-radius: 0px 0px 40px 40px;padding-top: 5px;">
                <span>{{$seleted_market->market->marketName}}</span><br>
                <span>vs</span>
            </div>
            <div style="width: 35%;text-align: left;color: white;font-size:1.2em;margin: auto;padding-left: 20px;">
                <span>{{$teams[1]}}</span>
            </div>
            <div class="refresh"><i class="fas fa-sync-alt"></i></div>
        </div>
        <div style="margin-top: 20px" class="match_odds">
            <table class="table oddtable" style="background-color: transparent;">
                <thead>
                <tr>
                    <th>selections</th>
                    <th style="text-align: right;padding: 0;">
                        <div style="border-radius: 10px 0px 0px 0px;text-align: center;background: -webkit-linear-gradient(top, greenyellow 0%, limegreen 100%);width: 60px;margin-right: 0px;margin-left:15px;color: #fff;font-weight: lighter;">
                            Back all
                        </div>
                    </th>
                    <th style="text-align: left;padding: 0;">
                        <div style="border-radius: 0px 10px 0px 0px;text-align: center;background: -webkit-linear-gradient(top, pink 0%, orangered 100%);width: 60px;margin-right: auto;margin-left: 0px;color: #fff;font-weight: lighter;">
                            Lay all
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody style="background-color: white">
                @foreach($seleted_market->runners as $item)
                    @if(isset($item->exchange) )
                        <tr>
                            <td><li>{{$item->description->runnerName}}</li></td>
                            <td style="width: 60px;height: 40px;padding: 2px">
                                <div class="selectTemp" style="width: 60px!important;height: 40px!important;">
                                    @for($i=0;$i>=0;$i--)
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
                            <td style="width: 60px;height: 40px;padding: 2px">
                                <div class="selectTemp" style="width: 60px!important;height: 40px!important;">
                                    @for($i=0;$i<=0;$i++)
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

            @if(isset($apidata->event))
                @php
                    $dt=new DateTime($apidata->event->openDate);
                @endphp
            <div style="width: 70%;min-width:300px;height: 35px;background-color: white;margin: auto;border-radius: 17.5px;box-shadow: 0 0 8px #274156;border: 1px solid #274156;">
                <h4 style="text-align: center;font-size:14px;" id="">Start Time: {{$dt->format('Y-m-d H:i:s')}}</h4>
            </div>
            @endif


            @php
                $dt=Carbon\Carbon::now();
            @endphp
        <div style="width: 70%;min-width:300px;height: 35px;background-color: white;margin: auto;margin-top:10px;margin-bottom:20px;border-radius: 17.5px;box-shadow: 0 0 8px #274156;border: 1px solid #274156;">
            <h4 style="text-align: center;font-size: 14px;" id="">Current Time: {{$dt->format('Y-m-d H:i:s')}}</h4>
        </div>
       {{-- <ul class="nav nav-tabs" style="margin-bottom: 10px;border-bottom: double;">
            <li class="active"><a data-toggle="tab" href="#popular">Popular</a></li>
            <li><a data-toggle="tab" href="#goals">Goals</a></li>
        </ul>

        <div class="tab-content" style="background-color: white">
            <div id="popular" class="tab-pane fade in active">
                <div class="row">
                    @foreach ($markets as $seleted_market)
                        @if (!isset($seleted_market->market->marketName))
                            @continue
                        @endif

                        <div class="col-sm-12">
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
                                        @if(isset($item->exchange) )
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
                --}}{{--<h3 style="text-align: center;" id="">Game Score:{{$apidata->ss}}</h3>--}}{{--
                <div class="row">
                    @foreach ($markets as $seleted_market)
                        @if (!isset($seleted_market->market->marketName))
                            @continue
                        @endif
                        <div class="col-sm-12">
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
                                        @if(isset($item->exchange) )
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
        </div>--}}
    </div>




    <!-- The Modal -->
    <div class="modal fade" id="myModal" style="padding-top: 30%">
        <div class="modal-dialog modal-dialog-centered">
            <div  class="modal-content">
                <div style="padding: 5px" class="betslip_item">
                    <input id="eventId" name="eventId" class="form-control" type="hidden" value="1">
                    <input id="runnerId" name="runnerId" class="form-control" type="hidden">
                    <input id="market_type" name="market_type" class="form-control" type="hidden">
                    <input id="bet_type" name="bet_type" class="form-control" type="hidden">
                    <input id="market_name" name="market_name" class="form-control" type="hidden">
                    <input id="runnerName" name="runnerName" class="form-control" type="hidden">
                    <input id="teams" name="teams" class="form-control" type="hidden">
                    {{--<div style="text-align: left;padding-left: 10px">
                        <div style="background-color: #72BAEE;width: 12px;height: 12px; margin-right: 4px; float: left;"></div>
                        <span>(Bet For)</span>
                    </div>--}}
                    {{--<div class="part_teams" style="text-align: left;padding-left: 10px">Bangladesh v West Indies</div>--}}
                    <div style="padding: 5px">
                        <div class="" style="padding-left: 5px;text-align: left">Bangladesh<span style="float: right;">Match Odds</span></div>
                        <div class="backSlipHeader" style="display: flex;">
                            <div class="item20">
                                <div style="padding-left:10px;width: 100%;text-align: left">Odds</div>
                                <div class="item20 input-group" style="padding:5px;width: 100%">
                                    <span class="input-group-addon" onclick="change_value('odds','in','0.01')">+</span>
                                    <input id="odds" name="odds" class="form-control" type="text" placeholder="1.00" value="0">
                                    <span class="input-group-addon" onclick="change_value('odds','de','0.01')">-</span>
                                </div>
                            </div>
                            <div class="item20">
                                <div style="padding-left:10px;width: 100%;text-align: left">Stake</div>
                                <div class="item20 input-group" style="padding:5px;width: 100%">
                                    <span class="input-group-addon" onclick="change_value('stake','in','1')">+</span>
                                    <input id="stake" name="stake" class="form-control" type="text" placeholder="100" value="0">
                                    <span class="input-group-addon" onclick="change_value('stake','de','1')">-</span>
                                </div>
                            </div>
                            {{--<div class="item20">
                                <div>profit</div>
                                <div class="" style="line-height: 34px;width: 100%"><span>$</span><span class="price">0</span></div>
                            </div>--}}
                            {{--<div style="align-self: center; flex: 1; text-align: right;">
                                <div class="btn btn-danger betslip_close" data-value="29278799_MATCH_ODDS_7659_availableToBack_item"><i class="fas fa-times"></i></div>
                            </div>--}}
                        </div>
                        <div class="bet_input" style="display: flex;background-color:#fff; padding: 5px;flex-flow: wrap;    justify-content: space-between;">
                            <div class="btn btn-danger betslip_btn" data-value="10">+10</div>
                            <div class="btn btn-danger betslip_btn" data-value="20">+20</div>
                            <div class="btn btn-danger betslip_btn" data-value="50">+50</div>
                            <div class="btn btn-danger betslip_btn" data-value="100">+100</div>
                            <div class="btn btn-danger betslip_btn" data-value="200">+200</div>
                            <div class="btn btn-danger betslip_btn" data-value="500">+500</div>
                            <div class="btn btn-danger betslip_btn" data-value="100">MAX</div>
                            <div class="clear" style="width: 20%; margin: 1px;"><button id="clear-set" onclick="clearfunction()" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);width: 100%;height: 26px;margin-top:2px;border:1px solid lightgreen;border-radius:4px;background-color:lightgreen;">Reset</button></div>
                        </div>
                    </div>
                </div>
                {{--<div style="display: flex;padding: 20px">
                    <div class="input-group">
                        <input id="eventId" name="eventId" class="form-control" type="hidden" value="1">
                        <input id="runnerId" name="runnerId" class="form-control" type="hidden">
                        <input id="market_type" name="market_type" class="form-control" type="hidden">
                        <input id="bet_type" name="bet_type" class="form-control" type="hidden">
                        <input id="market_name" name="market_name" class="form-control" type="hidden">
                        <input id="runnerName" name="runnerName" class="form-control" type="hidden">
                        <input id="teams" name="teams" class="form-control" type="hidden">
                        <span class="input-group-addon" onclick="change_value('odds','in','0.01')">
                              +
                            </span>
                        <input id="odds" name="odds" class="form-control" type="text" placeholder="1.00" value="0">
                        <span class="input-group-addon" onclick="change_value('odds','de','0.01')">
                              -
                            </span>
                    </div>
                    <div class="input-group">
                            <span class="input-group-addon" onclick="change_value('stake','in','1')">
                              +
                            </span>
                        <input id="stake" name="stake" class="form-control" type="text" placeholder="100" value="0">
                        <span class="input-group-addon" onclick="change_value('stake','de','1')">
                              -
                            </span>
                    </div>
                </div>--}}
                {{--<div id="virtualkeyboard" class="">
                    <div class="">
                        <ul class="keyboard">
                            <li class="string">10</li>
                            <li class="string">30</li>
                            <li class="string">50</li>
                            <li class="string">200</li>
                            <li class="string">500</li>
                            <li class="string">1000</li>
                        </ul>
                    </div>
                    <div style="display: flex;">
                        <ul class="keyboard">
                            <li class="char">1</li>
                            <li class="char">2</li>
                            <li class="char">3</li>
                            <li class="char">4</li>
                            <li class="char">5</li>
                            <li class="char">6</li>
                            <li class="char">7</li>
                            <li class="char">8</li>
                            <li class="char">9</li>
                            <li class="char">0</li>
                            <li class="char">00</li>
                            <li class="char">.</li>
                        </ul>
                        <div class="backspace last" ><span class="glyphicon glyphicon-arrow-left"></span></div>
                    </div>
                </div>--}}
                <!-- Modal footer -->
                <div class="modal-footer">
                    <div id="betSlipFooter" style="">
                        <div style="display: flex;margin-top: 10px">
                            <button id="cancelall" class="btn second" style="margin-right: auto;">Cancel</button>
                            <button id="placebets" class="btn third">Place Bets</button>
                        </div>
                        <div style="text-align: left">
                            <input id="confirm" type="checkbox" value="Please confirm your bets.">
                            <label for="confirm">Please confirm your bets.</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop

@section('script')
<script>
    function clearfunction() {
        document.getElementById('stake').value = "0";
    }
    $(document).on('click','.betslip_btn', function(){
        var value = $(this).data('value');
        var stake=$('#stake').val();
        $('#stake').val(parseFloat(stake)+parseFloat(value));
        //stake=$('#stake').val();
        /*var odds=$('#stake').val();
        item.find('.price').text((stake*odds).toFixed(2));
        calctotalprice();*/
        //betslipesave();
        //console.log(stake);
    });
</script>
@stop