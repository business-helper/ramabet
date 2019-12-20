<template>
    <div class="container-fluid" style="padding-bottom: 200px;padding-top: 40px">
        <events page="" :target_id="this.$route.params.league_id"></events>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                link_list:[],available_balance:'',winnings:''
            }
        },
        methods:{
            getBaner(){
                var send_data={};
                send_data.type= 'get';
                send_data.table_name= 'link_list';
                send_data.condition=[];
                send_data.condition.push(['is_active','true']);
                window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {

                    this.link_list=data.data;
                    console.log('Get LinkList----------------------',this.link_list);

                });
            }
        },
        created(){
            //this.getBaner();
            Event.$emit('leftsideofevent', this.$route.params.league_id);
            //console.log('leftsideofevent');
        }
    }
</script>
