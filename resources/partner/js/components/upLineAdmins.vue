<template>
    <div v-if="this.user.length!==0">
        <span>{{this.user.admin.email===undefined?'':this.user.admin.email+'/'}}</span>
        <span>{{this.user.super_master.email===undefined?'':this.user.super_master.email+'/'}}</span>
        <span>{{this.user.master.email===undefined?'':this.user.master.email+'/'}}</span>
        <span>{{this.user.email}}</span>
    </div>
</template>

<script>
    export default {
        data() {
            return {
               user:[]
            }
        },
        props: [
            'user_id',
        ],
        mounted() {
            console.log('Event Component mounted.')
           /* Event.$on('updateEvent',(data)=>{
            });*/
        },
        methods:{
            read() {
                window.axios.get(`/api/getUpLineAdmins/${this.user_id}`).then(({data}) => {
                    //console.log(data);
                    //this.events=data;
                    this.user=data.data
                    //showNotification("alert-success", data.data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                });
            },
        },
        created() {
            //console.log('Create Element');
            this.read();
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
