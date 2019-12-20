<template>
    <aside id="leftsidebar" class="sidebar" style="overflow: auto; padding-bottom: 100px;">
        <div class="list-group league">
            <a href="#/multi_market" class="list-group-item">
                <img class="star"/>
                <span>Favourites</span>
            </a>
            <a href="#/" class="list-group-item">
                <span style="font-size: 14px;">
                    <i class="fas fa-home"></i>
                </span>
                <span>Sports</span>
            </a>
            <a :href="'#sport/'+current_sport.id" class="list-group-item current_sports" v-bind:style="{'background-color':this.current_sport.color,'color':'#fff'}">
                <img :class="this.current_sport['icon']"/>
                <span>{{this.current_sport.name}}</span>
            </a>
            <!--<a class="list-group-item" onclick="window.history.go(-1); return false;" v-bind:style="{'color': this.current_sport.color}">
                <span style="font-size: 14px;">
                    <i class="fas fa-chevron-circle-left"></i>
                </span>
                <span>
                    Previous
                </span>
            </a>-->
            <a v-for="item in this.markets" class="list-group-item" @click="selectMarket(item.id)">
                <span style="text-overflow: ellipsis;display: inline-block; overflow: hidden; width: 90%; height: 1.2em; white-space: nowrap;" :title="item.marketName">{{item.marketName}}</span>
                <span style="float: right;"><i class="fas fa-chevron-right"></i></span>
            </a>
        </div>
    </aside>
</template>
<style>
    .league a{
        height: 30px!important;
        padding-top: 5px;
    }
    .league a img{
        height: 15px;
        width: 15px;
    }

</style>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            Event.$on('leftsideofleague',(data) => {
                this.read();
            });
        },
        methods:{
            read(){
                window.axios.get(`/api/getMarketOfEvent/${this.$route.params.event_id}`).then(({ data }) => {
                    console.log(data);
                    this.current_sport=data.data.current_sport;
                    this.markets=data.data.markets;
                });
            },
            selectMarket(id){
                Event.$emit('selectMarket',id);
            }
        },
        data(){
            return {
                current_sport:[],markets:[]
            };
        },
        created(){
            this.read();
        }
    }
</script>
