<template>
    <div style="height: 100%">
        <div v-for="market in markets">
            <div v-if="market.marketStatus=='OPEN' || market.marketStatus=='SUSPENDED'" class="panel-group full-body" id="accordion_19" role="tablist" aria-multiselectable="true">
                <div class="panel">
                    <div class="panel-heading" role="tab" :id="'headingOne_'+market.id" style="background-color: #082a49; color: white;">
                        <span style="font-size: 12px;font-weight: 600; text-align: center; padding: 0;" class="panel-title">
                            <a role="button" data-toggle="collapse" :href="'#collapseOne_'+market.id" aria-expanded="false" aria-controls="collapseOne_19" class="collapsed" style="    padding: 5px 15px;">
                                {{market.marketName}}-{{market.marketStatus}}
                            </a>
                        </span>
                    </div>
                    <div :id="'collapseOne_'+market.id" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_19" aria-expanded="false" style="height: 0px;">
                        <div class="panel-body" style="padding: 0">
                            <market :market_id="market.id"></market>
                        </div>
                        <!--<betslip :market_id="market.id"></betslip>-->
                    </div>
                </div>

            </div>
        </div>
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
            Event.$on('removeEvent', (r_data) => {
                this.read1();
            });
            console.log('Event Component mounted.');
        },
        methods:{
            read1(){
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getEventDetail/${this.market_id}`).then(({data}) => {
                    this.markets=data.data.markets.splice(1, data.data.markets.length);
                    //console.log('marketdata1',this.markets);
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
