<template>
    <div class="home_event" style="">
        <div style="padding: 4px 8px;flex:1;">
            <div style="display: flex;height: 100%">
                <div class="set_market" @click="setMarket(home.market_id)"><img :class="market_state">
                    <span style="display: none">MATCH_ODDS</span>
                </div>
                <router-link :to="'/event/'+event_data.event.id">
                    <div class="event_title" :class="'is_active_'+Number(Boolean(marketActive))">
                        {{event_data.event.name}}
                    </div>
                </router-link>

                <span v-if="event_data.event.inPlay==1" class="progress_title inplay blink_me"><i class="fas fa-play-circle"></i>InPlay</span>
                <span v-else class="progress_title">{{event_data.event.time}}</span>
                <!--<div class="right" v-if="this.$isSuper==0">
                    <input v-model="marketActive" type="checkbox" :id="'is_active'+home.market_id" class="filled-in" v-on:change="updateIsActive(home.market_id)">
                    <label :for="'is_active'+home.market_id" style="margin: 5px 3px -3px 5px;">A</label>
                </div>
                <div class="right" v-if="this.$isSuper==0">
                    <input v-model="marketUpdate" type="checkbox" :id="'is_update'+home.market_id" class="filled-in" v-on:change="updateIsUpdate(home.market_id)">
                    <label :for="'is_update'+home.market_id" style="margin: 5px 5px -3px 2px;">LU</label>
                </div>-->
            </div>

        </div>
        <div style="" class="odds_div">
            <div class="odd_div notranslate">
                <div v-if="event_data.event.marketStatus!='OPEN'" class="market_status">
                    {{this.event_data.event.marketStatus}}
                </div>
                <transition name="slide-fade" mode="out-in">
                    <div v-if="this.home.length!==0 && this.home.availableToBack.length!==0 && home.availableToBack[0].price!==undefined" class="left_item view_port" :class="home_back_update" @click="createBetSlip(home.id,'availableToBack',home.availableToBack[0].price)" :key="home.availableToBack[0].price">
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span class="price">{{this.home.availableToBack[0].price}}</span>
                    </div>
                    <div v-else class="left_item view_port">
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span>--</span>
                    </div>
                </transition>
                <transition name="slide-fade" mode="out-in">
                    <div v-if="this.home.length!==0 && this.home.availableToLay.length!==0 && home.availableToLay[0].price!==undefined" class="right_item betting_item view_port" :class="home_lay_update" @click="createBetSlip(home.id,'availableToLay',home.availableToLay[0].price)" :key="home.availableToLay[0].price">
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span class="price">{{this.home.availableToLay[0].price}}</span>
                    </div>
                    <div v-else class="right_item view_port">
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span>--</span>
                    </div>
                </transition>

                <transition name="slide-fade" mode="out-in">
                    <div v-if="this.draw.length!==0 && this.draw.availableToBack.length!==0 && draw.availableToBack[0].price!==undefined" class="left_item view_port" :class="draw_back_update" @click="createBetSlip(draw.id,'availableToBack',draw.availableToBack[0].price)" :key="draw.availableToBack[0].price">
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span class="price">{{this.draw.availableToBack[0].price}}</span>
                    </div>
                    <div v-else class="left_item view_port" >
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span>--</span>
                    </div>
                </transition>
                <transition name="slide-fade" mode="out-in">
                    <div v-if="this.draw.length!==0 && this.draw.availableToLay.length!==0 && draw.availableToBack[0].price!==undefined" class="right_item betting_item view_port" :class="draw_lay_update" @click="createBetSlip(draw.id,'availableToLay',draw.availableToLay[0].price)" :key="draw.availableToLay[0].price">
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span class="price">{{this.draw.availableToLay[0].price}}</span>
                    </div>
                    <div v-else class="right_item view_port">
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span>--</span>
                    </div>
                </transition>

                <transition name="slide-fade" mode="out-in">
                    <div v-if="this.away.length!==0 && this.away.availableToBack.length!==0 && away.availableToBack[0].price!==undefined" class="left_item view_port" :class="away_back_update" @click="createBetSlip(away.id,'availableToBack',away.availableToBack[0].price)" :key="away.availableToBack[0].price">
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span class="price">{{this.away.availableToBack[0].price}}</span>
                    </div>
                    <div v-else class="left_item view_port" >
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span>--</span>
                    </div>
                </transition>

                <transition name="slide-fade" mode="out-in">
                    <div v-if="this.away.length!==0 && this.away.availableToLay.length!==0 && away.availableToLay[0].price!=undefined" class="right_item betting_item view_port" :class="away_lay_update" @click="createBetSlip(away.id,'availableToLay',away.availableToLay[0].price)" :key="away.availableToLay[0].price">
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span class="price">{{this.away.availableToLay[0].price}}</span>
                    </div>
                    <div v-else class="right_item view_port">
                        <div class="cylon_eye" :class="show_runner"></div>
                        <span>--</span>
                    </div>
                </transition>
            </div>
        </div>

    </div>
