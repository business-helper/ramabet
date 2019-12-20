<template>
    <ul class="ml-menu">
        <li v-for="s in this.markets">
            <router-link :to="'/multi_market/'"
                         class=" waves-effect waves-block">
                <marketItem :market_id="s.id" :is_active="s.is_active"></marketItem>{{s.marketName}}
            </router-link>
        </li>
    </ul>
</template>
<script>
    import marketItem from './marketItemOfMenu.vue';
    export default {
        data() {
            return {
                markets:[],market_state:'deactive_market'
            }
        },
        props: [
            'event_id'
        ],
        mounted() {
            console.log('Event Component mounted.');
        },
        methods:{
            read1(){
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getEventDetail/${this.event_id}`).then(({data}) => {
                    this.markets=data.data.markets;
                    console.log('marketdata1',this.markets);
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
        },
        components: {
            marketItem
        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>
