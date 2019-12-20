<template>
    <span class="" v-if="this.profit>=0" style="color: green">
        {{(this.profit).toFixed(2)}}
        <span v-if="this.preView=='true'" :class="this.newProfit>0?'green':'red'">
            <i class="fas fa-long-arrow-alt-right"></i>
            {{(this.newProfit).toFixed(2)}}</span>
    </span>
    <span class="" v-else style="color: red">
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
            'runner_id','state1','market_id','marketType','initProfit'
        ],
        mounted() {
            Event.$on('deletedBetSlip', (item) => {
                this.preView='false';
                if (this.market_id==item.market_id){
                    this.preView='false';
                    this.newProfit=0;
                    item.userRunnerPosition.forEach(item=>{
                        if (this.runner_id==item.runner_id)this.profit=item.position;
                    });
                }
            });
            Event.$on('profitReset', (market_id) => {
                this.preView='false';
                /*if (this.market_id==market_id){
                    this.preView='false';
                }*/

            });
            Event.$on('placedBets', (item) => {
                //item.market_id,item.userRunnerPosition
                if (this.market_id==item.market_id){
                    this.preView='false';
                    this.newProfit=0;
                    item.userRunnerPosition.forEach(item=>{
                        if (this.runner_id==item.runner_id)this.profit=item.position;
                    });
                }
            });
            Event.$on('matchedBetProfit', (item) => {
                //item.market_id,item.userRunnerPosition
                if (this.market_id==item.market_id){
                    this.preView='false';
                    this.newProfit=0;
                    item.userRunnerPosition.forEach(item=>{
                        if (this.runner_id==item.runner_id)this.profit=item.position;
                    });
                }
            });
            // Event.$on('setProfitOfMarket', (data) => {
            //     if (this.market_id==data){
            //         this.read();
            //     }
            // });
            Event.$on('updateBetslip', (data) => {
                console.log(this.market_id,data.market_id);
                if (this.state1==1)return;
                if (this.marketType=='fancy'){
                    if (this.runner_id==data.runner_id){
                        this.read1(data);
                    }
                }else{
                    if (this.market_id==data.market_id){
                        this.read1(data);
                    }
                }

            });
        },
        methods:{
            read() {
                this.preView='false';
                //console.log('Auto get data');
                this.newProfit=0;
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/getProfit',{runner_id:this.runner_id,user_id:this.$userId,market_name:this.market_name}).then(({ data }) => {
                    //console.log('profit of'+this.runner_id,data);
                    this.profit=data;
                    //Event.$emit('betSlipLoading','hide');
                    //showNotification("alert-success", data.message, "top", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            read1(betSlipItem) {
                //console.log('Auto get data');
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
                /*window.axios.post('/api/getProfit',{runner_id:this.runner_id,user_id:this.$userId,market_name:this.market_name}).then(({ data }) => {
                    //console.log('updated profit of',this.market_id,betSlipItem,data);
                    this.profit=data;


                }).catch(function (resp) {
                    console.log(resp);
                });*/
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
