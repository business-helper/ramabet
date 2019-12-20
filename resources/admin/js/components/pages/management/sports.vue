<template>
    <div class="container-fluid" style="">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Sports management
                        </h2>
                    </div>
                    <div class="body">
                       <sport-item
                               v-for="item in sports"
                               v-bind="item"
                               :key="item.id"
                               @update="update">
                       ></sport-item>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SportItem from './sportItem.vue';
    function setSportItem(item) {
        this.sport_item=item;
    }
    export default {
        data() {
            return {
                sports:[]
            }
        },
        props: [

        ],
        mounted() {

        },
        methods: {
            read() {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/getSports', {user_id:this.$route.params.user_id,userType:this.$route.params.userType}).then(({data}) => {
                    console.log('-----GetSport-----', data);
                    // if(res.state == 1){
                    data.data.forEach(item => {
                        this.sports.push(new setSportItem(item));
                    });
                    // }
                });
            },
            update(){

            }
        },
        created() {
            this.read();

            /*this.updateEvent1()*/
        },
        components: {
            SportItem
        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>
