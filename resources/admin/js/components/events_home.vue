<style>
    .one_event {
        display: flex;
        justify-content: start;
        align-items: center;
        min-height: 40px;
        padding-top: 5px;
        margin-bottom: 5px;
        border-top: 1px solid #dddddd;
        flex-wrap: wrap;
    }
</style>
<template>
    <div class="table_div">
        <h4 :class="is_show_event">There is no Live Events</h4>
        <div class="lds-facebook" :class="is_show">
            <div></div>
            <div></div>
            <div></div>
        </div>
            <eventhome v-for="event in events"
                   :key="event.id"
                   :value="event"
                   :event_data="event">
            </eventhome>
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
            'page','target_id', 'type'
        ],
        mounted() {
            console.log('Event Component mounted.')
            Event.$on('updateEvent',(data)=>{
                if (this.page==='sport'){
                    this.read();
                }
                else{
                    this.read1();
                }
            });
        },
        methods:{
            read() {
                console.log(this.target_id);
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getEventOfSports/${this.target_id}/${this.type}`).then(({data}) => {
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
            read1() {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getEventOfLeague/${this.target_id}`).then(({data}) => {
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
