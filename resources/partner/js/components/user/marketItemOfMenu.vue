<template>
    <div style="display: flex">
        <span v-if="this.active=='false'" style="color: #00e700;margin: 0" @click="setActiveMarket('true')">
            <i class="far fa-play-circle"></i>
        </span>
        <span v-else style="color: #e71d00;margin: 0" @click="setActiveMarket('false')">
            <i class="far fa-pause-circle"></i>
        </span>
        <img :class="market_state" @click="setMarket(market_id)">
    </div>

</template>
<script>
    export default {
        data() {
            return {
                market_state:'deactive_market',active:''
            }
        },
        props: [
            'market_id','is_active'
        ],
        mounted() {
            console.log('Event Component mounted.');
            Event.$on('update_multi_market', (r_data) => {
                this.read1(r_data);
            });
        },
        methods:{
            read1(){
                var send_data={};
                send_data.type= 'get';
                send_data.table_name= 'market';
                send_data.condition=[];
                send_data.condition.push(['market_id',this.market_id],['user_id',userID]);
                window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                    //console.log('get updated runners-------------',r_data,data);
                    if (data.data.length>0){
                        this.market_state='active_market'
                    } else{
                        this.market_state='deactive_market';
                    }

                });
            },
            setMarket(id){
                if (this.market_state==='deactive_market'){
                    this.market_state='active_market';
                    var send_data={};
                    send_data.type= 'insert';
                    send_data.table_name= 'market';
                    send_data.data={
                        'market_id':id,
                        'user_id':userID,
                        'user_type':'admins'
                    };
                    console.log(JSON.stringify(send_data));
                    window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                        console.log('insert-------------',data);
                        //Event.$emit('update_multi_market','');
                    });
                } else{
                    this.market_state='deactive_market';
                    var send_data={};
                    send_data.type= 'delete';
                    send_data.table_name= 'market';
                    send_data.condition=[];
                    send_data.condition.push(['market_id',id],['user_id',userID],['user_type','admins']);
                    window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                        console.log('delete-------------',data);
                        //Event.$emit('update_multi_market','');

                    });
                }

            },
            setActiveMarket(state){
                this.active=state;
                window.axios.post('/api/setActiveMarket',{market_id:this.market_id,state:state}).then(({ data }) => {
                    console.log(data);
                    //Event.$emit('betSlipLoading','hide');
                    //showNotification("alert-success", data.message, "top", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            create(data){

            },
            update(id,odd,stake) {

            }
        },
        created() {
            //console.log('Create Element');
            //this.read();
            this.read1();
            this.active=this.is_active;
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