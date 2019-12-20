<style>
    .backSlipHeader .item20 {
        width: 100%;
    }
    .bet_input .btn{
        margin-bottom: 4px;
    }
</style>
<template>
    <div style="padding: 5px" class="betslip_item">



        <!--<div class="part_teams" style="text-align: left;padding-left: 10px"><router-link :to="'/event/'+event_id">{{eventName}}</router-link></div>-->
        <div :class="bet_type" style="padding: 5px">
            <div class="btn btn-danger betslip_close right" @click="del()"><i class="fas fa-times"></i></div>
            <div style="text-align: left;padding-left: 5px">
                <!--<div class="bet_type" :class="bet_type"></div>-->
                <span>{{this.bet_type_name}}</span>
            </div>
            <div class="" style="padding-left: 5px;display:flex;justify-content: space-between; ">
                <span>{{runnerName}}</span>
                <div class="item20" style="height:auto;">
                    <div>Profit</div>
                    <div class="" style="line-height: 34px;width: 100%"><span class="price" style="color: rgb(0, 124, 14);font-weight: bold;">{{this.profit}}</span>
                    </div>
                </div>
                <div class="item20" style="height:auto;">
                    <div>Loss</div>
                    <div class="" style="line-height: 34px;width: 100%"><span class="price" style="font-weight: bold; color: red;">{{this.loss}}</span></div>
                </div>
                <span style="float: right;">{{marketName}}</span>
            </div>
            <div class="backSlipHeader" style="display: flex;width: 100%;justify-content: space-around;height:60px;">
                <div v-if="this.marketType!='fancy'" class="item20" style="width: 100%;">
                    <div style="padding-left:10px;width: 100%;text-align: left">Odds</div>
                    <div class="item20" style="padding-right: 5px;width: 100%;height: 35px;display: flex;justify-content: space-between;">
                        <span class="fa fa-minus btn bg-red waves-effect" style="font-size: 11px;padding: 11px" @click="desodds"></span>
                        <input autocomplete="false" class="odds" name="odds" style="width: 100%;height: 100%;" type="number" v-model="odd_local" v-on:change="calculate()" v-on:keyup="calculate()">
                        <span class="fa fa-plus btn bg-light-green waves-effect" style="font-size: 11px;padding: 11px;background: #aade12;" @click="incodds"></span>
                    </div>
                </div>
                <div v-else class="" style="width: fit-content;    white-space: nowrap;">
                    <div class="" style="margin-top: 26px">
                        {{this.score}} at {{(this.odd*100-100).toFixed(0)}}
                    </div>
                </div>
                <div class="item20" style="width: 100%;">
                    <div style="padding-left:10px;width: 100%;text-align: left">Stake</div>
                    <div class="item20" style="padding-left: 5px;width: 100%;height: 35px;display: flex;justify-content: space-between;">
                        <span class="fa fa-minus btn bg-red waves-effect" style="font-size: 11px;padding: 11px" @click="desstake"></span>
                        <input autocomplete="false" class="stake" name="stake" style="width: 100%;height: 100%;" type="number" v-on:change="calculate()" v-on:keyup="calculate()" v-model="stake_local">
                        <span class="fa fa-plus btn bg-light-green waves-effect" style="font-size: 11px;padding: 11px;background: #aade12;" @click="incstake" ></span>
                    </div>
                </div>
            </div>
            <div class="bet_input" style="display: flex;background-color:#fff; padding: 5px;flex-flow: wrap;    justify-content: space-between;">
                <div v-for="item in this.stakes" class="btn btn-danger betslip_btn" @click="incOdd(item.amount)">{{item.name}}</div>
                <div class="btn btn-default clear" style="text-align: center" @click="setOdd(0)">Clear</div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'bet_type','odd','eventName','marketName','is_del','runnerName','stake','max_stake','min_stake','event_id','market_id','runner_id','delaySec','marketType','score'
        ],
        data(){
            return{
                profit:0,
                odd_local: this.odd,
                stake_local:this.stake,
                bet_type_name:'',
                loss: 0,
                stakes:[100,500,1000,5000,10000,50000]
            }
        },
        mounted() {
            console.log('Betslipe_item Component mounted.')
            Event.$on('setStake', (data) => {
                this.stakes=[];
                this.stakes=data;
                this.$User.stake=JSON.stringify(data);
            });
        },
        methods: {
            getStakeString(val){
                if (val<1000) return val;
                if (val<100000) {
                    val=val/1000+'K';
                    return val
                }
                val=val/100000+'L';
                return val
            },
            incstake(){
                this.stake_local = parseFloat(this.stake_local) + 1;
                this.stake_local = this.stake_local.toFixed(2);
                this.calculate();
            },
            desstake(){
                this.stake_local = parseFloat(this.stake_local) - 1;
                if (this.stake_local<0)this.stake_local=0;
                this.stake_local = this.stake_local.toFixed(2);
                this.calculate();
            },
            incodds(){
                this.odd_local = parseFloat(this.odd_local) + 0.01;
                this.odd_local = this.odd_local.toFixed(2);
                this.calculate();
            },
            desodds(){
                if (this.odd_local<1.01){
                    this.odd_local=1.01;
                }
                this.odd_local = parseFloat(this.odd_local) - 0.01;
                this.odd_local = this.odd_local.toFixed(2);
                this.calculate();
            },
            del() {
                this.$emit('delete','');
            },
            calculate(){
                this.mute = true;
                if(this.bet_type_name == "Bet For"){
                    this.profit=parseFloat(this.odd_local)*parseFloat(this.stake_local) - parseFloat(this.stake_local);
                    this.profit=this.profit.toFixed(2);
                    this.loss = parseFloat(this.stake_local);
                    this.loss=this.loss.toFixed(2);
                }else{
                    this.loss=parseFloat(this.odd_local)*parseFloat(this.stake_local) - parseFloat(this.stake_local);
                    this.loss=this.loss.toFixed(2);
                    this.profit = parseFloat(this.stake_local);
                    this.profit=this.profit.toFixed(2);
                }
                this.mute = false;
                var data={
                    runner_id:this.runner_id,
                    market_id:this.market_id,
                    bet_type:this.bet_type,
                    profit_amount:parseFloat(this.profit),
                    exposure:-parseFloat(this.loss)
                };

                Event.$emit('updateBetslip',data);
                this.$emit('update',this.odd_local,this.stake_local);
                //this.$emit('calculate',parseFloat(this.loss),parseFloat(this.profit),this.bet_type,this.runner_id);
                //this.$emit('update',this.id,this.odd_local,this.stake_local);
            },
            incOdd(val){
                if (this.stake_local==undefined)this.stake_local=0;
                this.stake_local=parseFloat(this.stake_local)+parseFloat(val);
                this.calculate()
            },
            setOdd(val){
                this.stake_local=val;
                this.calculate()
            }
        },
        created(){
            this.stakes=JSON.parse(this.$User.stake);
            if(this.bet_type=='availableToBack'){
                this.bet_type_name='Bet For';
            }
            else{
                this.bet_type_name='Bet Against';
            }
        }
    }
</script>
<style>
    .bet_type{
        width: 12px;height: 12px; margin-right: 4px; float: left;
    }
</style>
