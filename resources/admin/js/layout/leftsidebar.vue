<template>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="tabpanl1">
            <div class="menu">
                <ul class="list">
                    <li id="client_menu">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <div class="side_item">
                                <i class="material-icons">view_list</i>
                                <span>User</span>
                            </div>

                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="javascript:void(0);" @click="showAdduserModal">
                                    <div class="side_item">
                                        Add Account
                                    </div>
                                </a>
                            </li>
                            <li>
                                <router-link to="/client/user">
                                    <div class="side_item">
                                        Accounts
                                    </div>
                                </router-link>
                            </li>

                        </ul>
                    </li>

                </ul>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tabpanl2">
            <div class="menu" style="margin-top: 0">
                <ul class="list" style="width: auto;">
                    <li>
                        <router-link to="/inplay" >
                            <div class="side_item">
                                <img class="in-play">
                                <span>In-Play</span>
                            </div>

                        </router-link>
                    </li>
                    <li>
                        <router-link to="/my_market" >
                            <div class="side_item">
                                <img class="multi_img">
                                <span>My Market</span>
                            </div>

                        </router-link>
                    </li>
                    <li>
                        <router-link to="/multi_market" >
                            <div class="side_item">
                                <img class="pin">
                                <span>Multi Market</span>
                            </div>

                        </router-link>
                    </li>
                    <li>
                        <router-link to="/fancyMarkets" >
                            <div class="side_item">
                                <img class="fancy">
                                <span>Fancy Market</span>
                            </div>

                        </router-link>
                    </li>

                    <li>
                        <router-link to="/sport/4">
                            <div class="side_item">
                                <img class="cricket">
                                <span>Cricket</span>
                            </div>

                        </router-link>
                        <!-- <ul class="ml-menu">
                             <li v-for="c in this.cricket_events">
                                 <router-link :to="'/event/'+c.id" class=" menu-toggle"
                                              style="line-height: 20px"><img style="width: 20px;height: 20px;"
                                                                             class="cricket">{{c.name}}
                                 </router-link>
                                 <marketMenu :event_id="c.id"></marketMenu>
                             </li>

                         </ul>-->
                    </li>
                    <li>
                        <router-link to="/sport/2">
                            <div class="side_item">
                                <img class="tennis">
                                <span>Tennis</span>
                            </div>

                        </router-link>
                        <!--<ul class="ml-menu">
                            <li v-for="t in this.tennis_events">
                                <router-link :to="'/event/'+ t.id" class="menu-toggle"
                                             style="line-height: 20px"><img
                                        class="tennis"><img style="width: 20px;height: 20px;"
                                                            class="tennis">{{t.name}}
                                </router-link>
                                <marketMenu :event_id="t.id"></marketMenu>
                            </li>

                        </ul>-->
                    </li>
                    <li>
                        <router-link to="/sport/1" >
                            <div class="side_item">
                                <img class="soccer">
                                <span>Soccer</span>
                            </div>

                        </router-link>
                        <!--<ul class="ml-menu">
                            <li v-for="s in this.soccer_events">
                                <router-link :to="'/event/'+s.id" class="menu-toggle"
                                             style="line-height: 20px"><img
                                        style="width: 20px;height: 20px;" class="soccer">{{s.name}}
                                </router-link>
                                <marketMenu :event_id="s.id"></marketMenu>
                            </li>

                        </ul>-->
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle ">
                            <div class="side_item">
                                <i class="material-icons">
                                    settings_applications
                                </i>
                                <span>Management</span>
                            </div>

                        </a>
                        <ul class="ml-menu">
                            <li>
                                <router-link class="" :to="'/management/sport/0/'+this.$userId">
                                    <div class="side_item">
                                        Sports
                                    </div>

                                </router-link>
                            </li>
                            <li v-if="this.$isSuper==0">
                                <router-link class="" :to="'/management/series'">
                                    <div class="side_item">
                                        Series
                                    </div>

                                </router-link>
                            </li>
                            <!--<li v-if="this.$isSuper==0">
                                <router-link class=""  to="/management/events">
                                    Events
                                </router-link>
                            </li>-->
                            <!--<li>
                                <router-link class=""  to="/management/users">
                                    Users
                                </router-link>
                            </li>-->

                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
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
                                    Profit & Loss Report
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
                            <li><router-link class="waves-effect waves-block" :to="'/report/betLog'">
                                <div class="side_item">
                                    Bet log
                                </div>
                            </router-link></li>
                            <li><router-link class="waves-effect waves-block" to="/management/results">
                                <div class="side_item">
                                    Results
                                </div>
                            </router-link></li>

                        </ul>
                    </li>
                    <li>
                        <router-link to="/settlement" class="">
                            <div class="side_item">
                                <i class="material-icons">swap_calls</i>
                                <span>Settlement</span>
                            </div>

                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
        <addmaster v-if="showModal" @close="showModal = false" :is_super="this.is_super"></addmaster>
    </div>


</template>

<script>
    //import marketMenu from '../components/user/marketListOfMene.vue'

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
        props: ['is_super'],
        data() {
            return {
                page: 'leftsideofleague',
                cricket_events: [],
                soccer_events: [],
                tennis_events: [],
                showModal: false,
            }
        },
        methods: {
            showAdduserModal() {
                this.showModal = true;
            },
           /* getSideData(event_id) {
                window.axios.get(`/api/getEventOfSports/${event_id}`).then(({data}) => {
                    /!* if (data.data.state==0){
                        /!* let index = this.betslipes.findIndex(item => item.id === id);
                         this.betslipes.splice(index, 1);
                         this.mute = false;*!/
                     }*!/
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
            }*/
        },

        created() {
            // this.getSideData(4);
            // this.getSideData(1);
            // this.getSideData(2);
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
        },
        components: {

        }
    }
</script>