</template>

<script>

    export default {
        data() {
            return {
                events:[],show_runner:'show',home:[],draw:[],away:[],home_back_update:'',home_lay_update:'',draw_back_update:'',draw_lay_update:'',away_back_update:'',away_lay_update:'',market_state:this.event_data.multi,marketUpdate:this.event_data.event.marketUpdate,marketActive:this.event_data.event.marketActive
            }
        },
        props: [
            'event_data'
        ],
        mounted() {
            //console.log('Event Component mounted.');
            Event.$on('update_odd', (r_data) => {
                switch (r_data.id) {
                    case this.home.id:
                        this.home[r_data.type]=r_data[r_data.type];

                        break;
                    case this.away.id:
                        this.away[r_data.type]=r_data[r_data.type];

                        break;
                    case this.draw.id:
                        this.draw[r_data.type]=r_data[r_data.type];;

                        break;
                }
            });
        },
        methods:{
            updateIsActive(market_id){
                window.axios.post('/api/setMarketActive', {market_id:market_id,is_active:this.marketActive,user_id:this.$userId}).then(({data}) => {
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    var starCountRef = this.$firebase.database().ref('/');
                    var marketUpdate=[];
                    marketUpdate=data.data;
                    starCountRef.update({
                        marketUpdate
                    }).then((data)=>{
                        //success callback
                        console.log('data ' , data)
                    }).catch((error)=>{
                        //error callback
                        console.log('error ' , error)
                    })
                });
            },
            updateIsUpdate(market_id){
                window.axios.post('/api/setMarketUpdate', {market_id:market_id,isUpdate:this.marketUpdate,user_id:this.$userId}).then(({data}) => {
                    console.log(data);
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                });
            },
            read() {
                for (var i=0;i<this.event_data.runners.length;i++) {
                    var item=this.event_data.runners[i];
                    item.availableToBack=JSON.parse(item.availableToBack);
                    item.availableToLay=JSON.parse(item.availableToLay);
                    //console.log('get runner of event',this.event_data.name.indexOf(item.runnerName));
                    switch (i) {
                        case 0:
                            this.home=item;
                            break;
                        case 1:
                            this.away=item;
                            break;
                        default:
                            this.draw=item;
                            break;
                    }
                    //console.log('home---',this.home);
                }
                this.show_runner='hide';

            },
            setMarket(id){
                var rand=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+rand;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+rand+this.$User.login_session+'tcgtchkmk1014');
                var send_data={
                    'market_id':id,
                    'user_id':this.$userId,
                    'user_type':'admins'
                };
                window.axios.post('/api/v1/setMultiMarket', send_data).then(({ data }) => {
                    this.market_state=data.message;
                });

            },
            createBetSlip(runner_id,bet_type,odd){
                /*setBetSlip();
                //Event.$emit('betSlipLoading','show');
                console.log(runner_id,bet_type,odd,this.$userId,this.market_name);
                window.axios.post('/api/createBetSlip',{runner_id:runner_id,bet_type:bet_type,odd:odd,user_id:this.$userId/!*,market_name:this.market_name*!/}).then(({ data }) => {
                    //console.log(data);
                    if(data.state===0){
                        Event.$emit('createBetSlip', data.data);
                    }
                    //Event.$emit('betSlipLoading','hide');
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }).catch(function (resp) {
                    console.log(resp);
                });*/
            },

        },
        created() {
            this.read();
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
<style>
    .polling_message {
        color: white;
        float: left;
        margin-right: 2%;
    }

    .view_port {
        overflow: hidden;
        position: relative;
    }

    .cylon_eye {
        position: absolute;
        background-image: linear-gradient(to right,
        rgba(214, 214, 214, 0.1) 25%,
        rgba(0, 0, 0, .1) 50%,
        rgba(213, 213, 213, 0.1) 75%);
        color: white;
        height: 100%;
        width: 20%;

        -webkit-animation: 1s linear 0s infinite alternate move_eye;
        animation: 1s linear 0s infinite alternate move_eye;
    }

    @-webkit-keyframes move_eye { from { margin-left: -20%; } to { margin-left: 100%; }  }
    @keyframes move_eye { from { margin-left: -20%; } to { margin-left: 100%; }  }
</style>

<style>

</style>
