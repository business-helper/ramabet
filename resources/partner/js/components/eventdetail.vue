<template>
    <div class="">
        <div class="lds-facebook" :class="is_show">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <modal :name="'scoreBookModal'+this.market.id" style="" draggable="true" width="300px" height="auto"
               class="back_betting_slip add_master_dlg">
            <div class="modal-content" style="height: 100%;">
                <div class="modal-header header-color-modal bg-color-1">
                    <h4 class="modal-title text-center">{{this.scoreBookRunner}}</h4>
                    <div class="modal-close-area modal-close-df">
                        <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close"
                                data-dismiss="modal" v-on:click="$modal.hide('scoreBookModal'+market.id)">&times;
                        </button>
                    </div>
                </div>
                <div class="modal-body" style="max-height: 500px; overflow: auto;">
                    <table class="table table-bordered table-condensed" style="margin: 0;">
                        <thead>
                        <tr style="color: #585858">
                            <th style="">Score</th>
                            <th style="">Liability</th>
                        </tr>
                        </thead>
                        <tbody class="tbUMatchedB">
                        <tr v-for="item in this.scoreBook" >

                            <td>
                                {{item.rate}}
                            </td>
                            <td :class="item.profit>=0?'profit_color':'loss_color'">
                                {{item.profit}}
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </modal>
        <!--<div v-if="this.$isSuper==0">
            <div v-if="this.market.marketType!='fancy'" class="panel-group full-body" id="accordion_19" role="tablist" aria-multiselectable="true">
                <div class="panel" >
                    <div class="panel-heading market_title" role="tab" :id="'headingOne_'+market.id" >
                    <span style="font-size: 12px;font-weight: 600;text-align: center; padding: 0;" class="panel-title" >
                        <a role="button" data-toggle="collapse" :href="'#collapseOne_'+market.id" aria-expanded="false" aria-controls="collapseOne_19" class="collapsed" style="    padding: 5px 15px;">
                            {{this.event.sportName}}-{{this.event.name}}-{{this.market.marketStatus}}
                            <span class="">
                                <span v-for="runner in this.runners" :class="runner.profit.toFixed(2)>=0?'profit_color':'loss_color'">{{runner.runnerName}}:{{runner.profit.toFixed(2)}}:</span>
                            </span>
                        </a>
                    </span>
                    </div>
                    <div :id="'collapseOne_'+market.id" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_19" aria-expanded="true">
                        <div v-if="this.market.marketId<0" class="right">
                            <button class="" v-on:click="delMarkets(market.id)">Del</button>
                        </div>
                        <div class="right">
                            <input v-model="market.is_active" type="checkbox" :id="'is_active'+this.market.id" class="filled-in" v-on:change="updateIsActive">
                            <label :for="'is_active'+this.market.id">Active</label>
                        </div>
                        <div v-if="this.market.marketId>0" class="right">
                            <input v-model="market.isUpdate" type="checkbox" :id="'is_update'+this.market.id" class="filled-in" v-on:change="updateIsUpdate">
                            <label :for="'is_update'+this.market.id">Live Update</label>
                        </div>
                        <div class="right">
                            <input v-model="market.isPlay" type="checkbox" :id="'is_play'+this.market.id" class="filled-in" v-on:change="updateIsPlay">
                            <label :for="'is_play'+this.market.id">Play/Pause</label>
                        </div>

                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" :href="'#default'+this.currentMarketId">Default</a>
                            </li>
                            <li>
                                <a data-toggle="tab" :href="'#custom'+this.currentMarketId" >Custom Volum</a>
                            </li>
                            <li>
                                <a data-toggle="tab" :href="'#management'+this.currentMarketId" >Management</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div :id="'default'+this.currentMarketId" class="tab-pane fade in active">
                                <table class="table oddtable" style="background-color: transparent;">
                                    <thead>
                                    <tr>
                                        <th style="display: flex">
                                            <div @click="setMarket(market.id)"><img :class="market_state"></div>
                                            <span class="runner_name">{{this.market.marketName}}</span>
                                            <span v-if="market.inPlay==1" class="progress_title inplay blink_me"><i class="fas fa-play-circle"></i>InPlay</span>
                                        </th>
                                        <th class="oddTableHeader" style="text-align: right;padding: 0;">
                                            <div style="text-align: center;width: 55px;margin-right: 0px;margin-left: auto;">
                                                Back
                                            </div>
                                        </th>
                                        <th  class="oddTableHeader" style="text-align: left;padding: 0;">
                                            <div style="text-align: center;width: 55px;margin-right: auto;margin-left: 0px;">
                                                Lay
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody style="background-color: white;" v-if="market.isUpdate==true">
                                    <tr v-for="runner in this.runners" v-bind="runner" :id="'runner'+runner.id">
                                        <td style="">
                                            <profit_compenent :runner_id="runner.id" :market_id="currentMarketId" :initProfit="runner.profit"></profit_compenent>
                                            {{runner.runnerName}}

                                        </td>
                                        <td style="height: 40px;padding: 1px">
                                            <div v-if="market.marketStatus=='OPEN'" class="selectTemp notranslate"
                                                 style="justify-content: flex-end;-webkit-justify-content: flex-end">
                                                <transition name="slide-fade" mode="out-in">
                                                    <div v-if="runner.availableToBack.length>=3" class="left_item mobile_hide" :key="runner.availableToBack[2].price+runner.availableToBack[2].size"
                                                         @click="createBetSlip(runner.id,'availableToBack',runner.availableToBack[2].price)">
                                                    <span>
                                                         <p class="price">
                                                                {{runner.availableToBack[2].price}}
                                                         </p>
                                                        <span class="size">
                                                            {{runner.availableToBack[2].size}}
                                                        </span>
                                                    </span>
                                                    </div>
                                                    <div v-else class="left_item mobile_hide">
                                                        &#45;&#45;
                                                    </div>
                                                </transition>
                                                <transition name="slide-fade" mode="out-in">
                                                    <div v-if="runner.availableToBack.length>=2" class="left_item mobile_hide"
                                                         @click="createBetSlip(runner.id,'availableToBack',runner.availableToBack[1].price)" :key="runner.availableToBack[1].price+runner.availableToBack[1].size">
                                        <span>
                                            <p class="price">{{runner.availableToBack[1].price}}</p>
                                            <span class="size">
                                                {{runner.availableToBack[1].size}}
                                            </span>
                                        </span>
                                                    </div>
                                                    <div v-else class="left_item mobile_hide">
                                                        &#45;&#45;
                                                    </div>
                                                </transition>
                                                <transition name="slide-fade" mode="out-in">
                                                    <div v-if="runner.availableToBack.length>=1" class="left_item"
                                                         @click="createBetSlip(runner.id,'availableToBack',runner.availableToBack[0].price)" :key="runner.availableToBack[0].price+runner.availableToBack[0].size">
                                        <span>
                                            <p class="price">{{runner.availableToBack[0].price}}</p>
                                            <span class="size">
                                                {{runner.availableToBack[0].size}}
                                            </span>
                                        </span>
                                                    </div>
                                                    <div v-else class="left_item">
                                                        &#45;&#45;
                                                    </div>
                                                </transition>

                                            </div>
                                            <div v-else class="selectTemp notranslate"
                                                 style="background-color: #ffa2a0;justify-content: center; border: solid 1px; align-items: center;">
                                                &#45;&#45;{{market.marketStatus}}&#45;&#45;
                                            </div>
                                        </td>
                                        <td style="height: 40px;padding: 1px">
                                            <div v-if="market.marketStatus=='OPEN'" class="selectTemp notranslate"
                                            >
                                                <transition name="slide-fade" mode="out-in">
                                                    <div v-if="runner.availableToLay.length>=1" class="right_item"
                                                         @click="createBetSlip(runner.id,'availableToLay',runner.availableToLay[0].price)" :key="runner.availableToLay[0].price+runner.availableToLay[0].size">
                                            <span>
                                                <p class="price">{{runner.availableToLay[0].price}}</p>
                                                <span class="size">
                                                    {{runner.availableToLay[0].size}}
                                                </span>
                                            </span>
                                                    </div>
                                                    <div v-else class="right_item">
                                                        &#45;&#45;
                                                    </div>
                                                </transition>
                                                <transition name="slide-fade" mode="out-in">
                                                    <div v-if="runner.availableToLay.length>=2" class="right_item mobile_hide"
                                                         @click="createBetSlip(runner.id,'availableToLay',runner.availableToLay[1].price)" :key="runner.availableToLay[1].price+runner.availableToLay[1].size">
                                            <span>
                                                <p class="price">{{runner.availableToLay[1].price}}</p>
                                                <span class="size">
                                                    {{runner.availableToLay[1].size}}
                                                </span>
                                            </span>
                                                    </div>
                                                    <div v-else class="right_item mobile_hide">
                                                        &#45;&#45;
                                                    </div>
                                                </transition>
                                                <transition name="slide-fade" mode="out-in">
                                                    <div v-if="runner.availableToLay.length>=3" class="right_item mobile_hide"
                                                         @click="createBetSlip(runner.id,'availableToLay',runner.availableToLay[2].price+runner.availableToLay[2].size)">
                                        <span>
                                            <p class="price">{{runner.availableToLay[2].price}}</p>
                                            <span class="size">
                                                {{runner.availableToLay[2].size}}
                                            </span>
                                        </span>
                                                    </div>
                                                    <div v-else class="right_item mobile_hide">
                                                        &#45;&#45;
                                                    </div>
                                                </transition>


                                            </div>
                                            <div v-else class="selectTemp notranslate"
                                                 style="background-color: #ffa2a0;justify-content: center; border: solid 1px; align-items: center;">
                                                &#45;&#45;{{market.marketStatus}}&#45;&#45;
                                            </div>
                                        </td>

                                    </tr>
                                    </tbody>
                                    <tbody style="background-color: white;" v-else>
                                    <tr v-for="runner in this.custom_runner" v-bind="runner" :id="'runner'+runner.id">
                                        <td>
                                            <profit_compenent :runner_id="runner.id" :market_id="currentMarketId" :initProfit="runner.profit"></profit_compenent>
                                            {{runner.runnerName}}

                                        </td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div v-if="market.marketStatus=='OPEN'" class="selectTemp notranslate"
                                                 style="width: 100%!important;height: 100%!important;">
                                                <div v-if="runner.availableToBack.length>=3" class="left_item mobile_hide">
                                                <span>
                                                     <p class="price">
                                                            <input type="number" v-model="runner.availableToBack[2].price" v-on:keyup.enter="updateOdd"/>
                                                     </p>
                                                    <span class="size">
                                                         <input type="number" v-model="runner.availableToBack[2].size" v-on:keyup.enter="updateOdd"/>
                                                    </span>
                                                </span>
                                                </div>
                                                <div v-else class="left_item mobile_hide">
                                                    &#45;&#45;
                                                </div>

                                                <div v-if="runner.availableToBack.length>=2" class="left_item mobile_hide">
                                                <span>
                                                    <p class="price">
                                                            <input type="number" v-model="runner.availableToBack[1].price" v-on:keyup.enter="updateOdd"/>
                                                     </p>
                                                    <span class="size">
                                                         <input type="number" v-model="runner.availableToBack[1].size" v-on:keyup.enter="updateOdd"/>
                                                    </span>
                                                </span>
                                                </div>
                                                <div v-else class="left_item mobile_hide">
                                                    &#45;&#45;
                                                </div>
                                                <div v-if="runner.availableToBack.length>=1" class="left_item">
                                                <span>
                                                    <p class="price">
                                                        <input type="number" v-model="runner.availableToBack[0].price" v-on:keyup.enter="updateOdd"/>
                                                    </p>
                                                    <span class="size">
                                                         <input type="number" v-model="runner.availableToBack[0].size" v-on:keyup.enter="updateOdd"/>
                                                    </span>
                                                </span>
                                                </div>
                                                <div v-else class="left_item">
                                                    &#45;&#45;
                                                </div>

                                            </div>
                                            <div v-else class="selectTemp notranslate"
                                                 style="background-color: #ffa2a0;justify-content: center; border: solid 1px; align-items: center;">
                                                &#45;&#45;{{market.marketStatus}}&#45;&#45;
                                            </div>
                                        </td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div v-if="market.marketStatus=='OPEN'" class="selectTemp notranslate"
                                                 style="width: 100%!important;height: 100%!important;">
                                                <div v-if="runner.availableToLay.length>=1" class="right_item">
                                                <span>
                                                    <p class="price">
                                                        <input type="number" v-model="runner.availableToLay[0].price" v-on:keyup.enter="updateOdd"/>
                                                    </p>
                                                    <span class="size">
                                                         <input type="number" v-model="runner.availableToLay[0].size" v-on:keyup.enter="updateOdd"/>
                                                    </span>
                                                </span>
                                                </div>
                                                <div v-else class="right_item">
                                                    &#45;&#45;
                                                </div>
                                                <div v-if="runner.availableToLay.length>=2" class="right_item mobile_hide">
                                                <span>
                                                    <p class="price">
                                                        <input type="number" v-model="runner.availableToLay[1].price" v-on:keyup.enter="updateOdd"/>
                                                    </p>
                                                    <span class="size">
                                                         <input type="number" v-model="runner.availableToLay[1].size" v-on:keyup.enter="updateOdd"/>
                                                    </span>
                                                </span>
                                                </div>
                                                <div v-else class="right_item mobile_hide">
                                                    &#45;&#45;
                                                </div>
                                                <div v-if="runner.availableToLay.length>=3" class="right_item mobile_hide"
                                                     @click="createBetSlip(runner.id,'availableToLay',runner.availableToLay[2].price+runner.availableToLay[2].size)">
                                                <span>
                                                    <p class="price">
                                                        <input type="number" v-model="runner.availableToLay[2].price" v-on:keyup.enter="updateOdd"/>
                                                    </p>
                                                    <span class="size">
                                                         <input type="number" v-model="runner.availableToLay[2].size" v-on:keyup.enter="updateOdd"/>
                                                    </span>
                                                </span>
                                                </div>
                                                <div v-else class="right_item mobile_hide">
                                                    &#45;&#45;
                                                </div>


                                            </div>
                                            <div v-else class="selectTemp notranslate"
                                                 style="background-color: #ffa2a0;justify-content: center; border: solid 1px; align-items: center;">
                                                &#45;&#45;{{market.marketStatus}}&#45;&#45;
                                            </div>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                                <div v-if="this.$isSuper==0">
                                    <div v-if="this.market.marketStatus!='CLOSED'">
                                        <select v-model="market_result" class="form-control">
                                            <option value="0">None</option>
                                            &lt;!&ndash;<option>&#45;&#45;Suspend&#45;&#45;</option>&ndash;&gt;
                                            <option v-for="runner in this.runners" >{{runner.runnerName}}</option>
                                        </select>
                                        <div style="display: flex">
                                            <div style="flex: 1;text-align: center"><button v-if="market_result!='0'" class="btn bg-green waves-effect" @click="setMarketResult(market_result)">Set Result</button></div>
                                            <div style="flex: 1;text-align: center"><button v-if="market_result!='0'" class="btn bg-green waves-effect" @click="setMarketResult('&#45;&#45;Abandon&#45;&#45;')">Abandon</button></div>
                                            <div style="flex: 1;text-align: center"><button v-if="market_result!='0'" class="btn bg-green waves-effect" @click="setMarketResult('&#45;&#45;Suspend&#45;&#45;')">Suspend</button></div>
                                            <div style="flex: 1;text-align: center"><button class="btn bg-green waves-effect"  style="float: right" @click="Undeclare">UnDeclare</button></div>



                                        </div>

                                    </div>
                                    <div v-else>
                                        {{this.market_result}}:{{this.market_result=='DONE'?this.market.winnerName:''}}
                                        <button class="btn bg-green waves-effect"  style="float: right" @click="Undeclare">UnDeclare</button>
                                    </div>
                                </div>
                            </div>
                            <div :id="'custom'+this.currentMarketId" class="tab-pane fade">
                                <table class="table oddtable" style="background-color: transparent;">
                                    <thead>
                                    <tr>
                                        <th style="display: flex">
                                            <div @click="setMarket(market.id)"><img :class="market_state"></div>
                                            <span class="runner_name">{{this.market.marketName}}</span>
                                        </th>
                                        <th style="text-align: right;padding: 0;">
                                            <div style="text-align: center;width: 55px;margin-right: 0px;margin-left: auto;">
                                                Back
                                            </div>
                                        </th>
                                        <th style="text-align: left;padding: 0;">
                                            <div style="text-align: center;width: 55px;margin-right: auto;margin-left: 0px;">
                                                Lay
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody style="background-color: white;">
                                    <tr>
                                        <td></td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div class="selectTemp notranslate"
                                                 style="width: 100%!important;height: 100%!important;    flex-direction: row-reverse;">
                                                <div class="left_item" >
                                                    <input v-model="backVol" type="number" v-on:keyup="updateVol('availableToBackVol',backVol)" />
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div class="selectTemp notranslate"
                                                 style="width: 100%!important;height: 100%!important;">
                                                <div class="right_item">
                                                    <input v-model="layVol" type="number" v-on:keyup="updateVol('availableToLayVol',layVol)" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-for="runner in this.runners" v-bind="runner" :id="'runner'+runner.id">
                                        <td>
                                            {{runner.runnerName}}
                                        </td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div class="selectTemp notranslate"
                                                 style="width: 100%!important;height: 100%!important;">
                                                <div class="left_item">
                                                    <input type="number" v-model="runner.availableToBackVol[2]"/>
                                                </div>
                                                <div class="left_item">
                                                    <input type="number" v-model="runner.availableToBackVol[1]"/>
                                                </div>
                                                <div class="left_item" >
                                                    <input type="number" v-model="runner.availableToBackVol[0]"/>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div class="selectTemp notranslate"
                                                 style="width: 100%!important;height: 100%!important;">
                                                <div class="right_item">
                                                    <input type="number" v-model="runner.availableToLayVol[0]"/>
                                                </div>
                                                <div class="right_item">
                                                    <input type="number" v-model="runner.availableToLayVol[1]"/>
                                                </div>
                                                <div class="right_item">
                                                    <input type="number" v-model="runner.availableToLayVol[2]"/>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div style="text-align: right; padding-right: 20px;">
                                    <button class="btn bg-green waves-effect"  @click="updateMarketVol">Update</button>
                                </div>

                            </div>
                            <div :id="'management'+this.currentMarketId" class="tab-pane fade">
                                <div style="display: flex;flex-wrap: wrap;">
                                    <div class="sport_item">
                                        <h6>Min Stake</h6>
                                        <input v-model="market_management.minStake" type="number" class="form-control"/>
                                    </div>
                                    <div class="sport_item">
                                        <h6>Max Stake</h6>
                                        <input v-model="market_management.maxStake" type="number" class="form-control"/>
                                    </div>
                                    <div class="sport_item">
                                        <h6>Max Profit</h6>
                                        <input v-model="market_management.maxProfit" type="number" class="form-control"/>
                                    </div>
                                    <div class="sport_item">
                                        <h6>Pre Inplay Profit</h6>
                                        <input v-model="market_management.preInplayProfit" type="number" class="form-control"/>
                                    </div>
                                    <div class="sport_item">
                                        <h6>Pre Inplay Stake</h6>
                                        <input v-model="market_management.preInplayStake" type="number" class="form-control"/>
                                    </div>
                                    <div class="sport_item">
                                        <h6>Delay In Second</h6>
                                        <input v-model="market_management.delaySec" type="number" class="form-control"/>
                                    </div>
                                    <div class="sport_item">
                                        <h6>Commission</h6>
                                        <input v-model="market_management.commission" type="number" class="form-control" disabled/>
                                    </div>
                                    <div class="sport_item">
                                        <input v-model="market_management.unMatched" type="checkbox" :id="'unmatchedBet'+market_management.id" class="filled-in">
                                        <label :for="'unmatchedBet'+market_management.id">UnMatched Bet</label>
                                    </div>
                                    <div class="sport_item">
                                        <input v-model="market_management.lockBet" type="checkbox" :id="'lockBet'+market_management.id" class="filled-in">
                                        <label :for="'lockBet'+market_management.id">Lock Bet</label>
                                    </div>
                                </div>
                                <button class="btn bg-green waves-effect"  style="float: right" @click="updateMarketManagement">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else-if="this.market.marketType=='fancy'" class="panel-group full-body"  role="tablist" aria-multiselectable="true">
                <div class="panel">
                    <div class="panel-heading market_title" role="tab" :id="'headingOne_'+this.market.id"
                         >
                    <span style="font-size: 12px;font-weight: 600;text-align: center; padding: 0;" class="panel-title">
                        <a role="button" data-toggle="collapse" :href="'#collapseOne_'+market.id" aria-expanded="false"
                           aria-controls="collapseOne_19" class="collapsed" style="    padding: 5px 15px;">
                            {{this.event.sportName}}-{{this.event.name}}-{{this.market.marketStatus}}
                            &lt;!&ndash;<span class="">
                                <span v-for="runner in this.runners" >{{runner.runnerName}}:<profit_compenent :runner_id="runner.id" :market_id="market.id" state1="1"></profit_compenent></span>
                            </span>&ndash;&gt;
                        </a>
                    </span>
                    </div>
                    <div :id="'collapseOne_'+market.id" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_19" aria-expanded="true">
                        <div v-if="this.market.marketId<0" class="right">
                            <button class="" v-on:click="delMarkets(market.id)">Del</button>
                        </div>
                        <div class="right">
                            <select v-model="fancyStatus">
                                <option value="all" selected>All</option>
                                <option value="">OPENED</option>
                                <option value="SUSPENDED">SUSPENDED</option>
                                <option value="CANCELED">CANCELED</option>
                                <option value="CLOSED">CLOSED</option>
                            </select>
                        </div>
                        <div class="right">
                            <input v-model="market.is_active" type="checkbox" :id="'is_active'+this.market.id" class="filled-in" v-on:change="updateIsActive">
                            <label :for="'is_active'+this.market.id">Active</label>
                        </div>
                        &lt;!&ndash;<div v-if="this.market.marketId>0" class="right">
                            <input v-model="market.isUpdate" type="checkbox" :id="'is_update'+this.market.id" class="filled-in" v-on:change="updateIsUpdate">
                            <label :for="'is_update'+this.market.id">Live Update</label>
                        </div>&ndash;&gt;
                        <div class="right">
                            <input v-model="market.isPlay" type="checkbox" :id="'is_play'+this.market.id" class="filled-in" v-on:change="updateIsPlay">
                            <label :for="'is_play'+this.market.id">Play/Pause</label>
                        </div>

                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" :href="'#default'+this.currentMarketId">Default</a>
                            </li>
                            &lt;!&ndash;<li>
                                <a data-toggle="tab" :href="'#custom'+this.currentMarketId" >Custom Volum</a>
                            </li>&ndash;&gt;
                            <li>
                                <a data-toggle="tab" :href="'#management'+this.currentMarketId" >Management</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div :id="'default'+this.currentMarketId" class="tab-pane fade in active">
                                <table class="table oddtable" style="background-color: transparent;">
                                    <thead>
                                    <tr>
                                        <th style="display: flex">
                                            <div @click="setMarket(market.id)"><img :class="market_state"></div>
                                            <span class="runner_name">{{this.market.marketName}}</span>
                                            <span v-if="market.inPlay==1" class="progress_title inplay blink_me">:<i class="fas fa-play-circle"></i>InPlay</span>
                                        </th>
                                        <th  class="" style="text-align: right;padding: 0;width: 120px;">
                                            <div style="display: flex">
                                                <div style="text-align: center;flex: 1;">
                                                    No
                                                </div>
                                                <div style="text-align: center;flex: 1;">
                                                    Yes
                                                </div>
                                            </div>

                                        </th>
                                        <th class="" style="text-align: left;padding: 0;">

                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody style="background-color: white;">
                                    <tr v-for="runner in this.runners" v-bind="runner" :id="'runner'+runner.id" v-if="fancyStatus=='all' || runner.runnerStatus==fancyStatus">
                                        <td style="">
                                            <sessionProfit :runner_id="runner.id" :market_id="market.id" marketType="fancy" userType="admins" class="right" :initProfit="runner.profit"></sessionProfit>
                                            {{runner.runnerName}}

                                            <div style="display: flex;width: fit-content">
                                                <input :id="'score_'+runner.id" v-if="runner.runnerStatus!='CLOSED'" class="form-control" type="number" style="width: 80px;display: inline" />
                                                <input v-else class="form-control" v-model="runner.score" type="number" style="width: 80px;display: inline" disabled/>
                                                <div style="flex: 1;text-align: center"><button class="btn bg-green waves-effect" @click="setSessionResult('CLOSED',runner)">SR</button></div>
                                                <div style="flex: 1;text-align: center"><button class="btn bg-green waves-effect" @click="setSessionResult('CANCELED',runner)">AN</button></div>
                                                <div style="flex: 1;text-align: center"><button v-if="runner.runnerStatus!='SUSPENDED'" class="btn bg-green waves-effect" @click="setSessionResult('SUSPENDED',runner)">S</button></div>
                                                <div style="flex: 1;text-align: center"><button class="btn bg-green waves-effect"  style="float: right" @click="setSessionResult('',runner)">UD</button></div>
                                                <div style="flex: 1;text-align: center">
                                                    <input v-model="runner.is_show" type="checkbox" :id="'is_play'+runner.id" class="filled-in" v-on:change="updateShowState(runner)">
                                                    <label :for="'is_play'+runner.id">Show/Hide</label>
                                                </div>
                                            </div>


                                        </td>
                                        <td style="padding: 1px">
                                            <div class="selectTemp">

                                                <div class=" notranslate"
                                                     style="justify-content: flex-end;-webkit-justify-content: flex-start">
                                                    <transition name="slide-fade" mode="out-in">
                                                        <div v-if="runner.availableToLay.length>=1" class="right_item"
                                                             @click="createBetSlip(runner.id,'availableToLay',runner.availableToLay[0].price)" :key="runner.availableToLay[0].price+runner.availableToLay[0].size">
                                            <span>
                                                <p class="price">{{runner.availableToLay[0].price}}</p>
                                                <span class="size">
                                                    {{runner.availableToLay[0].size}}
                                                </span>
                                            </span>
                                                        </div>
                                                        <div v-else class="right_item">
                                                            &#45;&#45;
                                                        </div>
                                                    </transition>

                                                </div>
                                                <div class=" notranslate"
                                                     style="justify-content: flex-end;-webkit-justify-content: flex-end">
                                                    <transition name="slide-fade" mode="out-in">
                                                        <div v-if="runner.availableToBack.length>=1" class="left_item"
                                                             @click="createBetSlip(runner.id,'availableToBack',runner.availableToBack[0].price)" :key="runner.availableToBack[0].price+runner.availableToBack[0].size">
                                            <span>
                                                <p class="price">{{runner.availableToBack[0].price}}</p>
                                                <span class="size">
                                                    {{runner.availableToBack[0].size}}
                                                </span>
                                            </span>
                                                        </div>
                                                        <div v-else class="left_item">
                                                            &#45;&#45;
                                                        </div>
                                                    </transition>

                                                </div>
                                            </div>
                                            <div v-if="runner.runnerStatus=='SUSPENDED' || runner.runnerStatus=='CLOSED' || runner.runnerStatus=='CANCELED'" class="selectTemp notranslate"
                                                 style="font-size: 14px;background-color: rgba(100, 100, 100, 0.6); color: white; font-weight: 500; justify-content: center; border: 1px solid; align-items: center;">
                                                {{runner.runnerStatus}}
                                            </div>

                                        </td>
                                        <td style="padding: 0; text-align: center; vertical-align: middle;">
                                            <button type="button" class="btn bg-green waves-effect" style="margin: auto" v-on:click="getScoreBook(runner.id,runner.runnerName)">BOOK</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div :id="'custom'+this.currentMarketId" class="tab-pane fade">
                                <table class="table oddtable" style="background-color: transparent;">
                                    <thead>
                                    <tr>
                                        <th style="display: flex">
                                            <div @click="setMarket(market.id)"><img :class="market_state"></div>
                                            <span class="runner_name">{{this.market.marketName}}</span>
                                        </th>
                                        <th style="text-align: right;padding: 0;">
                                            <div style="text-align: center;width: 55px;margin-right: 0px;margin-left: auto;">
                                                Back
                                            </div>
                                        </th>
                                        <th style="text-align: left;padding: 0;">
                                            <div style="text-align: center;width: 55px;margin-right: auto;margin-left: 0px;">
                                                Lay
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody style="background-color: white;">
                                    <tr>
                                        <td></td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div class="selectTemp notranslate"
                                                 style="width: 100%!important;height: 100%!important;    flex-direction: row-reverse;">
                                                <div class="left_item" >
                                                    <input v-model="backVol" type="number" v-on:keyup="updateVol('availableToBackVol',backVol)" />
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div class="selectTemp notranslate"
                                                 style="width: 100%!important;height: 100%!important;">
                                                <div class="right_item">
                                                    <input v-model="layVol" type="number" v-on:keyup="updateVol('availableToLayVol',layVol)" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-for="runner in this.runners" v-bind="runner" :id="'runner'+runner.id">
                                        <td>
                                            {{runner.runnerName}}
                                        </td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div class="selectTemp notranslate"
                                                 style="width: 100%!important;height: 100%!important;">
                                                <div class="left_item">
                                                    <input type="number" v-model="runner.availableToBackVol[2]"/>
                                                </div>
                                                <div class="left_item">
                                                    <input type="number" v-model="runner.availableToBackVol[1]"/>
                                                </div>
                                                <div class="left_item" >
                                                    <input type="number" v-model="runner.availableToBackVol[0]"/>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 180px;height: 40px;padding: 1px">
                                            <div class="selectTemp notranslate"
                                                 style="width: 100%!important;height: 100%!important;">
                                                <div class="right_item">
                                                    <input type="number" v-model="runner.availableToLayVol[0]"/>
                                                </div>
                                                <div class="right_item">
                                                    <input type="number" v-model="runner.availableToLayVol[1]"/>
                                                </div>
                                                <div class="right_item">
                                                    <input type="number" v-model="runner.availableToLayVol[2]"/>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div style="text-align: right; padding-right: 20px;">
                                    <button class="btn bg-green waves-effect"  @click="updateMarketVol">Update</button>
                                </div>

                            </div>
                            <div :id="'management'+this.currentMarketId" class="tab-pane fade">
                                <div style="display: flex;flex-wrap: wrap;">
                                    <div class="sport_item">
                                        <h6>Min Stake</h6>
                                        <input v-model="market_management.minStake" type="number" class="form-control"/>
                                    </div>
                                    <div class="sport_item">
                                        <h6>Max Stake</h6>
                                        <input v-model="market_management.maxStake" type="number" class="form-control"/>
                                    </div>
                                    <div class="sport_item">
                                        <h6>Max Profit</h6>
                                        <input v-model="market_management.maxProfit" type="number" class="form-control"/>
                                    </div>
                                    &lt;!&ndash;<div class="sport_item">&ndash;&gt;
                                        &lt;!&ndash;<h6>Pre Inplay Profit</h6>&ndash;&gt;
                                        &lt;!&ndash;<input v-model="market_management.preInplayProfit" type="number" class="form-control"/>&ndash;&gt;
                                    &lt;!&ndash;</div>&ndash;&gt;
                                    &lt;!&ndash;<div class="sport_item">&ndash;&gt;
                                        &lt;!&ndash;<h6>Pre Inplay Stake</h6>&ndash;&gt;
                                        &lt;!&ndash;<input v-model="market_management.preInplayStake" type="number" class="form-control"/>&ndash;&gt;
                                    &lt;!&ndash;</div>&ndash;&gt;
                                    <div class="sport_item">
                                        <h6>Delay In Second</h6>
                                        <input v-model="market_management.delaySec" type="number" class="form-control"/>
                                    </div>
                                    <div class="sport_item">
                                        <h6>Commission</h6>
                                        <input v-model="market_management.commission" type="number" class="form-control" disabled/>
                                    </div>
                                    <div class="" style="margin-right: 5px">
                                        <input v-model="market_management.unMatched" type="checkbox" :id="'unmatchedBet'+market_management.id" class="filled-in">
                                        <label :for="'unmatchedBet'+market_management.id">UB</label>
                                    </div>
                                    <div class="">
                                        <input v-model="market_management.lockBet" type="checkbox" :id="'lockBet'+market_management.id" class="filled-in">
                                        <label :for="'lockBet'+market_management.id">LB</label>
                                    </div>
                                </div>
                                <button class="btn bg-green waves-effect"  style="float: right" @click="updateMarketManagement">Update</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>-->

        <div >
            <div v-if="(this.market.marketStatus=='OPEN' || this.market.marketStatus=='SUSPENDED') && this.market.marketType!='fancy'" class="panel-group full-body"  role="tablist" aria-multiselectable="true">
                <div class="panel" >
                    <div class="panel-heading market_title" role="tab" :id="'headingOne_'+market.id" >
                    <span style="font-size: 12px;font-weight: 600;text-align: center; padding: 0;" class="panel-title" >
                        <a role="button" data-toggle="collapse" :href="'#collapseOne_'+market.id" aria-expanded="false" aria-controls="collapseOne_19" class="collapsed" style="    padding: 5px 15px;">
                            {{this.event.sportName}}-{{this.event.name}}-{{this.market.marketStatus}}
                            <span class="">
                                <span v-for="runner in this.runners" :class="runner.profit.toFixed(2)<=0?'profit_color':'loss_color'">{{runner.runnerName}}:{{runner.profit.toFixed(2)}}:</span>
                            </span>
                        </a>
                    </span>
                    </div>
                    <div :id="'collapseOne_'+market.id" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_19" aria-expanded="true">
                        <table class="table oddtable" style="background-color: transparent;">
                            <thead>
                            <tr>
                                <th style="display: flex">
                                    <div @click="setMarket(market.id)"><img :class="market_state"></div>
                                    <span class="runner_name">{{this.market.marketName}}</span>
                                    <span v-if="market.inPlay==1" class="progress_title inplay blink_me"><i class="fas fa-play-circle"></i>InPlay</span>
                                </th>
                                <th class="oddTableHeader" style="text-align: right;padding: 0;">
                                    <div style="text-align: center;width: 55px;margin-right: 0px;margin-left: auto;">
                                        Back
                                    </div>
                                </th>
                                <th class="oddTableHeader" style="text-align: left;padding: 0;">
                                    <div style="text-align: center;width: 55px;margin-right: auto;margin-left: 0px;">
                                        Lay
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody style="background-color: white;">
                            <tr v-for="runner in this.runners" v-bind="runner" :id="'runner'+runner.id">
                                <td>
                                    <profit_compenent :runner_id="runner.id" :market_id="currentMarketId" :initProfit="runner.profit"></profit_compenent>
                                    {{runner.runnerName}}

                                </td>
                                <td style="height: 40px;padding: 1px">
                                    <div v-if="market.marketStatus=='OPEN'" class="selectTemp notranslate"
                                         style="justify-content: flex-end;height: 100%!important;">
                                        <transition name="slide-fade" mode="out-in">
                                            <div v-if="runner.availableToBack.length>=3" class="left_item mobile_hide" :key="runner.availableToBack[2].price+runner.availableToBack[2].size"
                                                 @click="createBetSlip(runner.id,'availableToBack',runner.availableToBack[2].price)">
                                            <span>
                                                 <p class="price">
                                                        {{runner.availableToBack[2].price}}
                                                 </p>
                                                <span class="size">
                                                    {{runner.availableToBack[2].size}}
                                                </span>
                                            </span>
                                            </div>
                                            <div v-else class="left_item mobile_hide">
                                                --
                                            </div>
                                        </transition>
                                        <transition name="slide-fade" mode="out-in">
                                            <div v-if="runner.availableToBack.length>=2" class="left_item mobile_hide"
                                                 @click="createBetSlip(runner.id,'availableToBack',runner.availableToBack[1].price)" :key="runner.availableToBack[1].price+runner.availableToBack[1].size">
                                        <span>
                                            <p class="price">{{runner.availableToBack[1].price}}</p>
                                            <span class="size">
                                                {{runner.availableToBack[1].size}}
                                            </span>
                                        </span>
                                            </div>
                                            <div v-else class="left_item mobile_hide">
                                                --
                                            </div>
                                        </transition>
                                        <transition name="slide-fade" mode="out-in">
                                            <div v-if="runner.availableToBack.length>=1" class="left_item"
                                                 @click="createBetSlip(runner.id,'availableToBack',runner.availableToBack[0].price)" :key="runner.availableToBack[0].price+runner.availableToBack[0].size">
                                        <span>
                                            <p class="price">{{runner.availableToBack[0].price}}</p>
                                            <span class="size">
                                                {{runner.availableToBack[0].size}}
                                            </span>
                                        </span>
                                            </div>
                                            <div v-else class="left_item">
                                                --
                                            </div>
                                        </transition>

                                    </div>
                                    <div v-else class="selectTemp notranslate"
                                         style="background-color: #ffa2a0;justify-content: center; border: solid 1px; align-items: center;">
                                        --{{market.marketStatus}}--
                                    </div>
                                </td>
                                <td style="height: 40px;padding: 1px">
                                    <div v-if="market.marketStatus=='OPEN'" class="selectTemp notranslate"
                                         style="width: 100%!important;height: 100%!important;">
                                        <transition name="slide-fade" mode="out-in">
                                            <div v-if="runner.availableToLay.length>=1" class="right_item"
                                                 @click="createBetSlip(runner.id,'availableToLay',runner.availableToLay[0].price)" :key="runner.availableToLay[0].price+runner.availableToLay[0].size">
                                            <span>
                                                <p class="price">{{runner.availableToLay[0].price}}</p>
                                                <span class="size">
                                                    {{runner.availableToLay[0].size}}
                                                </span>
                                            </span>
                                            </div>
                                            <div v-else class="right_item">
                                                --
                                            </div>
                                        </transition>
                                        <transition name="slide-fade" mode="out-in">
                                            <div v-if="runner.availableToLay.length>=2" class="right_item mobile_hide"
                                                 @click="createBetSlip(runner.id,'availableToLay',runner.availableToLay[1].price)" :key="runner.availableToLay[1].price+runner.availableToLay[1].size">
                                            <span>
                                                <p class="price">{{runner.availableToLay[1].price}}</p>
                                                <span class="size">
                                                    {{runner.availableToLay[1].size}}
                                                </span>
                                            </span>
                                            </div>
                                            <div v-else class="right_item mobile_hide">
                                                --
                                            </div>
                                        </transition>
                                        <transition name="slide-fade" mode="out-in">
                                            <div v-if="runner.availableToLay.length>=3" class="right_item mobile_hide"
                                                 @click="createBetSlip(runner.id,'availableToLay',runner.availableToLay[2].price+runner.availableToLay[2].size)">
                                        <span>
                                            <p class="price">{{runner.availableToLay[2].price}}</p>
                                            <span class="size">
                                                {{runner.availableToLay[2].size}}
                                            </span>
                                        </span>
                                            </div>
                                            <div v-else class="right_item mobile_hide">
                                                --
                                            </div>
                                        </transition>


                                    </div>
                                    <div v-else class="selectTemp notranslate"
                                         style="background-color: #ffa2a0;justify-content: center; border: solid 1px; align-items: center;">
                                        --{{market.marketStatus}}--
                                    </div>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div v-else-if="(this.market.marketStatus=='OPEN' || this.market.marketStatus=='SUSPENDED') && this.market.marketType=='fancy'" class="panel-group full-body" id="" role="tablist" aria-multiselectable="true">
                <div class="panel">
                    <div class="panel-heading market_title" role="tab" :id="'headingOne_'+this.market.id"
                         >
                    <span style="font-size: 12px;font-weight: 600;text-align: center; padding: 0;" class="panel-title">
                        <a role="button" data-toggle="collapse" :href="'#collapseOne_'+market.id" aria-expanded="false"
                           aria-controls="collapseOne_19" class="collapsed" style="    padding: 5px 15px;">
                            {{this.event.sportName}}-{{this.event.name}}-{{this.market.marketStatus}}
                            <!--<span class="">
                                <span v-for="runner in this.runners" >{{runner.runnerName}}:<profit_compenent :runner_id="runner.id" :market_id="market.id" state1="1"></profit_compenent></span>
                            </span>-->
                        </a>
                    </span>
                    </div>
                    <div :id="'collapseOne_'+market.id" class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="headingOne_19" aria-expanded="true">
                        <table class="table oddtable" style="background-color: transparent;">
                            <thead>
                            <tr>
                                <th style="display: flex">
                                    <div @click="setMarket(market.id)"><img :class="market_state"></div>
                                    <span class="runner_name">{{this.market.marketName}}</span>
                                    <span v-if="market.inPlay==1" class="progress_title inplay blink_me">:<i class="fas fa-play-circle"></i>InPlay</span>
                                </th>
                                <th  class="" style="text-align: right;padding: 0;width: 120px;">
                                    <div style="display: flex">
                                        <div style="text-align: center;flex: 1;">
                                            No
                                        </div>
                                        <div style="text-align: center;flex: 1;">
                                            Yes
                                        </div>

                                    </div>

                                </th>
                                <th class="" style="text-align: left;padding: 0;">

                                </th>
                            </tr>
                            </thead>
                            <tbody style="background-color: white;">
                            <tr v-for="runner in this.runners" v-bind="runner" :id="'runner'+runner.id" v-if="runner.runnerStatus!='CANCELED' && runner.runnerStatus!='CLOSED'">
                                <td style="">
                                    <sessionProfit :runner_id="runner.id" :market_id="market.id" marketType="fancy" userType="admins" class="right" :initProfit="runner.profit"></sessionProfit>
                                    {{runner.runnerName}}

                                </td>
                                <td style="padding: 1px">
                                    <div class="selectTemp">
                                        <div class=" notranslate"
                                             style="justify-content: flex-end;-webkit-justify-content: flex-start">
                                            <transition name="slide-fade" mode="out-in">
                                                <div v-if="runner.availableToLay.length>=1" class="right_item"
                                                     @click="createBetSlip(runner.id,'availableToLay',runner.availableToLay[0].price)" :key="runner.availableToLay[0].price+runner.availableToLay[0].size">
                                            <span>
                                                <p class="price">{{runner.availableToLay[0].price}}</p>
                                                <span class="size">
                                                    {{runner.availableToLay[0].size}}
                                                </span>
                                            </span>
                                                </div>
                                                <div v-else class="right_item">
                                                    --
                                                </div>
                                            </transition>

                                        </div>

                                        <div class=" notranslate"
                                             style="justify-content: flex-end;-webkit-justify-content: flex-end">
                                            <transition name="slide-fade" mode="out-in">
                                                <div v-if="runner.availableToBack.length>=1" class="left_item"
                                                     @click="createBetSlip(runner.id,'availableToBack',runner.availableToBack[0].price)" :key="runner.availableToBack[0].price+runner.availableToBack[0].size">
                                            <span>
                                                <p class="price">{{runner.availableToBack[0].price}}</p>
                                                <span class="size">
                                                    {{runner.availableToBack[0].size}}
                                                </span>
                                            </span>
                                                </div>
                                                <div v-else class="left_item">
                                                    --
                                                </div>
                                            </transition>

                                        </div>
                                    </div>
                                    <div v-if="runner.runnerStatus=='SUSPENDED' || runner.runnerStatus=='CLOSED' || runner.runnerStatus=='CANCELED'" class="selectTemp notranslate"
                                         style="font-size: 14px;background-color: rgba(100, 100, 100, 0.6); color: white; font-weight: 500; justify-content: center; border: 1px solid; align-items: center;">
                                        {{runner.runnerStatus}}
                                    </div>

                                </td>
                                <td style="padding: 0; text-align: center; vertical-align: middle;">
                                    <button type="button" class="btn bg-green waves-effect" style="margin: auto" v-on:click="getScoreBook(runner.id,runner.runnerName)">BOOK</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div>
