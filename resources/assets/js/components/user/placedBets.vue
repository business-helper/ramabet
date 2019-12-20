<template>
    <div style="overflow: hidden; height: 100%;">
        <div :class="is_load" style="position: absolute;width: 100%;height: 100%;background-color: #777a;z-index: 1;">
            <div  style=""><div class="lds-facebook" ><div></div><div></div><div></div></div></div>
        </div>
        <div :class="nodata">
            <strong>You have no bets</strong>
            <span style="color: #2aa033;"></span>
        </div>
        <placedbet
                v-for="placedbet in placedBets"
                v-bind="placedbet"
                :key="placedbet.id"
                :time_status="time_status"
                @delete_placed="del"
                >
        </placedbet>
    </div>
</template>
<script>
    function PlacedBet(item) {
        this.id = item.id;
        this.odd = item.odd;
        this.bet_type = item.bet_type;
        this.eventName = item.eventName;
        this.marketName = item.marketName;
        this.runnerName = item.runnerName;
        this.stake = item.stake;
        this.at_update = item.at_update;
        this.event_id = item.event_id;
    }
    import placedbet from './placedBet.vue';
    export default {
        data() {
            return {
                placedBets: [],is_load:'show',nodata:'show'
            }
        },
        props: [
            'time_status'
        ],

        mounted() {
            Event.$on('placedBetLoading',(data) => {
                this.is_load=data;
            });
            Event.$on('placedBets',(data) => {
                this.read();
            });
            /*Event.$on('userLogged',(userId) => {
                this.$userId=userId;
                this.read();
            });*/
        },
        methods:{
            read() {
                this.is_load='show';
                window.axios.get(`/api/getPlacedBetSlips/${this.time_status}/${this.$userId}`).then(({ data }) => {
                     //console.log('getdata liveBet',data,this.$userId,this.time_status)
                    this.placedBets=[];
                    data.forEach(placedBet_item => {
                        this.placedBets.push(new PlacedBet(placedBet_item));
                    });
                    this.is_load='hide';
                    if (this.placedBets.length==0){
                        this.nodata='show';
                    }
                    else{
                        this.nodata='hide';
                    }
                });
            },
            del(id) {
                // alert(id);
                this.is_load='show';
                window.axios.get(`/api/delPlacedBetSlip/${id}`).then((data) => {
                    if (data.data.state==0){
                        let index = this.placedBets.findIndex(item => item.id === id);
                        this.placedBets.splice(index, 1);
                        Event.$emit('updateBalance', 1);
                    }
                    else{
                        showNotification('alert-success',data.data.message,'top','right','animated fadeInRight','animated fadeOutRight');
                    }
                    this.is_load='hide';
                });

            },
        },
        created() {
            // console.log('Create Element');
            //this.read();
        },
        components: {
            placedbet
        },
        watch: {
        },
    }
</script>
<style>

</style>