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
        <div class="btn btn-danger betslip_close right" @click="del()"><i class="fas fa-times"></i></div>
        <div style="text-align: left;padding-left: 10px">
            <div class="bet_type" :class="bet_type"></div>
            <span>({{this.bet_type_name}})</span>
        </div>

        <div class="part_teams" style="text-align: left;padding-left: 10px"><router-link :to="'/event/'+event_id">{{eventName}}</router-link></div>
        <div :class="bet_type" style="padding: 5px">
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
                <!--<div class="item20" style="width: 100%;">-->
                <!--<div style="padding-left:10px;width: 100%;text-align: left">Odds</div>-->
                <!--<div class="item20" style="padding-right: 5px;width: 100%;height: 35px;position: relative;">-->
                <!--<span class="fa fa-minus btn bg-red waves-effect" style="font-size: 29px;position: absolute;left: 0px;padding: 3px;" @click="desodds"></span>-->
                <!--<input class="odds" name="odds" style="width: 100%;height: 100%;padding-left: 35px;" type="number" v-model="odd_local" v-on:change="calculate()" v-on:keyup="calculate()">-->
                <!--<span class="fa fa-plus btn bg-light-green waves-effect" style="font-size: 29px;position: absolute;right: 5px;padding: 3px;background: #aade12;" @click="incodds"></span>-->
                <!--</div>-->
                <!--</div>-->
                <!--<div class="item20" style="width: 100%;">-->
                <!--<div style="padding-left:10px;width: 100%;text-align: left">Stake</div>-->
                <!--<div class="item20" style="padding-left: 5px;width: 100%;height: 35px;position: relative;">-->
                <!--<span class="fa fa-minus btn bg-red waves-effect" style="font-size: 29px;position: absolute;left: 5px;padding: 3px;" @click="desstake"></span>-->
                <!--<input class="stake" name="stake" style="width: 100%;height: 100%;padding-left: 35px;" type="number" v-on:change="calculate()" v-on:keyup="calculate()" v-model="stake_local">-->
                <!--<span class="fa fa-plus btn bg-light-green waves-effect" style="font-size: 29px;position: absolute;right: 0px;padding: 3px;background: #aade12;" @click="incstake" ></span>-->
                <!--</div>-->
                <!--</div>-->

                <div class="item20" style="width: 100%;">
                    <div style="padding-left:10px;width: 100%;text-align: left">Odds</div>
                    <div class="item20" style="padding-right: 5px;width: 100%;height: 35px;display: flex;justify-content: space-between;">
                        <span class="fa fa-minus btn bg-red waves-effect" style="font-size: 11px;padding: 11px" @click="desodds"></span>
                        <input class="odds" name="odds" style="width: 100%;height: 100%;" type="number" v-model="odd_local" v-on:change="calculate()" v-on:keyup="calculate()">
                        <span class="fa fa-plus btn bg-light-green waves-effect" style="font-size: 11px;padding: 11px;background: #aade12;" @click="incodds"></span>
                    </div>
                </div>
                <div class="item20" style="width: 100%;">
                    <div style="padding-left:10px;width: 100%;text-align: left">Stake</div>
                    <div class="item20" style="padding-left: 5px;width: 100%;height: 35px;display: flex;justify-content: space-between;">
                        <span class="fa fa-minus btn bg-red waves-effect" style="font-size: 11px;padding: 11px" @click="desstake"></span>
                        <input class="stake" name="stake" style="width: 100%;height: 100%;" type="number" v-on:change="calculate()" v-on:keyup="calculate()" v-model="stake_local">
                        <span class="fa fa-plus btn bg-light-green waves-effect" style="font-size: 11px;padding: 11px;background: #aade12;" @click="incstake" ></span>
                    </div>
                </div>


                <!--<div style="align-self: center; flex: 1; text-align: right;">-->

                <!--</div>-->
            </div>
            <div class="bet_input" style="display: flex;background-color:#fff; padding: 5px;flex-flow: wrap;    justify-content: space-between;">
                <div class="btn btn-danger betslip_btn" @click="incOdd(100)">100</div>
                <div class="btn btn-danger betslip_btn" @click="incOdd(500)">500</div>
                <div class="btn btn-danger betslip_btn" @click="incOdd(1000)">1k</div>
                <!--<div class="btn btn-danger betslip_btn" @click="setOdd(max_stake)">MAX</div>-->
                <div class="btn btn-danger betslip_btn" @click="incOdd(5000)">5k</div>
                <div class="btn btn-danger betslip_btn" @click="incOdd(10000)">10k</div>
                <div class="btn btn-danger betslip_btn" @click="incOdd(50000)">50k</div>
                <!--<div class="btn btn-danger betslip_btn" @click="incOdd(0)">custom</div>-->
                <div class="btn btn-default clear" style="text-align: center" @click="setOdd(0)">Clear</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: [
            'id','bet_type','odd','eventName','marketName','is_del','runnerName','stake','max_stake','min_stake','event_id'
        ],
        data(){
            return{
                profit:0,
                odd_local: this.odd,
                stake_local:this.stake,
                bet_type_name:'',
                loss: 0
            }
        },
        mounted() {
            console.log('Betslipe_item Component mounted.')
        },
        methods: {
            incstake(){
                this.stake_local = parseFloat(this.stake_local) + 1;
                this.stake_local = this.stake_local.toFixed(2);
                this.calculate();
            },
            desstake(){
                this.stake_local = parseFloat(this.stake_local) - 1;
                this.stake_local = this.stake_local.toFixed(2);
                this.calculate();
            },
            incodds(){
                this.odd_local = parseFloat(this.odd_local) + 0.01;
                this.odd_local = this.odd_local.toFixed(2);
                this.calculate();
            },
            desodds(){
                this.odd_local = parseFloat(this.odd_local) - 0.01;
                this.odd_local = this.odd_local.toFixed(2);
                this.calculate();
            },
            del() {
                this.$emit('delete', this.id);
                //this.$emit('update',this.id);
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
                this.$emit('update',this.id,this.odd_local,this.stake_local);
            },
            incOdd(val){
                this.stake_local=parseFloat(this.stake)+parseFloat(val);
                this.calculate()
            },
            setOdd(val){
                this.stake_local=val;
                this.calculate()
            }
        },
        created(){
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
