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
        .content{padding-top: 85px}
        /******keyboard*******/
        ul.keyboard {list-style-type: none;margin-bottom: 1.86667vw;background-image: linear-gradient(-180deg, #32617F 20%, #1F4258 91%);display: flex;padding: 0;flex: 1;flex-wrap: wrap;}
        .keyboard li {border-right: 1px solid rgba(255, 255, 255, 0.15)}
        .char {flex: 1 1 16.66667%;font-size: 4vw;color: #1E1E1E;line-height: 10.4vw;background-color: #fff;border: 1px solid #aaa;height: 50px;}
        .backspace {flex: 0 1 14.66667vw;justify-content: center;align-items: center;color: #1E1E1E;line-height: 10.4vw;background-color: #fff;border: 1px solid #aaa;display: table;height: 100px;}
        .backspace span{display: table-cell;vertical-align: middle;}
        .string{flex: 1;width: 16px;margin: 5px 1px;color: #fff;line-height: 2.46;background-image: linear-gradient(-180deg, #32617F 20%, #1F4258 91%);}
        .keyboard .touch {background-color: #CA4200;}
        .modal-dialog {position: fixed;width: auto;bottom: 22%;}
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
    @if(isset($events))

    @foreach($events as $key=>$event)
        @php
            //var_dump(json_decode($item['Odds'],true)[0]['Bets']);
            $runners=json_decode($event->runners);
            $teams=json_decode($event->home,true)['name'].' v '.json_decode($event->away,true)['name'];
        @endphp
        <div style="display:flex;background-color: #274156;height: 50px;">
            <div id="{{$event->event_id.'_market'}}" class="set_market"><i class="fas fa-thumbtack"></i></div>
            <div style="width: 35%;text-align: right;color: white;font-size:1.2em;    margin: auto;padding-right: 20px;">
                <span>{{json_decode($event->home,true)['name']}}</span>
            </div>
            <div style="width: 30%;text-align: center;background-color: white;height: 90%;border-radius: 0px 0px 40px 40px;padding-top: 5px;">
                <span>vs</span>
            </div>
            <div style="width: 35%;text-align: left;color: white;font-size:1.2em;margin: auto;padding-left: 20px;">
                <span>{{json_decode($event->away,true)['name']}}</span>
            </div>
            <div class="refresh"><a href="{{url('mobile/event/detail/'.$event->event_id.'?market_type=MATCH_ODDS')}}"><i class="fas fa-angle-right" size="7x"></i></a></div>
            <div class="refresh"><i class="fas fa-sync-alt"></i></div>
        </div>
        <div style="margin-top: 20px" class="match_odds">
            <table class="table oddtable" style="background-color: transparent;">
                <thead>
                <tr>
                    <th>selections</th>
                    <th style="text-align: right;padding: 0;">
                        <div style="border-radius: 20px 0px 0px 0px;text-align: center;background-color: #1fda1f;width: 60px;margin-right: 0px;margin-left: auto;">
                            Back
                        </div>
                    </th>
                    <th style="text-align: left;padding: 0;">
                        <div style="border-radius: 0px 20px 0px 0px;text-align: center;background-color: #da7d7a;width: 60px;margin-right: auto;margin-left: 0px;">
                            Lay
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody style="background-color: white">
                @foreach($runners as $item)
                    @if(isset($item->exchange))
                        <tr>
                            <td style="text-align: left;"><li>{{$item->description->runnerName}}</li></td>
                            <td style="width: 60px;height: 40px;padding: 2px">
                                <div class="selectTemp" style="width: 60px!important;height: 40px!important;">
                                    @for($i=0;$i>=0;$i--)
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
                            <td style="width: 60px;height: 40px;padding: 2px">
                                <div class="selectTemp" style="width: 60px!important;height: 40px!important;">
                                    @for($i=0;$i<=0;$i++)
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
    @endif
    <!-- The Modal -->
    <div class="modal fade" id="myModal" style="padding-top: 30%">
        <div class="modal-dialog modal-dialog-centered">
            <div  class="modal-content">
                <div class="modal-header">
                    <span id="runner_name"></span>
                </div>
                <div>
                    <div style="display: flex;padding: 20px">
                        <div class="input-group">
                            <input id="fixtureid" name="fixtureid" class="form-control" type="hidden" >
                            <input id="betname" name="betname" class="form-control" type="hidden">
                            <span class="input-group-addon" onclick="change_value('odds','in','0.01')">
                              +
                            </span>
                            <input id="odds" name="odds" class="form-control" type="text" placeholder="1.00" value="0" readonly="readonly">
                            <span class="input-group-addon" onclick="change_value('odds','de','0.01')">
                              -
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" onclick="change_value('stake','in','1')">
                              +
                            </span>
                            <input id="stake" name="stake" class="form-control" type="text" placeholder="100" value="0" readonly="readonly">
                            <span class="input-group-addon" onclick="change_value('stake','de','1')">
                              -
                            </span>
                        </div>
                    </div>
                </div>
                <div id="virtualkeyboard" class="">
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
                </div>
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
    <script type="text/javascript">
        $('.footer #multiMarket').addClass('footer_active');
        document.onkeydown = function (e) {
            return false;
        }
    </script>
    <script>
        $('.selectTemp .betting_item').click(function () {
            //console.log();
            var runnerName=$(this).children('#runnerName').val();
            var runnerId=$(this).children('#runnerId').val();
            var eventId=$(this).children('#eventId').val();
            var odd=$(this).children('#odd').val();
            var market_type=$(this).children('#market_type').val();
            var market_name=$(this).children('#market_name').val();
            var teams=$(this).children('#teams').val();
            var bet_type=$(this).children('#bet_type').val();
            $('#myModal').modal();
                var uid='{!!isset(Auth::user()->id)?Auth::user()->id:0!!}';
            $('#fixtureid').val(eventId);
            $('#betname').val(runnerId);
            $('#odds').val(odd);
            $('#stake').val('100');
            $('#runner_name').text('runnerName');
                $( ".odds" ).on("change paste keyup", function() {
                    //console.log( $(this).val() );
                    var stack=$(this).parents().children('.item20').children('.stake').val();
                    $(this).parents().children('.itemright').children('.price').text(($(this).val()*stack).toFixed(2));
                    calctotalprice();

                });
                $( ".stake" ).on("change paste keyup", function() {
                    //console.log( $(this).val() );
                    var odds=$(this).parents().children('.item20').children('.odds').val();
                    $(this).parents().children('.itemright').children('.price').text(($(this).val()*odds).toFixed(2));
                    calctotalprice();
                });

            //console.log($('#betSlipBoard').children().length);

        });

        //place bet
        $('#placebets').click(function () {
            //alert('d');
            if($('#confirm').prop("checked") == true){
                //alert("Checkbox is checked.");
                var sum=0.0;
                var senddata=[];
                for (var i=0;i<$('#betSlipBoard').children().length;i++){
                    //console.log($('#betSlipBoard').children().eq(i).html());
                    var price=$('#betSlipBoard').children().eq(i).children('.bet_input').children('.itemright').children('.price').text();
                    sum+=parseFloat(price);
                    var fixtureid=$('#betSlipBoard').children().eq(i).prop('id').split("_")[0];
                    var betname=$('#betSlipBoard').children().eq(i).prop('id').split("_")[1];
                    var odds=$('#betSlipBoard').children().eq(i).children('.bet_input').children('.item20').children('.odds').val();
                    var stake=$('#betSlipBoard').children().eq(i).children('.bet_input').children('.item20').children('.stake').val();
                    var data={};
                    data['FixtureId']=fixtureid;
                    data['betname']=betname;
                    data['odd']=odds;
                    data['stake']=stake;
                    data['price']=price;
                    senddata.push(data);
                }
                //console.log(senddata);
                var uid='{!!isset(Auth::user()->id)?Auth::user()->id:0!!}';
                if (uid){
                    $.ajax({
                        url: '{{url("/api/addBetting")}}',
                        type: 'post',
                        data: { data:senddata,userid:uid} ,
                        beforeSend: function (request) {
                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                        },
                        success: function(response){
                            //console.log(response);
                            var obj = JSON.parse(response);
                            alert(obj.message);
                            //$('#charge_dlg').modal('toggle');
                            console.log(obj);
                            //window.location.replace('{{url('challenges/my')}}');

                        },
                        error: function(response){
                            console.log(response);
                            //alert('error');
                        }
                    });
                }
                else{
                    alert('Please Login');
                }
                //
                $('#total_price').text(sum.toFixed(2));
            }
            else{
                alert("Please confirm your bets.");
            }
        });
        $('#cancelall').click(function () {
            $('#myModal').modal('toggle');

        });
    </script>

@stop