<balance></balance>
<div id="tabs" style="height: 78%;">
    <ul class="nav nav-tabs" id="myTab">
        <li class="betslipe_tab active">
            <a data-toggle="tab" href="#betsipe">Bet slip</a>
        </li>
        <li class="open_bets_tab">
            <a data-toggle="tab" href="#openbet">Open Bets</a>
        </li>
    </ul>
    <div class="tab-content" style="background-color: white;
    min-height: 100px;overflow-y: auto;height: 100%">
        <div id="betsipe" class="tab-pane fade in active">
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
        </div>

        <div id="openbet" class="tab-pane fade">
            <label>
                <input type="checkbox" data-ng-model="$parent.Showbetslipdetails" data-ng-click="Showbetslipdetailsfn()" class="ng-pristine ng-untouched ng-empty ng-valid">Show bet Info </label>
            <a for="collapseTwo" data-toggle="collapse" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="btn toggleable-list-title" style="width: 100%;background-color: #06446c;color: #fff;border-radius: 0;padding: 0;">
                <span style="font-size: 12px; font-weight: 700;">
                    <strong>Unmatched Bets</strong>
                    {{--<span class="value ng-binding">100.00</span>--}}
                </span>
                <span class="arrow"><i class="fas"></i></span>
            </a>
            <div id="collapseTwo" class="collapse in show" style="background: rgb(255, 255, 255);  font-size: 12px;">
                @if(count($bet_data['unmatched_bet'])==0)
                    <div class="nodata">
                        <strong>You have no unmatched bets</strong>
                        <span style="color: #2aa033;"></span>
                    </div>
                @else
                    @php
                        $pre_team='';
                    @endphp
                    @for($i=0;$i<count($bet_data['unmatched_bet']);$i++)
                        @php
                            $bet_item=$bet_data['unmatched_bet'][$i];
                        @endphp
                        @if($pre_team!=$bet_item->teams)
                            <div id="{{$bet_item->eventId}}_bets" class="open_bets" style="">
                                <div class="part_teams" style="text-align: left;padding-left: 5px;margin: 6px 0 1px 6px;">
                                    <a href="{{url('/'.$bet_data['unmatched_bet'][$i]->name.'/3/'.'00'.'/'.$bet_item->eventId.'/MATCH_ODDS')}}" >
                                        <div class="">
                                            {{$bet_item->teams}}
                                        </div>
                                    </a>
                                    <p class="bet_info">Placed:{{$bet_item->bet_date}}</p>
                                </div>

                                <div class="open_bets_header">
                                    <span class="bet_match_name">Match Name</span>
                                    <span class="bet_odd">Odds</span>
                                    <span class="bet_stake">Stake</span>
                                    <span class="bet_profit">Profit/Liability</span>
                                    <span></span>
                                </div>
                                @endif

                                <div id="{{$bet_item->bet_id}}_bet" style="background-color: {{$bet_item->bet_type=='availableToLay'?'#f9c9d4':'#a7d8fd'}};" class="open_bets_body">
                                    <span class="bet_match_name">{{$bet_item->runnerName}}</span>
                                    <span class="bet_odd">{{$bet_item->odd}}</span>
                                    <span class="bet_stake">{{$bet_item->stake}}</span>
                                    <span class="bet_profit">{{$bet_item->price-$bet_item->stake}}</span>
                                    <div style="">
                                        <div class="btn btn-danger bet_close" data-value="{{$bet_item->bet_id}}"><i class="fas fa-times"></i></div>
                                    </div>
                                </div>
                                @if(isset($bet_data['unmatched_bet'][$i+1]))
                                    @if($bet_item->teams!=$bet_data['unmatched_bet'][$i+1]->teams)
                            </div>
                        @endif
                        @else
            </div>
            @endif
            @php
                $pre_team=$bet_item->teams;
            @endphp
            @endfor
            @endif
        </div>
        <a for="collapseThree" data-toggle="collapse" href="#collapseThree" aria-expanded="true" aria-controls="collapseTwo" class="btn toggleable-list-title" style="width: 100%;background-color: #06446c;color: #fff;border-radius: 0;padding: 0;">
                <span style="font-size: 12px; font-weight: 700;">
                    <strong>Matched Bets</strong>
                    {{--<span class="value ng-binding">100.00</span>--}}
                </span>
            <span class="arrow"><i class="fas"></i></span>
        </a>
        <div id="collapseThree" class="collapse in show" style="background: rgb(255, 255, 255); font-size: 12px;">
            @if(count($bet_data['matched_bet'])==0)
                <div class="nodata">
                    <strong>You have no matched bets</strong>
                    <span style="color: #2aa033;"></span>
                </div>
            @else
                @php
                    $pre_team='';
                @endphp
                @for($i=0;$i<count($bet_data['matched_bet']);$i++)
                    @php
                        $bet_item=$bet_data['matched_bet'][$i];
                    @endphp
                    @if($pre_team!=$bet_item->teams)
                        <div id="{{$bet_item->eventId}}_bets" class="open_bets" style="">
                            <div class="part_teams" style="text-align: left;padding-left: 5px;margin: 6px 0 1px 6px;">
                                <a href="{{url('/'.$bet_data['matched_bet'][$i]->name.'/3/'.'00'.'/'.$bet_item->eventId.'/MATCH_ODDS')}}" >
                                    <div class="">
                                        {{$bet_item->teams}}
                                    </div>
                                </a>
                                <p class="bet_info">Placed:{{$bet_item->bet_date}}</p>
                            </div>

                            <div class="open_bets_header">
                                <span class="bet_match_name">Match Name</span>
                                <span class="bet_odd">Odds</span>
                                <span class="bet_stake">Stake</span>
                                <span class="bet_profit">Profit/Liability</span>
                            </div>
                            @endif

                            <div id="{{$bet_item->bet_id}}_bet" style="background-color: {{$bet_item->bet_type=='availableToLay'?'#f9c9d4':'#a7d8fd'}};" class="open_bets_body">
                                <span class="bet_match_name">{{$bet_item->runnerName}}</span>
                                <span class="bet_odd">{{$bet_item->odd}}</span>
                                <span class="bet_stake">{{$bet_item->stake}}</span>
                                <span class="bet_profit">{{$bet_item->price-$bet_item->stake}}</span>
                            </div>
                            @if(isset($bet_data['matched_bet'][$i+1]))
                                @if($bet_item->teams!=$bet_data['matched_bet'][$i+1]->teams)
                        </div>
                    @endif
                    @else
        </div>
        @endif
        @php
            $pre_team=$bet_item->teams;
        @endphp
        @endfor
        @endif
    </div>
</div>
</div>
</div>