</template>
<script>
    import profit_compenent from './profit.vue'
    import sessionProfit from './sessionProfit.vue'

    export default {
        data() {
            return {
                runners: [],
                custom_runner:[],
                is_show: 'show',
                event: [],
                market: [],
                markets: [],
                currentMarketId: '',
                market_state: 'deactive_market',
                market_management: [],
                market_result:'0',
                backVol:1,
                layVol:1,res_score:0,
                scoreBook:[],scoreBookRunner:'',fancyStatus:''
            }
        },
        props: [
            'market_id', 'multi_market'
        ],
        mounted() {
            //console.log('Event Component mounted.');

            var starCountRef = this.$firebase.database().ref('/updatedRunner');
            starCountRef.on('value', function (snapshot) {
                Event.$emit('updatedRunner',snapshot.val());
            });
            Event.$on('updatedRunner', (fancyItem) => {
                let index = this.runners.findIndex(item => item.id === fancyItem.id);
                if (index>-1){
                    this.runners[index].is_show=fancyItem.is_show;
                    console.log(index,this.runners[index],fancyItem);
                }
            });
            var starCountRef = this.$firebase.database().ref('/fancyBets');
            starCountRef.on('value', function (snapshot) {
                Event.$emit('getFancyBets',snapshot.val());
            });

            Event.$on('getFancyBets', (r_data) => {
                console.log('get fancy',typeof r_data,r_data);
                r_data.forEach(fancyItem=>{
                    let index = this.runners.findIndex(item => item.id === fancyItem.id);
                    if (index>-1){
                        this.runners[index].availableToLay=JSON.parse(fancyItem.availableToLay);
                        this.runners[index].availableToBack=JSON.parse(fancyItem.availableToBack);
                        this.runners[index].runnerStatus=fancyItem.runnerStatus;
                        console.log(index,this.runners[index],fancyItem);
                    }else{
                        if (fancyItem.market_id==this.market.id){
                            var tempRunner=JSON.parse(JSON.stringify(fancyItem));
                            tempRunner.availableToLay=JSON.parse(fancyItem.availableToLay);
                            tempRunner.availableToBack=JSON.parse(fancyItem.availableToBack);
                            this.runners.push(tempRunner);
                        }
                    }
                });
            });
            Event.$on('update_odd', (r_data) => {
                //console.log('update_odd',r_data);
                let index = this.runners.findIndex(item => item.id === r_data.id);
                if (index>-1){
                    this.runners[index][r_data.type]=r_data[r_data.type];
                }
            });
            Event.$on('placedBets',(data) => {
                this.read(this.currentMarketId);
            });
            Event.$on('matchedBet',(data) => {
                if (this.currentMarketId==data){
                    this.read(this.currentMarketId);
                }
            });
            Event.$on('selectMarket', (r_data) => {
                this.read(r_data);
            });
            Event.$on('EditMarket', (r_data) => {
                this.read(r_data);
            });
            Event.$on('removeEvent', (r_data) => {
                this.read(this.currentMarketId);
            });
        },
        methods: {
            updateShowState(runner){
                var starCountRef = this.$firebase.database().ref('/');
                var updatedRunner=runner;
                starCountRef.update({
                    updatedRunner
                }).then((data)=>{
                    //success callback
                    console.log('data ' , data)
                }).catch((error)=>{
                    //error callback
                    console.log('error ' , error)
                })
                window.axios.post('/api/updateShowRunner', {runner:runner}).then(({data}) => {
                    //showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");

                });
                console.log(status,runner)
            },
            setSessionResult(status,runner){
                if (status=='CLOSED'){
                    runner.score=$('#score_'+runner.id).val();
                    if (runner.score<0) return  showNotification("alert-success", 'Invalid score', "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }


                runner.runnerStatus=status;
                window.axios.post('/api/setResultOfSession', {runner:runner}).then(({data}) => {
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");

                    Event.$emit('setResultOfMarket','');
                    var starCountRef = this.$firebase.database().ref('/');
                    var Declare=data.data;
                    starCountRef.update({
                        Declare
                    }).then((data)=>{
                        //success callback
                        console.log('data ' , data)
                    }).catch((error)=>{
                        //error callback
                        console.log('error ' , error)
                    })
                });
                console.log(status,runner)
            },
            getScoreBook(runner_id,runnerName){
                console.log(runner_id)
                //Event.$emit('scoreBook',runner_id,runnerName);
                this.scoreBookRunner=runnerName;
                this.readScoreBook(runner_id);
            },
            readScoreBook(runner_id){
                window.axios.post('/api/getScoreBook',{runner_id:runner_id,user_id:this.$userId,user_type:'admins'}).then(({ data }) => {
                    //console.log('profit of'+this.runner_id,data);
                    this.scoreBook=data.data;
                    this.$modal.show('scoreBookModal'+this.market.id, {}, {
                        draggable: true,
                        resizable: true
                    })
                    //scoreBook
                    //Event.$emit('betSlipLoading','hide');
                    //showNotification("alert-success", data.message, "top", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            updateOdd(){
              console.log(this.custom_runner);
                window.axios.post('/api/updateOdd', {runners:this.custom_runner}).then(({data}) => {
                    this.runners=this.custom_runner;
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    var starCountRef = this.$firebase.database().ref('/');
                    var runners=data.note;
                    starCountRef.update({
                        runners
                    }).then((data)=>{
                        //success callback
                        console.log('data ' , data)
                    }).catch((error)=>{
                        //error callback
                        console.log('error ' , error)
                    })

                    var matchedBet=data.matchedBet;
                    starCountRef.update({
                        matchedBet
                    }).then((data)=>{
                        //success callback
                        console.log('data ' , data)
                    }).catch((error)=>{
                        //error callback
                        console.log('error ' , error)
                    })

                });
            },
            delMarkets(market_id){
                window.axios.post('/api/delMarkets', {market_id:this.market_id}).then(({data}) => {

                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    Event.$emit('delMarkets',market_id);
                });
            },
            setMarketResult(val){
                console.log(this.market_result,this.currentMarketId);
                //return;
                window.axios.post('/api/setMarketResult', {market_id:this.currentMarketId,market_result:val,user_id:this.$userId}).then(({data}) => {

                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    var starCountRef = this.$firebase.database().ref('/Declare');
                    var market=data.data
                    starCountRef.update({
                        market
                    }).then((data)=>{
                        //success callback
                        console.log('data ' , data)
                    }).catch((error)=>{
                        //error callback
                        console.log('error ' , error)
                    })
                    /*if (this.multi_market === '1') {
                        this.read(this.market_id);
                    }
                    else {
                        this.read1();
                    }*/
                    //Event.$emit('setResultOfMarket','');
                });
            },
            Undeclare(){
                window.axios.post('/api/unDeclare', {market_id:this.currentMarketId,user_id:this.$userId}).then(({data}) => {

                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    var starCountRef = this.$firebase.database().ref('/Declare');
                    var market=data.data
                    starCountRef.update({
                        market
                    }).then((data)=>{
                        //success callback
                        console.log('data ' , data)
                    }).catch((error)=>{
                        //error callback
                        console.log('error ' , error)
                    })
                    this.market.market_result='none';
                });
            },
            updateIsActive(){
                window.axios.post('/api/setMarketActive', {market_id:this.currentMarketId,is_active:this.market.is_active,user_id:this.$userId}).then(({data}) => {
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");

                    var starCountRef = this.$firebase.database().ref('/');
                    var marketUpdate=[];
                    marketUpdate=data.data;
                    starCountRef.update({
                        marketUpdate
                    }).then((data)=>{
                        //success callback
                        console.log('data ' , data)
                    }).catch((error)=>{
                        //error callback
                        console.log('error ' , error)
                    })
                });
            },
            updateIsUpdate(){
                this.custom_runner=this.runners;
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/setMarketUpdate', {market_id:this.currentMarketId,isUpdate:this.market.isUpdate,user_id:this.$userId}).then(({data}) => {
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");

                    if (this.multi_market === '1') {
                        this.read(this.market_id);
                    }
                    else {
                        this.read1();
                    }
                });
            },
            updateIsPlay(){
                this.custom_runner=this.runners;
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/setMarketPlay', {market_id:this.currentMarketId,isPlay:this.market.isPlay,user_id:this.$userId}).then(({data}) => {
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                   /* if (this.multi_market === '1') {
                        this.read(this.market_id);
                    }
                    else {
                        this.read1();
                    }*/
                    var starCountRef = this.$firebase.database().ref('/marketPlay/');
                    var isPlay=Number(this.market.isPlay);
                    var market_id=this.currentMarketId;
                    starCountRef.update({
                        isPlay,market_id
                    }).then((data)=>{
                        //success callback
                        console.log('data ' , data)
                    }).catch((error)=>{
                        //error callback
                        console.log('error ' , error)
                    })
                });
            },
            read(id) {
                this.currentMarketId = id;
                var send_data = {};
                send_data.type = 'get';
                send_data.table_name = 'market';
                send_data.condition = [];
                send_data.condition.push(['market_id', id], ['user_id', this.$userId]);
                window.axios.post('/api/table_edit', {parameter: JSON.stringify(send_data)}).then(({data}) => {
                    //console.log('get updated runners-------------',r_data,data);
                    if (data.data.length > 0) {
                        this.market_state = 'active_market'
                    } else {
                        this.market_state = 'deactive_market';
                    }

                });
                //this.is_show = 'show';
                window.axios.get(`/api/getRunnersOfMarketAdmin/${id}/${this.$userId}`).then(({data}) => {
                    this.runners = data.runners;
                    this.custom_runner = data.runners;
                    this.event = data.event;
                    this.market = data.market;
                    this.market_result=this.market.marketStatus;
                    this.market_management = data.market_management;
                    this.is_show = 'hide';
                    //console.log('marketdata', data);
                    //showNotification("alert-success", data.data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                });
            },
            read1() {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getEventDetail/${this.market_id}`).then(({data}) => {
                    //console.log('marketdata', data);
                    //this.is_show='hide';
                    this.read(data.data.markets[0].id);
                    this.markets = data.data.markets;
                    //showNotification("alert-success", data.data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                });
            },
            setMarket(id) {
                if (this.market_state === 'deactive_market') {
                    var send_data = {};
                    send_data.type = 'insert';
                    send_data.table_name = 'market';
                    send_data.data = {
                        'market_id': id,
                        'user_id': this.$userId,
                        'user_type':'admins',
                    };

                    //console.log(JSON.stringify(send_data));
                    window.axios.post('/api/table_edit', {parameter: JSON.stringify(send_data)}).then(({data}) => {
                        //console.log('insert-------------', data);
                        this.market_state = 'active_market'
                        Event.$emit('update_multi_market','');
                    });
                } else {
                    var send_data = {};
                    send_data.type = 'delete';
                    send_data.table_name = 'market';
                    send_data.condition = [];
                    send_data.condition.push(['market_id', id], ['user_id', this.$userId],['user_type','admins']);
                    Event.$emit('update_multi_market','');
                    window.axios.post('/api/table_edit', {parameter: JSON.stringify(send_data)}).then(({data}) => {
                        //console.log('delete-------------', data);
                        this.market_state = 'deactive_market';
                        Event.$emit('update_multi_market','');

                    });
                }

            },
            updateMarketManagement(){
                var starCountRef = this.$firebase.database().ref('/');
                var marketManagement=this.market_management;
                starCountRef.update({
                    marketManagement
                }).then((data)=>{
                    //success callback
                    console.log('data ' , data)
                }).catch((error)=>{
                    //error callback
                    console.log('error ' , error)
                })
                window.axios.post('/api/setMarketManage', {user_id: this.$userId,market_management:this.market_management}).then(({data}) => {
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");

                });
            },
            updateVol(volType,val){

                this.runners.forEach(runner=>{
                    for (var i=0;i<runner[volType].length;i++){
                        runner[volType][i]=val;
                    }
                })
                console.log(this.runners);

            },
            updateMarketVol(){
                //console.log('updated runners',this.runners);
                window.axios.post('/api/setRunnersVol', {user_id: this.$userId,runners:this.runners}).then(({data}) => {
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    var starCountRef = this.$firebase.database().ref('/');
                    var runners=data.data.runners;
                    starCountRef.update({
                        runners
                    }).then((data)=>{
                        //success callback
                        console.log('data ' , data)
                    }).catch((error)=>{
                        //error callback
                        console.log('error ' , error)
                    })

                    var matchedBet=data.data.matchedBet;
                    starCountRef.update({
                        matchedBet
                    }).then((data)=>{
                        //success callback
                        console.log('data ' , data)
                    }).catch((error)=>{
                        //error callback
                        console.log('error ' , error)
                    })
                });
            },
            create(data) {

            },
            update(id, odd, stake) {

            },
            createBetSlip(runner_id, bet_type, odd) {
                //setBetSlip();
                //Event.$emit('betSlipLoading','show');

            },
        },
        created() {
            //console.log('Create Element');
            //this.read();
            if (this.multi_market === '1') {
                this.read(this.market_id);
            }
            else {
                this.read1();
            }

        },
        components: {
            profit_compenent,sessionProfit
        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>
