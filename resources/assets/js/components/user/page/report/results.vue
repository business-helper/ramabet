
<template>
    <div class="container">
        <h1>Market Result</h1>
        <result-market marketStatus="CLOSED"></result-market>
    </div>
</template>

<script>
    import ResultMarket from './result_market.vue';
    export default {
        mounted() {
            console.log('Component mounted.')
            $('body').removeClass('overlay-open');

        },
        data() {
            return {
                admin:[]
            }
        },
        methods:{
           /* getAdmin(){
                window.axios.post('/api/getAdmin', {user_id:this.$userId}).then(({data}) => {
                    console.log('get admin -------------', data);
                    this.admin = data.data;

                });
            }*/
        },
        created(){
            //this.getAdmin();

        },
        components:{
            ResultMarket
        }
    }
</script>
