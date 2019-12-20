<template>
    <div class="container-fluid" style="padding-bottom: 200px;">
        <h3 v-if="this.markets.length==0">You don't have Open Bets in any Market yet.</h3>
        <div v-else style="display: flex">
            <div v-if="this.markets.length>0" style="overflow: auto;flex: 1">
                <eventdetail v-for="market in markets.slice(0,1)"  multi_market="1" :market_id="market.id" :key="market.id" ></eventdetail>

                <eventdetail v-for="market in markets.slice(1)"  multi_market="1" :market_id="market.id" :key="market.id"></eventdetail>
                <betslipNew v-if="widthOfWindow<850"></betslipNew>
            </div>
            <div v-if="widthOfWindow>850" style="flex: 1">
                <betslipNew  class="laptop_betslip" ></betslipNew>
            </div>

        </div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
                runners:[],is_show:'show',event:[],market:[],markets:[],currentMarketId:'',widthOfWindow:900
            }
        },
        props: [
            'market_id'
        ],
        mounted() {
            console.log('Multi market Component mounted.');
            Event.$on('marketUpdate', (market) => {
                if (this.$isSuper==0)return;
                if (market.is_active==1){
                    this.read1()

                } else{
                    let index = this.markets.findIndex(item => item.id === market.id);
                    this.markets.splice(index, 1);
                }

            });
            Event.$on('update_multi_market', (data) => {
                this.read1();
            });
            Event.$on('changeWidth', (data) => {
                this.widthOfWindow=data;
                //console.log(data);
            });
            Event.$on('placedBets',(data) => {
                this.read1();
            });
            Event.$on('delPlacedBets',(data) => {
                this.read1();
            });
        },
        methods:{
            read1(){
                window.axios.get(`/api/getMyAccountMarketsOfBetting/${this.$userId}`).then(({data}) => {
                    this.markets=data.data;
                    console.log('my markets',this.markets);
                });
            },
            create(data){
            },
            update(id,odd,stake) {

            }
        },
        created() {
            //console.log('Create Element');
            //this.read();
            this.widthOfWindow=window.innerWidth;
            this.read1();
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