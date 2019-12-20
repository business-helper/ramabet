<template>
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

            </li>
            <li>
                <router-link to="/sport/2">
                    <div class="side_item">
                        <img class="tennis">
                        <span>Tennis</span>
                    </div>

                </router-link>

            </li>
            <li>
                <router-link to="/sport/1" >
                    <div class="side_item">
                        <img class="soccer">
                        <span>Soccer</span>
                    </div>

                </router-link>
            </li>
        </ul>
    </div>


</template>

<script>
    //import marketMenu from '../marketListOfMene.vue'

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
