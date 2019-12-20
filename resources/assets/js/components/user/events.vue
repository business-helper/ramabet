<template>
    <div class="table_div">
        <h4 :class="is_show_event">There is no live events</h4>
        <div class="lds-facebook" :class="is_show"><div></div><div></div><div></div></div>
        <div class="" :class="show_table">
            <event v-for="event in events"
                   :key="event.id"
                   :value="event"
                   :event_data="event">
            </event>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                events:[],is_show:'show',is_show_event:'hide',show_table:'hide'
            }
        },
        props: [
            'page','target_id','inPlay'
        ],
        mounted() {
            console.log('Event Component mounted.')
            Event.$on('updatedOfSport',(data) => {
                if (this.page=='sport'){
                    this.read();
                }
                else{
                    this.read1();
                }
            });
            Event.$on('removeEvent',(market) => {
                this.refresh();
            });
            Event.$on('marketUpdate', (market) => {
                this.refresh();
            });
        },
        methods:{
            refresh(){
                console.log('refreshing');
                var getEvents=[];
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post(`/api/getEventOfSports`,{id:this.target_id,user_id:this.$userId,user_type:'users',inPlay:this.inPlay}).then(({data}) => {
                    getEvents=data;
                    this.events=getEvents;
                    if (this.events.length===0){
                        this.is_show_event='show';
                        this.show_table='hide';
                    }
                    else{
                        this.show_table='show';
                        this.is_show_event='hide';
                    }

                    //showNotification("alert-success", data.data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                });
            },
            read() {
                this.mute = true
                this.events=[];
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post(`/api/getEventOfSports`,{id:this.target_id,user_id:this.$userId,user_type:'users',inPlay:this.inPlay}).then(({data}) => {
                   /* if (data.data.state==0){
                       /!* let index = this.betslipes.findIndex(item => item.id === id);
                        this.betslipes.splice(index, 1);
                        this.mute = false;*!/
                    }*/
                    console.log('get events of sport',data);

                    this.events=data;
                    if (this.events.length===0){
                        this.is_show_event='';
                    }
                    else{
                        this.show_table='';
                    }
                    this.is_show='hide';
                    this.mute = false
                    //showNotification("alert-success", data.data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                });
            },
            read1() {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post(`/api/getEventOfSports`,{id:this.target_id,user_id:this.$userId,user_type:'users',inPlay:this.inPlay}).then(({data}) => {
                    /* if (data.data.state==0){
                        /!* let index = this.betslipes.findIndex(item => item.id === id);
                         this.betslipes.splice(index, 1);
                         this.mute = false;*!/
                     }*/
                    console.log('get events of sport',data);
                    this.events=data;
                    if (this.events.length===0){
                        this.is_show_event='';
                    }
                    else{
                        this.show_table='';
                    }
                    this.is_show='hide';
                    //showNotification("alert-success", data.data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                });
            },
            create(data){
                /*this.mute = true;
                this.betslipes.push(new BetSlip(data));
                this.mute = false;*/
            },
            update(id,odd,stake) {
                //alert('updated',odd);
                /*this.mute = true;
                console.log('updated odd:',id,odd,stake)
                window.axios.post(`/api/updateBetslip/${id}`, { id:id,odd:odd,stake:stake }).then((data) => {
                    console.log(data);
                    this.betslipes.find(item => item.id === id).odd = odd;
                    this.betslipes.find(item => item.id === id).stake = stake;
                    this.mute = false;
                    this.calculate();
                });*/
            },
        },
        created() {
            //console.log('Create Element');
            if (this.page==='sport'){
                this.read();
            }
            else{
                this.read1();
            }
        },
        components: {
            //BetSlipItem
        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>
