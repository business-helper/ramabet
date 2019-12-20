<template>
    <div class="open_bets" style="">
        <div class="part_teams" style="margin: 0;text-align: center;">
            <router-link :to="'/event/'+event_id">
                <div class="">{{eventName}}</div>
            </router-link>
            <p class="bet_info">{{at_update}}</p>
        </div>
        <div class="open_bets_header">
            <span class="bet_match_name">Runner Name</span>
            <span class="bet_odd">Odds</span>
            <span class="bet_stake">Stake</span>
            <span class="bet_profit">Profit/Liability</span>
        </div>
        <div id="14_bet" :class="bet_type" class="open_bets_body">
            <span class="bet_match_name">{{runnerName}}</span>
            <span class="bet_odd">{{odd}}</span>
            <span class="bet_stake">{{stake}}</span>
            <span class="bet_profit">{{profit}}</span>
            <div class="btn btn-danger bet_close" :class="is_show_close" @click="del">
                <i class="fas fa-times"></i>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

        props: [
            'id','bet_type','odd','eventName','marketName','is_del','runnerName','stake','at_update','time_status','event_id'
        ],
        data(){
            return{
                profit:this.odd*this.stake,
                odd_local: this.odd,
                stake_local:this.stake,
                bet_type_name:''
            }
        },
        mounted() {
            console.log('Betslipe_item Component mounted.')
        },
        methods: {
            del() {
                this.$emit('delete_placed', this.id);
            },
            calculate(){
                this.mute = true;
                this.profit=parseFloat(this.odd_local)*parseFloat(this.stake_local);
                this.profit=this.profit.toFixed(2)
                this.mute = false;
                //console.log('update');
                //alert('111');
                this.$emit('update',this.id,this.odd_local,this.stake_local);
            },
        },
        created(){
            if(this.time_status=='0'){
                this.is_show_close='show';
            }
            else{
                this.is_show_close='hide';
            }
        }
    }
</script>
<style>

</style>