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

            }
        },
        created(){
            //this.getBaner();
            Event.$emit('leftsideofevent', this.$route.params.league_id);
            //console.log('leftsideofevent');
        }
    }
</script>
