<template>
    <div style="height: 100%">
        <div v-if="this.market.marketStatus=='OPEN'" style="margin-top: 20px" class="match_odds">
            <table class="table oddtable" style="background-color: transparent;">
                <thead>
                <tr>
                    <th style="display: flex;">
                        <div @click="setMarket(market.id)"><img :class="market_state"></div>
                        <span class="runner_name">{{this.market.marketName}}</span>
                    </th>
                    <th style="text-align: right;padding: 0;">
                        <div style="text-align: center;margin-right: 0px;margin-left: auto;">
                            Back
                        </div>
                    </th>
                    <th style="text-align: left;padding: 0;">
                        <div style="text-align: center;margin-right: auto;margin-left: 0px;">
                            Lay
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody style="background-color: white;">
                <tr v-for="runner in this.runners" v-bind="runner">
                    <td>{{runner.runnerName}}</td>
                    <td style="padding: 1px">
                        <div v-if="market.marketStatus=='OPEN'" class="selectTemp selectTemp_admin notranslate" style="width: 100%!important;height: 100%!important;">
                            <div v-if="runner.availableToBack.length>=1" class="left_item" >
                                <span>
                                    <p class="price">{{runner.availableToBack[0].price}}</p>
                                </span>
                            </div>
                            <div v-else class="left_item">
                                <span>
                                    <p class="price">--</p>
                                </span>

                            </div>
                        </div>
                        <div v-else class="selectTemp notranslate" style="background-color: #ffa2a0;justify-content: center; border: solid 1px; align-items: center;">
                            {{market.marketStatus}}
                        </div>
                    </td>
                    <td style="padding: 1px">
                        <div v-if="market.marketStatus=='OPEN'" class="selectTemp selectTemp_admin notranslate" style="width: 100%!important;height: 100%!important;">
                            <div v-if="runner.availableToLay.length>=1" class="right_item" >
                                <span>
                                    <p class="price">{{runner.availableToLay[0].price}}</p>
                                </span>
                            </div>
                            <div v-else class="right_item">
                               <span>
                                    <p class="price">--</p>
                                </span>
                            </div>
                        </div>
                        <div v-else class="selectTemp notranslate" style="background-color: #ffa2a0;justify-content: center; border: solid 1px; align-items: center;">
                            {{market.marketStatus}}
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>


    export default {
        data() {
            return {
                runners:[],is_show:'show',event:[],market:[],markets:[],currentMarketId:'',market_state:'deactive_market'
            }
        },
        props: [
            'market_id'
        ],
        mounted() {
            console.log('Event Component mounted.');
            Event.$on('update_odd', (r_data) => {
                let index = this.runners.findIndex(item => item.id === r_data.id);
                if (index>-1){
                    this.runners[index][r_data.type]=r_data[r_data.type];
                }
            });
            Event.$on('selectMarket', (r_data) => {
                this.read(r_data);
            });
        },
        methods:{
            read(id) {
                this.currentMarketId=id;
                this.is_show='show';
                window.axios.get(`/api/getRunnersOfMarket/${id}/${this.$userId}`).then(({data}) => {
                    this.runners=data.runners;
                    this.event=data.event;
                    this.market=data.market;
                    this.this.market_state=data.multi_market;
                    this.is_show='hide';
                    console.log('marketdata',data);
                    //showNotification("alert-success", data.data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                });
            },
            setMarket(id){


            },
            create(data){

            },
            update(id,odd,stake) {

            },
            createBetSlip(runner_id,bet_type,odd){
                setBetSlip();
                Event.$emit('betSlipLoading','show');
                window.axios.post('/api/createBetSlip',{runner_id:runner_id,bet_type:bet_type,odd:odd,user_id:this.$userId,market_name:this.market_name}).then(({ data }) => {

                    // console.log('testestes-------',data);
                    if(data.state===0){
                        Event.$emit('createBetSlip', data.data);
                    }
                    Event.$emit('betSlipLoading','hide');
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
        },
        created() {
            //console.log('Create Element');
            //this.read();
            this.read(this.market_id);
        },
        components: {
            //BetSlipItem
        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>