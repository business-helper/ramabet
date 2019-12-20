<template>
    <div class="container">
        updating data
    </div>
</template>

<script>
    export default {

        data() {
            return {
                user_data:[],league_list:[],event_list:'',market_list:'',market_catalogue_list:0,line_market_list:0,timer:0
            }
        },
        props: [
            'sport_id','state1'
        ],
        mounted() {
            this.$nextTick(function () {
                window.setInterval(() => {
                    this.updateLeague();
                },20000);
                window.setInterval(() => {
                    this.updateEvent();
                },30000);
                window.setInterval(() => {
                    this.updateMarket();
                },10000);
                /*window.setInterval(() => {
                    this.updateRunner();
                },300);*/
            })
        },
        methods:{
            updateLeague(){
                window.axios.get('api/betfair/v1/competition_list').then(({ data }) => {
                    //console.log('updateLeagues-------------',data);
                    this.league_list=data;
                    //console.log('updateLeagues-------------',data);
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            updateEvent(){
                this.timer++;
                console.log(this.timer,this.league_list);
                if (this.timer>4){
                    window.location.href='/updatedata'
                }
                this.league_list.forEach(function(league){
                    //console.log('getLeagueId********',league_id);
                    window.axios.get(`/api/betfair/v1/event_list_by_competition/${league.id}`).then(({ data }) => {
                        //console.log('updateEventOfLeague-------------',data);
                        //this.event_list=data.data;
                    }).catch(function (resp) {
                        console.log(resp);
                    });
                    //console.log(sport.sport_id);
                });
            },
            updateMarket(){
                if (this.market_catalogue_list==undefined)this.market_catalogue_list=0;

                window.axios.get(`/api/betfair/v1/market_catalogue_list/${this.market_catalogue_list}`,).then(({ data }) => {
                    //console.log('MatchOdd------------',data);
                    console.log('MatchOdd------------',this.market_catalogue_list,data);
                    this.market_catalogue_list=data.count;
                    //this.market_list=data.data;
                }).catch(function (resp) {
                    console.log(resp);
                });
                /*window.axios.get(`/api/betfair/v1/line_market_list/${this.line_market_list}`,).then(({ data }) => {
                    console.log('Another Markets------------',data);
                    this.line_market_list=data.count;
                    //this.market_list=data.data;
                }).catch(function (resp) {
                    console.log(resp);
                });*/



            },

        },
        created() {
            this.updateLeague();
            this.updateEvent();
            this.updateMarket();

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