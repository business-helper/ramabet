<template>
    <div id="betsipe" class="tab-pane fade active in" style="background: white; position: relative">
        <div :class="timer" style="position: absolute;width: 100%;height: 100%;background-color: #777a;z-index: 1;display: flex;">
            <p v-if="delaySec>0" style="position: absolute; top: 39%; font-size: 33px; width: 100%; text-align: center; color: wheat;">{{delaySec}}</p>
            <p v-else style="position: absolute; top: 39%; font-size: 33px; width: 100%; text-align: center; color: wheat;">Processing</p>
            <div style="margin: auto;">
                <div class="preloader pl-size-xl">
                    <div class="spinner-layer">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="betSlipBoard" style="font-weight: bold;">
            <BetSlipItem
                    v-for="betslip in betslips"
                    v-bind="betslip"
                    :key="betslip.odd"
                    @delete="del"
                    @calculate="calculate"
                    @update="update">
            </BetSlipItem>
        </div>
        <div id="betSlipFooter" :class="show_footer">
            <!--<div style="text-align: right;">-->
            <!--<span>Liability Rs</span>-->
            <!--<span id="total_price">{{total_liability}}</span>-->
            <!--</div>-->
            <div v-if="this.betslips.length>0">
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
        //this.id = item.id;
        this.odd = item.odd;
        this.bet_type = item.bet_type;
        //this.eventName = item.eventName;
        this.marketName = item.marketName;
        this.runnerName = item.runnerName;
        this.stake = 0;
        this.score = item.score;
        //this.max_stake = item.max_stake;
        //this.min_stake = item.min_stake;
        //this.event_id = item.event_id;
        this.market_id = item.market_id;
        this.runner_id = item.runner_id;
        this.delaySec = item.delaySec;
        // if (item.marketType=='fancy') {
        //     this.delaySec = item.f_delaySec;
        // }else{
        //     this.delaySec = item.delaySec;
        // }

        this.marketType = item.marketType;
    }
    import BetSlipItem from './betslip_item.vue';
    export default {
        data() {
            return {
                betslips: [],working: false,total_price:0,total_liability:0,is_show:'hide',is_confirm:false, is_show_footer: false,show_footer:'hide',wallet:0,runners:[],delaySec:0,timer:'hide',interval:'',betItem:[],widthOfWindow:$(window).width(),
            }
        },
        props: [
            "market_id","runner_id","type"
        ],

        mounted() {
            Event.$on('createBetSlip', (data) => {
                this.create(data);
            });
            Event.$on('betSlipLoading',(data) => {
                this.is_show=data;
            });
            Event.$on('changeWidth', (data) => {
                this.widthOfWindow=data;
                //console.log(data);
            });
            Event.$on('marketManagement',(marketManagement) => {

                if (this.market_id==marketManagement.market_id){
                    this.delaySec=marketManagement.delaySec;
                    //console.log(this.delaySec,marketManagement.delaySec);
                    //console.log(this.market_id,marketManagement.market_id);
                }

            });
        },

        methods:{
            read() {
                this.is_show='';
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getBetSlips/${this.$userId}`).then(({ data }) => {
                    // console.log('getdata',data)
                    data.forEach(betslipe_item => {
                        this.is_show_footer = false;
                        this.mute = true;
                        //this.betslip = [];
                        this.is_show_footer = true;
                        this.show_footer='show';
                        this.betslips.push(new BetSlip(betslipe_item));
                        this.mute = false;
                    });
                    this.is_show='hide';
                    // console.log('betslips----------',this.betslips)
                    //this.calculate();
                });
            },
            create(data){
                this.timer='hide';
                this.betslips=[]
                Event.$emit('deletedBetSlip','');
                this.is_show_footer = false;
                /*if (this.market_id==-2){
                    this.mute = true;
                    //this.betslip = [];
                    //this.wallet=data.wallet;
                    //this.runners=data.profit;
                    this.is_show_footer = true;
                    this.show_footer='show';
                    this.betslips.push(new BetSlip(data));
                    console.log(this.betslips);
                    //Event.$emit('placedBets',data.betItem.market_id);
                    this.mute = false;
                }*/
                if (this.type=='fancy'){
                    if(data.runner_id == this.runner_id /*&& this.widthOfWindow<850*/){//data.market_id == this.market_id
                        this.mute = true;
                        //this.betslip = [];
                        //this.wallet=data.wallet;
                        //this.runners=data.profit;
                        this.is_show_footer = true;
                        this.show_footer='show';
                        this.delaySec=data.delaySec;
                        this.betslips.push(new BetSlip(data));
                        //console.log(this.betslips);
                        //Event.$emit('placedBets',data.betItem.market_id);
                        this.mute = false;
                    }
                } else{
                    if(data.market_id == this.market_id /*&& this.widthOfWindow<850*/){//data.market_id == this.market_id
                        this.mute = true;
                        //this.betslip = [];
                        //this.wallet=data.wallet;
                        //this.runners=data.profit;
                        this.is_show_footer = true;
                        this.show_footer='show';
                        this.delaySec=data.delaySec;

                        this.betslips.push(new BetSlip(data));
                        //console.log(this.betslips);
                        //Event.$emit('placedBets',data.betItem.market_id);
                        this.mute = false;
                    }
                }




                //console.log(data);

            },
            del() {
                // alert(id);
                this.show_footer='hide';
                this.is_show='show';
                //let index = this.betslips.findIndex(item => item.id === id);
                this.betslips=[]
                Event.$emit('deletedBetSlip','');
               /* window.axios.get(`/api/delBetSlip/${id}`).then((data) => {
                    if (data.data.state==0){
                        // let index = this.betslips.findIndex(item => item.id === id);
                        // this.betslips.splice(index, 1);
                        Event.$emit('deletedBetSlip',data.data.data);
                    }
                    else{
                        showNotification('alert-success',data.data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    }
                    this.is_show='hide';
                    //this.calculate();
                });*/

            },
            update(odd,stake) {
                this.betslips[0].odd=odd;
                this.betslips[0].stake=stake;
                /*let index = this.betslips.findIndex(item => item.id === id);
                window.axios.post(`/api/updateBetSlip/${id}`, { id:id,odd:odd,stake:stake}).then((data) => {
                    this.betslips[index].odd=odd;
                    this.betslips[index].stake=stake;
                    console.log('update Stake and Odd',data);
                    Event.$emit('updateBetslip',data.data);
                    //this.calculate();
                });*/
            },
            confirm_betslip() {
                /*this.is_show='show';*/
                var item=this.betItem;
                item['user_id']=this.$userId;
                //console.log(item);

                var starCountRef = this.$firebase.database().ref('/');
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/confirmBetSlip1',item).then(({ data }) => {
                    //console.log('placed bet-testing ',data);
                    let index = this.betslips.findIndex(i => i.id === item.id);
                    this.betslips.splice(index, 1);
                    if (data.state==0){
                        Event.$emit('updateBalance', 1);

                        var placedBet=data.data;
                        starCountRef.update({
                            placedBet
                        }).then((data)=>{
                            //success callback
                            console.log('data ' , data)
                        })
                        data.data.forEach(item=>{
                            Event.$emit('placedBets', item);
                        });

                    }else{
                        Event.$emit('profitReset', '');
                    }
                    //this.is_show='hide';
                    showNotification("alert-success",data.message , "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    this.timer='hide';

                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            cancel_all(){
                // console.log('cancel all');
                /*for (var i=0;i<this.betslips.length;i++){
                    this.del(this.betslips[i].id);
                }*/
                this.del();
            },
            startTimer(){
                this.timer='';
                this.interval=setInterval(this.countDown, 1000);
            },
            countDown(){
                if (this.delaySec==0){
                    clearInterval(this.interval);
                    this.confirm_betslip()
                }
                this.delaySec--;
            },
            placeBets_all(){
                //console.log('Placed',this.wallet,this.total_liability);

                /*if (this.wallet+this.total_liability<0){
                    showNotification("alert-success",'You wallet is small for bet' , "top", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    return;
                }*/
                this.betItem=this.betslips[0];
                //console.log(this.betItem);

                this.startTimer();
                //setTimeout(function() {this.confirm_betslip}, this.delaySec*1000);
                /*for (var i=0;i<this.betslips.length;i++){
                    //this.counter(this.betslips[i].delaySec,this.betslips[i]);
                    this.startTimer(this.betslips[i].delaySec);
                    var item=this.betslips[i];
                    setTimeout(function() {this.confirm_betslip(item)}, item.delaySec*1000);
                }*/
                //this.show_footer='hide';
                //Event.$emit('updateBalance', 1);
                //setOpenBet();
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
            calculate(loss,profit,bet_type,runner_id){
                console.log(loss,profit,bet_type,runner_id);
                this.total_liability=0;
                this.runners.forEach(item=>{
                    console.log(item.amount,);
                    var temp=0;
                    if (runner_id===item.runner_id){
                        if (bet_type==='availableToBack'){
                            temp=item.amount+profit;
                        } else{
                            temp=item.amount-loss;
                        }
                    }
                    else {
                        if (bet_type==='availableToBack'){
                            temp=item.amount-loss;
                        } else{
                            temp=item.amount+profit;
                        }
                    }
                    if (this.total_liability>temp)this.total_liability=temp;
                    console.log('profit and liability',this.total_liability,loss,profit,bet_type)
                });
                //this.total_liability=amount;
                /*for (var i=0;i<this.betslips.length;i++){
                    this.total_liability+=this.betslips[i].loss
                }*/
                //console.log('this.total_liability',this.total_liability);
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

