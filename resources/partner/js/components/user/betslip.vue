<template>
    <div id="betsipe" class="tab-pane fade active in" style="width: 560px; max-width:100%; background: white; margin: 20px auto;">
        <!--<div :class="is_show" style="position: absolute;width: 100%;height: 100%;background-color: #777a;z-index: 1;">-->
        <!--<div  style=""><div class="lds-facebook" ><div></div><div></div><div></div></div></div>-->
        <!--</div>-->

        <div id="betSlipBoard" style="font-weight: bold;">
            <BetSlipItem
                    v-for="betslip in betslips"
                    v-bind="betslip"
                    :key="betslip.id"
                    @delete="del"
                    @update="update">
            </BetSlipItem>
        </div>
        <div id="betSlipFooter" :class="show_footer">
            <!--<div style="text-align: right;">-->
            <!--<span>Liability Rs</span>-->
            <!--<span id="total_price">{{total_liability}}</span>-->
            <!--</div>-->
            <div >
                <!--<div style="text-align: left;padding-left:5px;">
                    <input type="checkbox" :id="'md_checkbox_'+this.market_id" v-model="is_confirm" class="filled-in chk-col-light-blue">
                    <label :for="'md_checkbox_'+this.market_id">Please confirm your bets.</label>
                    &lt;!&ndash;<input id="confirm" v-model="is_confirm" type="checkbox">&ndash;&gt;
                    &lt;!&ndash;<label for="confirm">Please confirm your bets.</label>&ndash;&gt;
                </div>-->

                <div style="display: flex; justify-content: space-between; align-items: center;padding: 0 5px;">
                    <button class="btn second" style="margin-right: auto;" @click="cancel_all">Cancel All</button>
                    <button class="btn third" @click="placeBets_all">Place Bets</button>
                </div>
                <!--<div style="display: flex;margin-top: 10px;padding: 0 20px; justify-content:flex-end;">-->
                <!--<button class="btn second" style="margin-right: auto;" @click="cancel_all">Cancel All</button>-->
                <!--<button class="btn third" @click="placeBets_all">Place Bets</button>-->
                <!--</div>-->
            </div>


        </div>
    </div>
</template>
<script>
    function BetSlip(item) {
        this.id = item.id;
        this.odd = item.odd;
        this.bet_type = item.bet_type;
        this.eventName = item.eventName;
        this.marketName = item.marketName;
        this.runnerName = item.runnerName;
        this.stake = item.stake;
        this.max_stake = item.max_stake;
        this.min_stake = item.min_stake;
        this.event_id = item.event_id;
    }
    import BetSlipItem from './betslip_item.vue';
    export default {
        data() {
            return {
                betslips: [],working: false,total_price:0,total_liability:0,is_show:'show',is_confirm:false, is_show_footer: false,show_footer:'hide'
            }
        },
        props: [
            "market_id",
        ],

        mounted() {
            Event.$on('createBetSlip', (data) => {
                this.create(data);
            });
            Event.$on('betSlipLoading',(data) => {
                this.is_show=data;
            });

        },

        methods:{
            read() {
                this.is_show='show';
                console.log('test usertoken',usertoken);
                window.axios.get(`/api/getBetSlips/${userID}`).then(({ data }) => {
                    // console.log('getdata',data)
                    data.forEach(betslipe_item => {
                        this.is_show_footer = false;

                        if(betslipe_item.market_id == this.market_id){
                            this.mute = true;
                            //this.betslip = [];
                            this.is_show_footer = true;
                            this.show_footer='show';
                            this.betslips.push(new BetSlip(betslipe_item));
                            this.mute = false;

                        }
                    });
                    this.is_show='hide';
                    // console.log('betslips----------',this.betslips)
                    this.calculate();
                });
            },
            create(data){
                this.cancel_all();
                this.is_show_footer = false;
                console.log(data);
                if(data.market_id == this.market_id){//data.market_id == this.market_id
                    this.mute = true;
                    //this.betslip = [];
                    this.is_show_footer = true;
                    this.show_footer='show';
                    this.betslips.push(new BetSlip(data));
                    this.mute = false;
                }
            },
            del(id) {
                // alert(id);
                this.show_footer='hide';
                this.is_show='show';
                let index = this.betslips.findIndex(item => item.id === id);
                this.betslips.splice(index, 1);
                window.axios.get(`/api/delBetSlip/${id}`).then((data) => {
                    if (data.data.state==0){
                        // let index = this.betslips.findIndex(item => item.id === id);
                        // this.betslips.splice(index, 1);
                    }
                    else{
                        showNotification('alert-success',data.data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    }
                    this.is_show='hide';
                    this.calculate();
                });

            },
            update(id,odd,stake) {
                let index = this.betslips.findIndex(item => item.id === id);
                window.axios.post(`/api/updateBetSlip/${id}`, { id:id,odd:odd,stake:stake}).then((data) => {
                    this.betslips[index].odd=odd;
                    this.betslips[index].stake=stake;
                    this.calculate();
                });
            },
            confirm_betslip(item) {
                console.log('user-token',usertoken,item);
                window.axios.post('/api/confirmBetSlip',{id:item.id,odd:item.odd,stake:item.stake,usertoken:usertoken }).then(({ data }) => {
                    console.log(data);
                    if (data.state==0){
                        let index = this.betslips.findIndex(i => i.id === item.id);
                        this.betslips.splice(index, 1);
                    }

                    showNotification("alert-success",data.message , "top", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    Event.$emit('placedBets', 1);
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            cancel_all(){
                // console.log('cancel all');
                for (var i=0;i<this.betslips.length;i++){
                    this.del(this.betslips[i].id);
                }
            },
            placeBets_all(){
                for (var i=0;i<this.betslips.length;i++){
                    this.confirm_betslip(this.betslips[i]);
                }
                this.show_footer='hide';
                Event.$emit('updateBalance', 1);
                setOpenBet();
                /*if (this.is_confirm==false){
                    showNotification("alert-success",'Please confirm your bets.' , "top", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }
                else{
                    for (var i=0;i<this.betslips.length;i++){
                        this.confirm_betslip(this.betslips[i]);
                    }
                    this.show_footer='hide';
                    Event.$emit('updateBalance', 1);
                    setOpenBet();

                }*/


            },
            calculate(){
                var liability=0;
                var liability_back=0;
                var liability_lay=0;
                for (var i=0;i<this.betslips.length;i++){
                    if (this.betslips[i].bet_type=='availableToBack'){
                        liability_back=parseFloat(liability_back)+parseFloat(this.betslips[i].odd)*parseFloat(this.betslips[i].stake);
                    }
                    else{
                        liability_lay=parseFloat(liability_lay)+parseFloat(this.betslips[i].odd)*parseFloat(this.betslips[i].stake);
                    }
                }
                //console.log('liability',availableToBack);
                liability=parseFloat(liability_back)+parseFloat(liability_lay);
                //this.total_price=parseFloat(price).toFixed(2);
                this.total_liability=parseFloat(liability).toFixed(2);
            },
            test(data){
                // console.log('Seccess called',data);
            }

        },
        created() {
            // console.log('Create Element');
            //this.read();
        },
        components: {
            BetSlipItem
        },
        watch: {
            // mute(val) {
            //     document.getElementById('mute').className = val ? "on" : "";
            // }
        },
    }

</script>

