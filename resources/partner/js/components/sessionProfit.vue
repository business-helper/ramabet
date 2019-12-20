<template>
    <span class="right" v-if="this.profit>=0" style="color: green">
        {{(this.profit).toFixed(2)}}
        <span v-if="this.preView=='true'" :class="this.newProfit>0?'green':'red'">
            <i class="fas fa-long-arrow-alt-right"></i>
            {{(this.newProfit).toFixed(2)}}</span>
    </span>
    <span class="right" v-else style="color: red">
        {{(this.profit).toFixed(2)}}
        <span v-if="this.preView=='true'" :class="this.newProfit>0?'green':'red'">
            <i class="fas fa-long-arrow-alt-right"></i>
            {{(this.newProfit).toFixed(2)}}</span>
    </span>
</template>
<style>
    .green{
        color: green;
    }
    .red{
        color: red;
    }
</style>
<script>
    export default {

        data() {
            return {
                profit:this.initProfit,newProfit:0,preView:'false'
            }
        },
        props: [
            'runner_id','state1','market_id','userType','initProfit'
        ],
        mounted() {
            Event.$on('deletedBetSlip', (market_id) => {
                if (this.market_id==market_id){
                    this.read();
                }

            });
            Event.$on('placedBets', (item) => {
                console.log('fancy',item);
                if (this.runner_id==item.bet_item.runner_id){
                    this.profit=item.adminRunnerPosition[this.$userId].position;
                }
            });
            /*Event.$on('placedBets', (data) => {
                var market_id=data.market_id;
                var userPosition=data.adminRunnerPosition[this.$userId];
                if (this.market_id==market_id){
                    this.preView='false';
                    this.newProfit=0;
                    userPosition.forEach(item=>{
                        if (this.runner_id==item.runner_id)this.profit=item.position;
                    });
                }

            });*/
            Event.$on('updateBetslip', (data) => {
                if (this.market_id==data.data.market_id){
                    this.read1(data.data);
                }
            });
            /*Event.$on('matchedBet',(data) => {
                if (this.market_id==data){
                    this.read();
                }
            });*/
        },
        methods:{
            read() {
                this.preView='false';
                //console.log('Auto get data');
                this.newProfit=0;
                window.axios.post('/api/getMaxLiabilityOfSession',{runner_id:this.runner_id,user_id:this.$userId,user_type:this.userType}).then(({ data }) => {
                    //console.log('profit of'+this.runner_id,data);
                    this.profit=data.data;
                    //Event.$emit('betSlipLoading','hide');
                    //showNotification("alert-success", data.message, "top", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            read1(betSlipItem) {
                //console.log('Auto get data');
                window.axios.post('/api/getProfit',{runner_id:this.runner_id,user_id:this.$userId,market_name:this.market_name}).then(({ data }) => {
                    //console.log('updated profit of',this.market_id,betSlipItem,data);
                    this.profit=data;
                    if (this.runner_id==betSlipItem.runner_id) {
                        if (betSlipItem.bet_type=='availableToBack') {
                            this.newProfit=this.profit+betSlipItem.profit_amount;
                        }else{
                            this.newProfit=this.profit+betSlipItem.exposure;
                        }
                    }else{
                        if (betSlipItem.bet_type=='availableToBack') {
                            this.newProfit=this.profit+betSlipItem.exposure;
                        }else{
                            this.newProfit=this.profit+betSlipItem.profit_amount;
                        }
                    }
                    this.preView='true';

                }).catch(function (resp) {
                    console.log(resp);
                });
            },

        },
        created() {
            //this.read();

            /*this.updateEvent1()*/
        },
        components: {

        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>