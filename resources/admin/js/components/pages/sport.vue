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

            }
        },
        created(){
            //this.getBaner();
            Event.$emit('leftsideofleague', this.$route.params.sport_id);
            console.log('leftsideofleague');
        }
    }
</script>
