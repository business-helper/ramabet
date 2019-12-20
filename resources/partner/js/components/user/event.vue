<template>
    <tr>
        <td style="padding: 4px 8px;">
            <div style="display: flex">
                <div class="set_market" @click="setMarket(home.market_id)"><img :class="market_state">
                    <span style="display: none">MATCH_ODDS</span>
                </div>
                <router-link :to="'/event/'+event_data.id">
                    <div class="event_title">
                        {{event_data.name}}
                    </div>
                </router-link>
                <span v-if="event_data.time_status==='0'" class="progress_title">{{event_data.time}}</span>
                <span v-if="event_data.time_status==='1'" class="progress_title inplay"><i class="fas fa-play-circle"></i>{{event_data.time}}</span>
            </div>

        </td>
        <td class="mobile_hide">
            <div class="selectTemp notranslate">
                <div v-if="this.home.length!==0 && this.home.availableToBack.length!==0" class="left_item view_port" :class="home_back_update" @click="createBetSlip(home.id,'availableToBack',home.availableToBack[0].price)">
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span class="price">{{this.home.availableToBack[0].price}}</span>
                </div>
                <div v-else class="left_item view_port">
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span>--</span>
                </div>
                <div v-if="this.home.length!==0 && this.home.availableToLay.length!==0" class="right_item betting_item view_port" :class="home_lay_update" @click="createBetSlip(home.id,'availableToLay',home.availableToLay[0].price)">
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span class="price">{{this.home.availableToLay[0].price}}</span>
                </div>
                <div v-else class="right_item view_port">
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span>--</span>
                </div>
            </div>
        </td>
        <td class="mobile_hide">
            <div class="selectTemp notranslate mobile_hide">
                <div v-if="this.draw.length!==0 && this.draw.availableToBack.length!==0" class="left_item view_port" :class="draw_back_update" @click="createBetSlip(draw.id,'availableToBack',draw.availableToBack[0].price)">
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span class="price">{{this.draw.availableToBack[0].price}}</span>
                </div>
                <div v-else class="left_item view_port" >
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span>--</span>
                </div>
                <div v-if="this.draw.length!==0 && this.draw.availableToLay.length!==0" class="right_item betting_item view_port" :class="draw_lay_update" @click="createBetSlip(draw.id,'availableToLay',draw.availableToBack[0].price)">
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span class="price">{{this.draw.availableToLay[0].price}}</span>
                </div>
                <div v-else class="right_item view_port">
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span>--</span>
                </div>
            </div>
        </td>
        <td class="mobile_hide">
            <div class="selectTemp notranslate">
                <div v-if="this.away.length!==0 && this.away.availableToBack.length!==0" class="left_item view_port" :class="away_back_update" @click="createBetSlip(away.id,'availableToBack',away.availableToBack[0].price)">
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span class="price">{{this.away.availableToBack[0].price}}</span>
                </div>
                <div v-else class="left_item view_port" >
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span>--</span>
                </div>
                <div v-if="this.away.length!==0 && this.away.availableToLay.length!==0" class="right_item betting_item view_port" :class="away_lay_update" @click="createBetSlip(away.id,'availableToLay',away.availableToBack[0].price)">
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span class="price">{{this.away.availableToLay[0].price}}</span>
                </div>
                <div v-else class="right_item view_port">
                    <div class="cylon_eye" :class="show_runner"></div>
                    <span>--</span>
                </div>
            </div>
        </td>
    </tr>
</template>

<script>

    export default {
        data() {
            return {
                events:[],show_runner:'show',home:[],draw:[],away:[],home_back_update:'',home_lay_update:'',draw_back_update:'',draw_lay_update:'',away_back_update:'',away_lay_update:'',market_state:'deactive_market'
            }
        },
        props: [
            'event_data'
        ],
        mounted() {
            //console.log('Event Component mounted.');
            Event.$on('update_odd', (r_data) => {
                if (r_data.id==this.home.id || r_data.id==this.draw.id || r_data.id==this.away.id){
                    this.home_back_update='';
                    this.home_lay_update='';
                    this.draw_back_update='';
                    this.draw_lay_update='';
                    this.away_back_update='';
                    this.away_lay_update='';
                    var send_data={};
                    send_data.type= 'get';
                    send_data.table_name= 'runners';
                    send_data.condition=[];
                    send_data.condition.push(['id',r_data.id]);
                    window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                        //console.log('get updated runners-------------',r_data,data);
                        var item=data.data[0];
                        item.availableToBack=JSON.parse(item.availableToBack);
                        item.availableToLay=JSON.parse(item.availableToLay);
                        switch (item.id) {
                            case this.home.id:
                                this.home=item;
                                if (r_data.type=='availableToBack'){
                                    this.home_back_update='livenow';
                                }
                                else{
                                    this.home_lay_update='livenow';
                                }
                                break;
                            case this.away.id:
                                this.away=item;
                                if (r_data.type=='availableToBack'){
                                    this.away_back_update='livenow';
                                }
                                else{
                                    this.away_lay_update='livenow';
                                }
                                break;
                            default:
                                this.draw=item;
                                if (r_data.type=='availableToBack'){
                                    this.draw_back_update='livenow';
                                }
                                else{
                                    this.draw_lay_update='livenow';
                                }
                                break;
                        }
                        //showNotification('alert-success',item.runnerName,'top','right','animated fadeInRight','animated fadeOutRight');
                    });
                }
            });
        },
        methods:{
            read() {
                window.axios.get(`/api/getRunnerOfMatch/${this.event_data.id}`).then(({data}) => {
                    for (var i=0;i<data.length;i++) {
                        var item=data[i];
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
                    var send_data={};
                    send_data.type= 'get';
                    send_data.table_name= 'market';
                    send_data.condition=[];
                    send_data.condition.push(['market_id',this.home.market_id],['user_id',userID]);
                    window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                        //console.log('get updated runners-------------',r_data,data);
                        if (data.data.length>0){
                            this.market_state='active_market'
                        } else{
                            this.market_state='deactive_market';
                        }

                    });
                });
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
                setBetSlip();
                //Event.$emit('betSlipLoading','show');
                console.log(runner_id,bet_type,odd,userID,this.market_name);
                window.axios.post('/api/createBetSlip',{runner_id:runner_id,bet_type:bet_type,odd:odd,user_id:userID/*,market_name:this.market_name*/}).then(({ data }) => {
                    //console.log(data);
                    if(data.state===0){
                        Event.$emit('createBetSlip', data.data);
                    }
                    //Event.$emit('betSlipLoading','hide');
                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }).catch(function (resp) {
                    console.log(resp);
                });
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
    .livenow {
        -webkit-animation-name: example; /* Safari 4.0 - 8.0 */
        -webkit-animation-duration: .5s; /* Safari 4.0 - 8.0 */
        -webkit-animation-iteration-count: 6; /* Safari 4.0 - 8.0 */
        animation-name: example;
        animation-duration: .5s;
        animation-iteration-count: 6;
    }
    /* Safari 4.0 - 8.0 */
    @-webkit-keyframes example {
        0%   {background-color: #7cd3f7;}
        50% {background-color: #deddd8;}
        100% {background-color: #f99389;}
    }

    /* Standard syntax */
    @keyframes example {
        0%   {background-color: #7cd3f7;}
        50% {background-color: #deddd8;}
        100% {background-color: #f99389;}
    }
</style>
