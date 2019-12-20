<template>
    <div class="row clearfix" style="padding-bottom: 200px;padding-top: 40px">
        <div class="card">
            <div class="header">
                <div style="width: 200px">
                    <label>Sports:</label>
                    <select class="" v-model="c_sid" v-on:change="changeSport">
                        <option value="-1">all</option>
                        <option value="4">cricket</option>
                        <option value="1">soccer</option>
                        <option value="2">tennis</option>
                    </select>
                </div>
                <h2 v-if="markets.length==0">There is no any market
                </h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable marketresulttable">
                        <thead>
                        <tr>
                            <th class="">S.No. </th>
                            <th class="">Event</th>
                            <th class="">Winner</th>
                            <th class="">Market</th>
                            <th class="">P|L</th>
                            <th class="">State</th>
                            <th class="">Date</th>
                            <!--<th class="">Action</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in markets" v-bind="item" v-if="c_sid==-1 || c_sid==item.sport_id">
                            <td>{{item.id}}</td>
                            <td>{{item.eventName}}</td>
                            <td>{{item.winnerName}}</td>
                            <td>{{item.marketName}}</td>
                            <td :class="item.pAndL>=0?'profit_color':'loss_color'">{{item.pAndL}}</td>
                            <td>{{item.marketStatus}}</td>
                            <td>{{item.updated_at}}</td>
                            <!--<td>
                                <button type="button" class="btn light-green waves-effect" @click="Undeclare(item.id)">UnDeclare</button>
                            </td>-->
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable marketresulttable">
                        <thead>
                        <tr>
                            <th class="">S.No. </th>
                            <th class="">Event</th>
                            <th class="">Score</th>
                            <th class="">Fancy</th>
                            <th class="">P|L</th>
                            <th class="">State</th>
                            <th class="">Date</th>
                            <!--<th class="">Action</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in fancyMarkets" v-bind="item" v-if="c_sid==-1 || c_sid==item.sport_id">
                            <td>{{item.id}}</td>
                            <td>{{item.eventName}}</td>
                            <td>{{item.score}}</td>
                            <td>{{item.runnerName}}</td>
                            <td :class="item.pAndL>=0?'profit_color':'loss_color'">{{item.pAndL}}</td>
                            <td>{{item.runnerStatus}}</td>
                            <td>{{item.updated_at}}</td>
                            <!--<td>
                                <button type="button" class="btn light-green waves-effect" @click="Undeclare(item.id)">UnDeclare</button>
                            </td>-->
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</template>
<script>

    export default {
        data() {
            return {
                runners:[],is_show:'show',event:[],market:[],markets:[],fancyMarkets:[],currentMarketId:'',widthOfWindow:900,mdt:'',c_sid:-1
            }
        },
        props: [
            'market_id','marketStatus'
        ],
        mounted() {
            $('body').removeClass('overlay-open');
            console.log('Multi market Component mounted.');
            Event.$on('setResultOfMarket', (data) => {
                this.read1();
            });
            Event.$on('changeWidth', (data) => {
                this.widthOfWindow=data;
                //console.log(data);
            });

            Event.$on('delPlacedBets',(data) => {
                this.read1();
            });
            Event.$on('getDeclare',(data) => {
                if (data==null)return;
                this.read1();
            });
        },
        methods:{
            changeSport(){
                console.log(this.c_sid);
                if (this.mdt!=="") this.mdt.destroy();
                this.$nextTick(() => {
                    this.mdt = $('.marketresulttable').DataTable({
                        dom: 'lBfrtip',
                        responsive: true,
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        lengthMenu: [[5, 10, 25, 50,-1],[5, 10, 25, 50,'all']],
                        order: [[ 0, "desc" ]]
                    });
                });
            },
            read1(){

                //if (this.dt!=="") this.dt.destroy();
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/getMarketOfStatus', {marketStatus:this.marketStatus,userType:'users',userId:this.$userId}).then(({data}) => {
                    console.log('marketResult',data);
                    this.markets=data.data.markets;
                    this.fancyMarkets=data.data.fancyMarkets;

                    if (this.mdt!=="") this.mdt.destroy();
                    this.$nextTick(() => {
                        this.mdt = $('.marketresulttable').DataTable({
                            dom: 'lBfrtip',
                            responsive: true,
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ],
                            lengthMenu: [[5, 10, 25, 50,-1],[5, 10, 25, 50,'all']],
                            order: [[ 0, "desc" ]]
                        });
                    });
                    //console.log('-----setSeries-----', data);
                    /*showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');*/
                });
            },
            create(data){
            },
            update(id,odd,stake) {

            },
            Undeclare(market_id){
                window.axios.post('/api/unDeclare', {market_id:market_id,user_id:this.$userId}).then(({data}) => {

                    showNotification("alert-success", data.message, "bottom", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                    this.market.market_result='none';
                });
            },
        },
        created() {
            //console.log('Create Element');
            //this.read();
            this.widthOfWindow=window.innerWidth;
            this.read1();
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
