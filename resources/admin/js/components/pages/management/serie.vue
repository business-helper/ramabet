<template>
    <div style="display: flex;flex-wrap: wrap;border-bottom: solid 1px steelblue">
        <div class="sport_item">
            <h6>ID</h6>
            <p>{{id}}-{{sport_id}}</p>
        </div>
        <div class="sport_item">
            <h6>ImportId</h6>
            <p>{{import_id}}</p>
        </div>
        <div class="sport_item">
            <h6>Name</h6>
            <p>{{league_name}}</p>
        </div>
        <div class="sport_item">
            <input v-model="m_isUpdate" type="checkbox" :id="'liveUpdate'+id" class="filled-in" v-on:change="update">
            <label :for="'liveUpdate'+id">LiveUpdate</label>
        </div>
        <div class="sport_item">
            <input v-model="m_is_active" type="checkbox" :id="'is_active'+id" class="filled-in" v-on:change="update">
            <label :for="'is_active'+id">Active</label>
        </div>
        <div class="sport_item">
            <router-link :to="'series/'+league_name+'/'+id" class="btn bg-green waves-effect">View Events</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                m_isUpdate:this.isUpdate,m_is_active:this.is_active
            }
        },
        props: [
            'id','league_name','import_id','sport_id','isUpdate','is_active'
        ],
        mounted() {
            Event.$on('setLiveSeries', (sportId,value) => {
                if (sportId!=this.sport_id)return;
                this.m_isUpdate=value;

            });Event.$on('setAllActive', (sportId,value) => {
                if (sportId!=this.sport_id)return;
                this.m_is_active=value;

            });
        },
        methods: {
            update(){
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/setSeries', {id:this.id,is_active:this.m_is_active,isUpdate:this.m_isUpdate}).then(({data}) => {
                    console.log('-----setSeries-----', data);
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                });
            }
        },
        created() {

        },
        components: {},
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>
