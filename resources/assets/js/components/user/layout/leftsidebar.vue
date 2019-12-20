<template>
    <aside id="leftsidebar" class="sidebar" style="top:62px">
        <div class="menu">
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">
                <ul class="list" style="overflow: hidden; overflow-y: scroll; width: auto; height: 656px;">
                    <li>
                        <router-link to="/inplay" class=" waves-effect waves-block">
                            <div class="side_item">
                                <img class="in-play">
                                <span>In-Play</span>
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/my_market" class=" waves-effect waves-block">
                            <div class="side_item">
                                <img class="multi_img">
                                <span>My Market</span>
                            </div>

                        </router-link>
                    </li>
                    <li>
                        <router-link to="/multi_market" class=" waves-effect waves-block">
                            <div class="side_item">
                                <img class="pin">
                                <span>Multi Market</span>
                            </div>

                        </router-link>
                    </li>
                    <li>
                        <router-link to="/fancyMarkets" class=" waves-effect waves-block">
                            <div class="side_item">
                                <img class="fancy">
                                <span>Fancy Markets</span>
                            </div>

                        </router-link>
                    </li>
                    <li>
                        <router-link to="/sport/4" class="waves-effect waves-block">
                            <div class="side_item">
                                <img class="cricket">
                                <span>Cricket</span>
                            </div>

                        </router-link>
                    </li>
                    <li>
                        <router-link to="/sport/2" class="waves-effect waves-block">
                            <div class="side_item">
                                <img class="tennis">
                                <span>Tennis</span>
                            </div>

                        </router-link>
                    </li>
                    <li>
                        <router-link to="/sport/1" class="waves-effect waves-block">
                            <div class="side_item">
                                <img class="soccer">
                                <span>Soccer</span>
                            </div>

                        </router-link>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle waves-effect waves-block">
                            <div class="side_item">
                                <img class="promotions">
                                <span>Report</span>
                            </div>

                        </a>
                        <ul class="ml-menu">
                            <li>
                                <router-link class="waves-effect waves-block" :to="'/report/acc_status'">
                                    <div class="side_item">
                                        Account Status
                                    </div>
                                </router-link>


                            </li>
                            <li>
                                <router-link class="waves-effect waves-block" :to="'/report/acc_statement'">
                                    <div class="side_item">
                                        Account Statement
                                    </div>

                                </router-link>
                            </li>
                            <li>
                                <router-link class="waves-effect waves-block" :to="'/report/profitAndLoss'">
                                    <div class="side_item">
                                        Profit & Loss Report
                                    </div>

                                </router-link>
                            </li>
                            <li>
                                <router-link class="waves-effect waves-block" :to="'/report/commission'">
                                    <div class="side_item">
                                        Commission Report
                                    </div>

                                </router-link>
                            </li>
                            <li>
                                <router-link class="waves-effect waves-block" :to="'/report/wallet'">
                                    <div class="side_item">
                                        Wallet Report
                                    </div>

                                </router-link>
                            </li>
                             <li>
                                 <router-link class="waves-effect waves-block" :to="'/report/settlement'">
                                     <div class="side_item">
                                         Settlement Report
                                     </div>

                                 </router-link>
                            </li>
                             <li>
                                 <router-link class="waves-effect waves-block" :to="'/report/bethistory'">
                                     <div class="side_item">
                                         Bet Log
                                     </div>

                                 </router-link>
                            </li>
                            <li>
                                <router-link class="waves-effect waves-block" :to="'/report/result'">
                                    <div class="side_item">
                                        Result
                                    </div>

                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            Event.$on('leftmarkets', (data) => {
                this.page = 'markets';
            });
            Event.$on('leftsideofleague', (data) => {
                this.page = 'leftsideofleague';
                console.log('leftbar', this.page);
            });
            Event.$on('leftside', (data) => {
                this.page = 'home';
                console.log('leftbar', this.page);
            });
            Event.$on('leftsideofevent', (data) => {
                this.page = 'leftsideofevent';
                console.log('leftsideofevent', this.page);
            });
        },
        props: [],
        data() {
            return {
                page: 'leftsideofleague',
                cricket_events: [],
                soccer_events: [],
                tennis_events: []
            }
        },
        methods: {
            getSideData(event_id) {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post(`/api/getEventOfSports`,{id:event_id,user_id:this.$userId,user_type:'users',inPlay:'all'}).then(({data}) => {
                    /* if (data.data.state==0){
                        /!* let index = this.betslipes.findIndex(item => item.id === id);
                         this.betslipes.splice(index, 1);
                         this.mute = false;*!/
                     }*/
                    console.log('get events of sport', data);
                    // this.events=data;
                    // if (this.events.length===0){
                    //     this.is_show_event='';
                    // }
                    // else{
                    //     this.show_table='';
                    // }
                    // this.is_show='hide';
                    //showNotification("alert-success", data.data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    if (event_id == 4) {
                        this.cricket_events = data;
                    } else if (event_id == 1) {
                        this.soccer_events = data;
                    } else if (event_id == 2) {
                        this.tennis_events = data;
                    }
                });
            }
        },

        created() {
            this.getSideData(4);
            this.getSideData(1);
            this.getSideData(2);
            if (this.$route.path.includes('sport')) {
                this.page = 'leftsideofleague'
            }
            else if (this.$route.path.includes('event')) {
                this.page = 'markets'
            }
            else if (this.$route.path.includes('league')) {
                this.page = 'leftsideofevent'
            }
            else {
                this.page = 'home'
            }
        }
    }
</script>
