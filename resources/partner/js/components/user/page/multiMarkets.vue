<template>
    <div class="container-fluid" style="padding-bottom: 200px;padding-top: 40px">
        <h3 v-if="this.markets.length==0">There is no any market</h3>
        <eventdetail v-for="market in markets.slice(0,1)"  multi_market="1" :market_id="market.id" :key="market.id" @delete_market="del"></eventdetail>
        <betslipNew></betslipNew>
        <eventdetail v-for="market in markets.slice(1)"  multi_market="1" :market_id="market.id" :key="market.id" @delete_market="del"></eventdetail>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                runners:[],is_show:'show',event:[],market:[],markets:[],currentMarketId:''
            }
        },
        props: [
            'market_id'
        ],
        mounted() {
            console.log('Event Component mounted.');
            Event.$on('update_multi_market', (data) => {
                this.read1();
            });
            Event.$on('delete_market', (data) => {
                this.del(data);
            });
        },
        methods:{
            read1(){
                window.axios.get(`/api/getMyMarkets/${userID}/admins`).then(({data}) => {
                    console.log('my markets',this.markets);
                    this.markets=data.data.markets;
                });
            },
            del(id){
                let index = this.markets.findIndex(item => item.id === id);
                this.markets.splice(index, 1);
            },
            create(data){
            },
            update(id,odd,stake) {

            }
        },
        created() {
            //console.log('Create Element');
            //this.read();
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