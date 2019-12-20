<template>
    <span class="right" v-if="this.profit>=0" style="color: green">{{this.profit/100}}</span>
    <span class="right" v-else style="color: red">{{this.profit/100}}</span>
</template>
<script>
    export default {

        data() {
            return {
                profit:0
            }
        },
        props: [
            'runner_id','state1'
        ],
        mounted() {
            Event.$on('placedBets', (data) => {
                this.read();
            });
        },
        methods:{
            read() {
                //console.log('Auto get data');
                window.axios.post('/api/getProfit',{runner_id:this.runner_id,user_id:userID,market_name:this.market_name}).then(({ data }) => {
                    //console.log('profit of'+this.runner_id,data);
                    this.profit=data;
                    //Event.$emit('betSlipLoading','hide');
                    //showNotification("alert-success", data.message, "top", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }).catch(function (resp) {
                    console.log(resp);
                });
            },

        },
        created() {
            this.read();

            /*this.updateEvent1()*/
        },
        components: {

        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>