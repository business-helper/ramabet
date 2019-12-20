<template>
    <div style="height: 100%">
        <div style="margin-top: 20px" class="match_odds">
            <table class="table oddtable" style="background-color: transparent;">
                <thead>
                <tr>
                    <th style="display: flex;">
                        <div @click="setMarket(market.id)"><img :class="market_state"></div>
                        <span class="runner_name">{{this.market.marketName}}</span>
                    </th>
                    <th style="text-align: right;padding: 0;    width: 50px;">
                        <div style="text-align: center;margin-right: 0px;margin-left: auto;">
                            Back
                        </div>
                    </th>
                    <th style="text-align: left;padding: 0;    width: 50px;">
                        <div style="text-align: center;margin-right: auto;margin-left: 0px;">
                            Lay
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody style="background-color: white;">
                <tr v-for="runner in this.runners" v-bind="runner">
                    <td>
                        <profit_compenent :runner_id="runner.id"></profit_compenent>
                        {{runner.runnerName}}
                    </td>
                    <td style="padding: 1px">
                        <div class="selectTemp notranslate" style="width: 100%!important;height: 100%!important;">
                            <div v-if="runner.availableToBack.length>=1" class="left_item">
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
                    </td>
                    <td style="padding: 1px">
                        <div class="selectTemp notranslate" style="width: 100%!important;height: 100%!important;">
                            <div v-if="runner.availableToLay.length>=1" class="right_item">
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
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>

    import profit_compenent from './profit.vue'
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
                this.runners.forEach(runner=>{
                    if (runner.id===r_data){
                        this.read1();
                    }
                });
            });
            Event.$on('selectMarket', (r_data) => {
                this.read(r_data);
            });
        },
        methods:{
            read(id) {
                this.currentMarketId=id;
                var send_data={};
                send_data.type= 'get';
                send_data.table_name= 'market';
                send_data.condition=[];
                send_data.condition.push(['market_id',id],['user_id',this.$userId]);
                window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                    //console.log('get updated runners-------------',r_data,data);
                    if (data.data.length>0){
                        this.market_state='active_market'
                    } else{
                        this.market_state='deactive_market';
                    }

                });
                this.is_show='show';
                window.axios.get(`/api/getRunnersOfMarket/${id}/${this.$userId}`).then(({data}) => {
                    this.runners=data.runners;
                    /*for (var i=0;i<this.runners.length;i++){
                        var item=this.runners[i];
                        var starCountRef =  this.$firebase.database().ref('runners/'+item.id);
                        starCountRef.on('value', function(snapshot) {
                            //console.log(snapshot.val());
                            Event.$emit('update_data', item.id);
                            //console.log('updated runner',snapshot.val(),item.id);
                            //this.read(id);
                        });
                    }*/

                    this.event=data.event;
                    this.market=data.market;
                    this.is_show='hide';
                    console.log('marketdata',data);
                    //showNotification("alert-success", data.data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                });
            },
            setMarket(id){
                if (this.market_state==='deactive_market'){
                    this.market_state='active_market'
                    var send_data={};
                    send_data.type= 'insert';
                    send_data.table_name= 'market';
                    send_data.data={
                        'market_id':id,
                        'user_id':this.$userId,
                        'user_type':'admins'
                    };
                    console.log(JSON.stringify(send_data));
                    window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                        console.log('insert-------------',data);

                        Event.$emit('update_multi_market','');
                    });
                } else{
                    this.market_state='deactive_market';
                    var send_data={};
                    send_data.type= 'delete';
                    send_data.table_name= 'market';
                    send_data.condition=[];
                    send_data.condition.push(['market_id',id],['user_id',this.$userId],['user_type','admins']);
                    window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                        console.log('delete-------------',data);
                        Event.$emit('update_multi_market','');

                    });
                }

            },
            create(data){

            },
            update(id,odd,stake) {

            },
            createBetSlip(runner_id,bet_type,odd){
                setBetSlip();
                Event.$emit('betSlipLoading','show');
                window.axios.post('/api/createBetSlip',{runner_id:runner_id,bet_type:bet_type,odd:odd,user_id:this.$userId,market_name:this.market_name}).then(({ data }) => {
                    //console.log(data);
                    if(data.state===0){
                        Event.$emit('createBetSlip', data.data);
                    }
                    Event.$emit('betSlipLoading','hide');
                    //showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
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
            profit_compenent
        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>