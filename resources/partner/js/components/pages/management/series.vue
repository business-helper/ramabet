<template>
    <div class="container">
        <h1>Seires List</h1>
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#soccor" id="admin_tab_0">Soccer</a>
            </li>
            <li>
                <a data-toggle="tab" href="#cricket" id="cricket_0" >Cricket</a>
            </li>
            <li>
                <a data-toggle="tab" href="#tennis" id="tennis_0">Tennis</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="soccor" class="tab-pane fade in active">
                <div style="display: flex;flex-wrap: wrap;border-bottom: solid 1px steelblue">
                    <div class="sport_item">

                    </div>
                    <div class="sport_item">

                    </div>
                    <div class="sport_item">

                    </div>
                    <div class="sport_item">
                        <input v-model="soccerAllLive" type="checkbox" :id="'liveUpdate_soccer'" class="filled-in" v-on:change="selectAll(1,soccerAllLive)">
                        <label :for="'liveUpdate_soccer'">All</label>
                    </div>
                    <div class="sport_item">
                        <input v-model="soccerAllActive" type="checkbox" :id="'liveActive_soccer'" class="filled-in" v-on:change="selectAllActive(1,soccerAllActive)">
                        <label :for="'liveActive_soccer'">All</label>
                    </div>
                    <div class="sport_item">

                    </div>
                </div>
                <serie
                        v-for="item in series"
                        v-bind="item"
                        v-if="item.sport_id==1"
                        :key="item.id"
                        @update="update">
                    ></serie>
            </div>
            <div id="cricket" class="tab-pane fade">
                <div style="display: flex;flex-wrap: wrap;border-bottom: solid 1px steelblue">
                    <div class="sport_item">

                    </div>
                    <div class="sport_item">

                    </div>
                    <div class="sport_item">

                    </div>
                    <div class="sport_item">
                        <input v-model="soccerAllLive" type="checkbox" :id="'liveUpdate_cricket'" class="filled-in" v-on:change="selectAll(4,soccerAllLive)">
                        <label :for="'liveUpdate_cricket'">All</label>
                    </div>
                    <div class="sport_item">
                        <input v-model="soccerAllActive" type="checkbox" :id="'liveActive_cricket'" class="filled-in" v-on:change="selectAllActive(4,soccerAllActive)">
                        <label :for="'liveActive_cricket'">All</label>
                    </div>
                    <div class="sport_item">

                    </div>
                </div>
                <serie
                        v-for="item in series"
                        v-bind="item"
                        :key="item.id"
                        v-if="item.sport_id==4"
                        @update="update">
                    ></serie>
            </div>

            <div id="tennis" class="tab-pane fade">
                <div style="display: flex;flex-wrap: wrap;border-bottom: solid 1px steelblue">
                    <div class="sport_item">

                    </div>
                    <div class="sport_item">

                    </div>
                    <div class="sport_item">

                    </div>
                    <div class="sport_item">
                        <input v-model="soccerAllLive" type="checkbox" :id="'liveUpdate_tennis'" class="filled-in" v-on:change="selectAll(2,soccerAllLive)">
                        <label :for="'liveUpdate_tennis'">All</label>
                    </div>
                    <div class="sport_item">
                        <input v-model="soccerAllActive" type="checkbox" :id="'liveActive_tennis'" class="filled-in" v-on:change="selectAllActive(2,soccerAllActive)">
                        <label :for="'liveActive_tennis'">All</label>
                    </div>
                    <div class="sport_item">

                    </div>
                </div>
                <serie
                        v-for="item in series"
                        v-bind="item"
                        v-if="item.sport_id==2"
                        :key="item.id"
                        @update="update">
                    ></serie>
            </div>
        </div>
    </div>

</template>

<script>
    import Serie from './serie.vue';
    function setSerie(item) {
        this.id=item.id;
        this.league_name=item.league_name;
        this.import_id=item.import_id;
        this.sport_id=item.sport_id;
        this.isUpdate=item.isUpdate;
        this.is_active=item.is_active;
    }
    export default {
        data() {
            return {
                series:[],soccerAllLive:false,soccerAllActive:false
            }
        },
        props: [

        ],
        mounted() {

        },
        methods: {
            read() {
                window.axios.post('/api/getSeries', {user_id:this.$route.params.user_id,userType:this.$route.params.userType}).then(({data}) => {
                    console.log('-----GetSeries-----', data);
                    // if(res.state == 1){
                    data.data.forEach(item => {
                        this.series.push(new setSerie(item));
                    });
                    // }
                });
            },
            update(){

            },
            selectAll(sportId,value){
                console.log(sportId,value)
                window.axios.post('/api/setSeriesAll', {id:sportId,isUpdate:value}).then(({data}) => {
                    console.log('-----setSeries-----', data);
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    Event.$emit('setLiveSeries',sportId,value)
                });
            },
            selectAllActive(sportId,value){
                console.log(sportId,value)
                window.axios.post('/api/setSeriesAll', {id:sportId,is_active:value}).then(({data}) => {
                    console.log('-----setSeries-----', data);
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    Event.$emit('setAllActive',sportId,value)
                });
            }

        },
        created() {
            this.read();

            /*this.updateEvent1()*/
        },
        components: {
            Serie
        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>