<template>
    <div class="">
        <div class="lds-facebook" :class="is_show">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div v-if="(this.market.marketStatus=='OPEN' || this.market.marketStatus=='SUSPENDED') && this.market.marketType!='fancy'" class="panel-group full-body" id="accordion_19" role="tablist" aria-multiselectable="true">
            <div class="panel">
                <div class="panel-heading market_title" role="tab" :id="'headingOne_'+this.market.id"
                     >
                    <span style="font-size: 12px;font-weight: 600;text-align: center; padding: 0;" class="panel-title">
                        <a role="button" data-toggle="collapse" :href="'#collapseOne_'+market.id" aria-expanded="false"
                           aria-controls="collapseOne_19" class="collapsed" style="    padding: 5px 15px;">
                            {{this.event.sportName}}-{{this.event.name}}-{{this.market.marketStatus}}
                            <span class="">
                                <span v-for="runner in this.runners" >{{runner.runnerName}}:<profit_compenent :runner_id="runner.id" :market_id="market.id" state1="1"  :initProfit="runner.profit"></profit_compenent></span>
                            </span>

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
                            <th  class="oddTableHeader" style="text-align: right;padding: 0;">
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
                            <td style="">
                                <div style="display: flex;padding-right: 10px;">
                                    <div style="flex: 1;"> {{runner.runnerName}}</div>
                                   <div>
                                       <profit_compenent :runner_id="runner.id" :market_id="market.id"  :initProfit="runner.profit"></profit_compenent>
                                   </div>
                                </div>



                            </td>
                            <td style="padding: 1px">
                                <div v-if="market.isPlay==0" style="position: absolute; z-index: 1; background: rgba(171, 157, 157, .9); width: 100%; height: 100%; text-align: center; vertical-align: middle; line-height: 40px; color: red;">

                                </div>
                                <div v-if="market.marketStatus=='OPEN'" class="selectTemp notranslate"
                                     style="justify-content: flex-end;-webkit-justify-content: flex-end">
                                    <transition name="slide-fade" mode="out-in">
                                        <div v-if="runner.availableToBack.length>=3" class="left_item mobile_hide" :key="runner.availableToBack[2].price+runner.availableToBack[2].size"
                                             @click="createBetSlip(runner,'availableToBack',runner.availableToBack[2].price)">
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
                                             @click="createBetSlip(runner,'availableToBack',runner.availableToBack[1].price)" :key="runner.availableToBack[1].price+runner.availableToBack[1].size">
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
                                             @click="createBetSlip(runner,'availableToBack',runner.availableToBack[0].price)" :key="runner.availableToBack[0].price+runner.availableToBack[0].size">
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
                                     style="font-size: 14px;background-color: rgba(100, 100, 100, 0.6); color: white; font-weight: 500; justify-content: center; border: 1px solid; align-items: center;">
                                    {{market.marketStatus}}
                                </div>
                            </td>
                            <td style="padding: 1px">
                                <div v-if="market.isPlay==0" style="position: absolute; z-index: 1; background: rgba(171, 157, 157, .9); width: 100%; height: 100%; text-align: center; vertical-align: middle; line-height: 40px; color: red;">

                                </div>
                                <div v-if="market.marketStatus=='OPEN'" class="selectTemp notranslate"
                                     style="">
                                    <transition name="slide-fade" mode="out-in">
                                        <div v-if="runner.availableToLay.length>=1" class="right_item"
                                             @click="createBetSlip(runner,'availableToLay',runner.availableToLay[0].price)" :key="runner.availableToLay[0].price+runner.availableToLay[0].size">
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
                                             @click="createBetSlip(runner,'availableToLay',runner.availableToLay[1].price)" :key="runner.availableToLay[1].price+runner.availableToLay[1].size">
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
                                             @click="createBetSlip(runner,'availableToLay',runner.availableToLay[2].price)" :key="runner.availableToLay[2].price+runner.availableToLay[2].size">
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
                                     style="font-size: 14px;background-color: rgba(100, 100, 100, 0.6); color: white; font-weight: 500; justify-content: center; border: 1px solid; align-items: center;">
                                    {{market.marketStatus}}
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <betslip :market_id="market.id" isMobile="1"></betslip>
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
                    <div style="display: flex; padding: 0 5px;font-weight: bolder;border-bottom: solid 1px #e7e7e7">
                        <div style="flex: 1;">
                            <div style="display: flex;">
                                <div @click="setMarket(market.id)"><img :class="market_state"></div>
                                <span class="runner_name">{{this.market.marketName}}</span>
                                <span v-if="market.inPlay==1" class="progress_title inplay blink_me">:<i class="fas fa-play-circle"></i>InPlay</span>
                            </div>
                        </div>
                        <div  class="" style="text-align: right;padding: 0;width: 120px;">
                            <div style="display: flex">
                                <div style="text-align: center;flex: 1;">
                                    No
                                </div>
                                <div style="text-align: center;flex: 1;">
                                    Yes
                                </div>
                            </div>

                        </div>
                        <div class="" style="text-align: left;padding: 0;width: 60px">

                        </div>
                    </div>

                    <div v-for="runner in this.runners" v-bind="runner" :id="'runner'+runner.id" v-if="runner.runnerStatus!='CANCELED' && runner.runnerStatus!='CLOSED' && runner.is_show==true">
                        <div style="display: flex; padding: 1px 5px;border-bottom: solid 1px #e7e7e7">
                            <div style="flex: 1;align-self: center;padding-right: 5px">
                                <sessionProfit :runner_id="runner.id" :market_id="market.id" marketType="fancy" userType="users" class="right" :initProfit="runner.profit"></sessionProfit>
                                {{runner.runnerName}}
                            </div>
                            <div class="" style="text-align: right;padding: 0;width: 120px;position: relative;height: 38px;">
                                <div class="selectTemp">
                                    <div class=" notranslate"
                                         style="justify-content: flex-end;-webkit-justify-content: flex-start">
                                        <transition name="slide-fade" mode="out-in">
                                            <div v-if="runner.availableToLay.length>=1" class="right_item"
                                                 @click="createBetSlip(runner,'availableToLay',runner.availableToLay[0].size/100+1,runner.availableToLay[0].price)" :key="runner.availableToLay[0].price+runner.availableToLay[0].size">
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
                                                 @click="createBetSlip(runner,'availableToBack',runner.availableToBack[0].size/100+1,runner.availableToBack[0].price)" :key="runner.availableToBack[0].price+runner.availableToBack[0].size">
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
                                <div v-if="runner.runnerStatus=='SUSPENDED'" class="selectTemp notranslate"
                                     style="font-size: 14px;background-color: rgba(100, 100, 100, 0.6); color: white; font-weight: 500; justify-content: center; border: 1px solid; align-items: center;">
                                    {{runner.runnerStatus}}
                                </div>
                            </div>
                            <div class="" style="text-align: left;padding: 0;width: 60px;align-self: center">
                                <button type="button" class="btn bg-green waves-effect" style="margin: auto" v-on:click="getScoreBook(runner.id,runner.runnerName)">BOOK</button>
                            </div>
                        </div>
                        <betslip :runner_id="runner.id" :market_id="market.id" type="fancy" isMobile="1"></betslip>
                    </div>


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
                                <tr v-for="item in this.scoreBook" v-bind:key="item">
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
                is_show: 'show',
                event: [],
                market: [],
                markets: [],
                currentMarketId: '',showMarket:'show',
                market_state: 'deactive_market',
                scoreBook:[],scoreBookRunner:''
            }
        },
        props: [
            'market_id', 'multi_market'
        ],
        mounted() {


            //console.log('Event Component mounted.');
            var starCountRef = this.$firebase.database().ref('/fancyBets');
            starCountRef.on('value', function (snapshot) {
                Event.$emit('getFancyBets',snapshot.val());
            });
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
            Event.$on('getFancyBets', (r_data) => {
                //console.log('get fancy',typeof r_data,r_data);
                if (r_data==undefined)return;
                r_data.forEach(fancyItem=>{
                    let index = this.runners.findIndex(item => item.id === fancyItem.id);
                    if (index>-1){
                        this.runners[index].availableToLay=JSON.parse(fancyItem.availableToLay);
                        this.runners[index].availableToBack=JSON.parse(fancyItem.availableToBack);
                        this.runners[index].runnerStatus=fancyItem.runnerStatus;

                    }else{
                        if (fancyItem.market_id==this.market.id){
                            var tempRunner=JSON.parse(JSON.stringify(fancyItem));
                            tempRunner.availableToLay=JSON.parse(fancyItem.availableToLay);
                            tempRunner.availableToBack=JSON.parse(fancyItem.availableToBack);
                            this.runners.push(tempRunner);
                            console.log(tempRunner);
                        }
                    }
                });
            });
            Event.$on('marketManagement',(marketManagement) => {

                if (this.market.id==marketManagement.market_id){
                    //console.log( this.market,marketManagement.delaySec);
                    this.market.delaySec=marketManagement.delaySec;

                }

            });
            Event.$on('sportManagement',(marketManagement) => {

                //this.is_show = 'show';
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getRunnersOfMarket/${this.market_id}/${this.$userId}`).then(({data}) => {
                    this.runners = data.runners;
                    this.event = data.event;
                    this.market = data.market;
                    this.market_state = data.multi_market;
                    //console.log('marketdata', data);
                    //showNotification("alert-success", data.data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                });

            });
            Event.$on('update_odd', (r_data) => {
                let index = this.runners.findIndex(item => item.id === r_data.id);
                if (index>-1){
                    this.runners[index][r_data.type]=r_data[r_data.type];
                    //this.read1();
                    // console.log('updated runner from api',r_data.type,this.runners[index],r_data.runner);
                    // this.runners[index]=r_data.runner;
                }
            });
            Event.$on('selectMarket', (r_data) => {
                this.read(r_data);
            });
            Event.$on('EditMarket', (r_data) => {
                this.read(r_data);
            });
            Event.$on('placedBets', (data) => {
                if (this.currentMarketId===data){
                    this.read(data);
                }
            });
            Event.$on('matchedBet', (data) => {
                if (this.currentMarketId===data){
                    this.read(data);
                }
            });
            Event.$on('marketPlay', (data) => {
                if (this.currentMarketId==data.market_id){
                    this.market.isPlay=data.isPlay;
                }
            });
            Event.$on('removeEvent',(data) => {
                this.read(this.currentMarketId);
            });
        },
        methods: {
            getScoreBook(runner_id,runnerName){
                console.log(runner_id)
                //Event.$emit('scoreBook',runner_id,runnerName);
                this.scoreBookRunner=runnerName;
                this.readScoreBook(runner_id);
            },
            readScoreBook(runner_id){
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/getScoreBook',{runner_id:runner_id,user_id:this.$userId,user_type:'users'}).then(({ data }) => {
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
            read(id) {
                this.currentMarketId = id;
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getRunnersOfMarket/${id}/${this.$userId}`).then(({data}) => {
                    this.runners = data.runners;
                    this.event = data.event;
                    this.market = data.market;
                    this.market_state = data.multi_market;
                    this.is_show = 'hide';
                });
            },
            read1() {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getEventDetail/${this.market_id}`).then(({data}) => {
                    //console.log('marketdata', data);
                    //this.is_show='hide';
                    this.read(data.data.markets[0].id);
                    this.markets = data.data.markets;
                    //showNotification("alert-success", data.data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                });
            },
            setMarket(id) {
                var rand=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+rand;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+rand+this.$User.login_session+'tcgtchkmk1014');
                var send_data={
                    'market_id':id,
                    'user_id':this.$userId,
                    'user_type':'users'
                };
                window.axios.post('/api/v1/setMultiMarket', send_data).then(({ data }) => {
                    this.market_state=data.message;
                });

            },

            create(data) {

            },
            update(id, odd, stake) {

            },
            createBetSlip(runner, bet_type, odd,score=0) {
                //setBetSlip();
                //Event.$emit('betSlipLoading','show');
                /*if (this.market.isPlay==0){
                    showNotification("alert-success", 'Sorry but you can not place bet right now.', "top", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    return;
                }*/
                var data={
                    runner_id: runner.id,
                    market_id: this.market.id,
                    runnerName: runner.runnerName,
                    bet_type: bet_type,
                    odd: odd,
                    score: score,
                    user_id: this.$userId,
                    marketName: this.market.marketName,
                    marketType:this.market.marketType,
                    delaySec:this.market.delaySec
                };
                Event.$emit('createBetSlip', data);

                Event.$emit('profitReset', data);
                /*window.axios.post('/api/createBetSlip', {
                    runner_id: runner_id,
                    bet_type: bet_type,
                    odd: odd,
                    user_id: this.$userId,
                    market_name: this.market_name
                }).then(({data}) => {
                    //console.log(data);
                    if (data.state === 0) {
                        Event.$emit('createBetSlip', data.data);
                        Event.$emit('profitReset', data.data);
                    }else{
                        showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    }
                    //Event.$emit('betSlipLoading','hide');
                    //showNotification("alert-success", data.message, "top", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }).catch(function (resp) {
                    console.log(resp);
                });*/
            },
        },
        created() {
            //console.log('Create Element');
            //this.read();
            this.read(this.market_id);
            /*if (this.multi_market == '1') {
                this.read(this.market_id);
            }
            else {
                this.read1();
            }*/

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
