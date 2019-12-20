<template>
    <div class="container-fluid" style="">
        <events page="sport" :target_id="this.$route.params.sport_id"  inPlay="all" activation="1"></events>
    </div>
</template>

<script>
    export default {
        mounted() {
            $('body').removeClass('overlay-open');
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
            Event.$emit('leftsideofleague', this.$route.params.sport_id);
            console.log('leftsideofleague');
        }
    }
</script>
