<style>

</style>
<template>
    <div v-if="this.$isSuper==0" class="container">
        <h1>Market Result</h1>
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#stat_done">Done Markets</a>
            </li>
            <li>
                <a data-toggle="tab" href="#state_undeclared">UnDeclared Markets</a>
            </li>
            <li>
                <a data-toggle="tab" href="#state_abandone" id="admin_tab_1" >Suspended markets</a>
            </li>
            <li>
                <a data-toggle="tab" href="#suspend" id="admin_tab_2">Abandoned Markets</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="stat_done" class="tab-pane fade in active">
               <result-market marketStatus="CLOSED"></result-market>
            </div>
            <div id="state_undeclared" class="tab-pane fade">
                <result-market marketStatus="OPEN"></result-market>
            </div>
            <div id="state_abandone" class="tab-pane fade">
                <result-market marketStatus="SUSPENDED"></result-market>
            </div>
            <div id="suspend" class="tab-pane fade">
                <result-market marketStatus="CANCELED"></result-market>
            </div>
        </div>
    </div>
    <div v-else class="container">
        <h1>Market Result</h1>
        <result-market marketStatus="DONE"></result-market>
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
