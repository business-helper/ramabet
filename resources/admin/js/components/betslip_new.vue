

<template>
    <div class="sticky-tabs">
        <!-- tabs -->
        <ul class="nav nav-tabs match-tabs">
            <li id="MatchedTab" class="active"><a data-toggle="tab" href="#scorePos" aria-expanded="true">Open
                Bets</a></li>

            <!--<li class=""><a id="scoreBookTab" data-toggle="tab" href="#scoreBook" aria-expanded="false">Score Books</a></li>-->
            <li id="tvStreamTab"><a data-toggle="tab" href="#tvStream">TV Streaming</a></li>
            <li><a data-toggle="tab" href="#userPosition">UserPosition</a></li>
            <li><a data-toggle="tab" href="#liveStatus">Live Status</a></li>
        </ul>
        <!-- tab contents -->

        <div class="tab-content match-tabs-content">
            <div id="tvStream" class="tab-pane fade">
                <div class="box box-primary Dcursor" tabindex="1">

                    <div class="box-body" style="text-align: center">
                        <iframe frameborder="0" width="358" height="250"
                                scrolling="no" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"
                                src="https://365livestreaming.in/channel_list.php"></iframe>
                        <div id="dvPlayer"></div>
                    </div>
                </div>
            </div>
            <div id="liveStatus" class="tab-pane fade">
                <div class="box box-primary Dcursor" tabindex="1">
                    <div class="box-body" style="text-align: center">
                        <iframe class="player" frameborder="0" width="334" height="190"
                                scrolling="no" :key="this.event_id"
                                :src="'https://videoplayer.betfair.com/GetPlayer.do?eID='+this.event_id+'&width=334&height=190&contentType=viz&contentOnly=false'"></iframe>
                        <iframe class="player" frameborder="0" width="334" height="190"
                                scrolling="no" :key="this.event_id"
                                :src="'https://videoplayer.betfair.com/GetPlayer.do?tr=1&eID='+this.event_id+'&width=334&height=190&contentType=viz&contentOnly=false&contentView=mstats&statsToggle=hide'"></iframe>
                    </div>
                </div>

            </div>
            <div id="userPosition" class="tab-pane fade">
                <p style="font-size: 12px;font-weight: 600;text-align: center" v-if="total_count==0">There are No Open bets yet</p>
                <div v-else>
                    <div v-if="this.total_count!==0" class="panel-group full-body" id="userPosition_div" role="tablist" aria-multiselectable="true" style="margin-bottom: 5px;">
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="userPosition_tab" style="background-color: #082a49; color: white;">
                                <span class="panel-title" style=" text-align: left; padding: 0; font-size: 16px;">
                                    <a role="button" data-toggle="collapse" href="#userPosition_tab_col" aria-expanded="false" aria-controls="userPosition_tab_col" class="collapsed" style="    padding: 0px 15px;">
                                        User Position1 [{{this.markets.length}}]
                                    </a>
                                </span>
                            </div>
                            <div id="userPosition_tab_col" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="unmatched_tab_col" aria-expanded="true" >
                                <div class="panel-body" style="padding: 0">
                                    <button style="padding: 0; width: 50px; float: right;" class="btn btn-success waves-effect waves-circle waves-float"  name="result_session" @click="backPosition">Back</button>

                                    <select v-if="markets.length!==0" class="form-control show-tick" @change="ChangeMarketOfPosition" style="width: 300px">
                                        <option value="0">Select event</option>
                                        <option v-for="item in this.markets" v-bind:value="item.id" >{{item.eventName}}
                                        </option>
                                    </select>

                                    <table class="table table-bordered table-condensed" style="margin: 0;">
                                        <thead>
                                        <tr style="color: #585858" >
                                            <th style="">User</th>
                                            <th v-for="item in runners[c_marketForPosition]" style="">{{item.runnerName}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="tbUMatchedB" v-if="c_marketForPosition!==0">
                                        <tr v-for="item in userPosition[c_marketForPosition]">
                                            <td>
                                                <a v-if="item.account.type=='admins'" @click="getUserPosition(item.account.id)">
                                                    {{item['account']['name']}}
                                                </a>
                                                <span v-else>
                                                        {{item['account']['name']}}
                                                    </span>

                                            </td>
                                            <td v-for="profit in item.profits" >
                                                    <span v-if="profit>=0" style="color: #0000ff">
                                                        {{profit}}
                                                    </span>
                                                <span v-else style="color: red">
                                                        {{profit}}
                                                    </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p  style="font-size: 12px;font-weight: 600;text-align: center" v-else>There are user position</p>

                </div>

            </div>

            <div id="scorePos" class="tab-pane fade active in">
                <!-- Div score position There are No Open bets yet-->
                <p style="font-size: 12px;font-weight: 600;text-align: center" v-if="total_count+fancyBets.length==0">There are No Open bets yet</p>
                <div v-else>
                    <select v-if="total_count!==0" class="form-control show-tick" @change="ChangeMarket" v-model="c_market">
                        <option value="0">All({{this.total_count}})</option>
                        <option v-for="item in this.markets" v-bind:value="item.id">{{item.eventName}}-{{item.marketName}}({{item.count}})</option>
                    </select>
                    <div v-if="this.placedBetsOfUnMatched.length!==0" class="panel-group full-body" id="dvUnMBeat" role="tablist" aria-multiselectable="true" style="margin-bottom: 5px;">
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="unmatched_tab" style="background-color: #082a49; color: white;">
                                <span class="panel-title" style=" text-align: left; padding: 0; font-size: 16px;">
                                    <a role="button" data-toggle="collapse" href="#unmatched_tab_col" aria-expanded="false" aria-controls="unmatched_tab_col" class="collapsed" style="    padding: 0px 15px;">
                                        Unmatched Bets <b id="UnMatCount">[{{this.placedBetsOfUnMatched.length}}]</b>
                                    </a>
                                </span>
                            </div>
                            <div id="unmatched_tab_col" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="unmatched_tab_col" aria-expanded="true" >
                                <div class="panel-body" style="padding: 0">
                                    <table id="tbUnMatched" class="table table-bordered table-condensed" style="margin: 0;">
                                        <thead>
                                        <tr style="color: #585858">
                                            <th style="">del</th>
                                            <th style="">id</th>
                                            <th style="">Name</th>
                                            <th style="">Runner</th>
                                            <th style="">Odds</th>
                                            <th style="">Stake</th>
                                            <th style="">Side</th>
                                            <th style="">Date</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbUnmBody" class="tbUMatchedB">
                                        <tr v-for="item in this.placedBetsOfUnMatched" :class="item.bet_type">
                                            <!--<td valign="top" colspan="5" class="dataTables_empty">No data available
                                                in table
                                            </td>-->
                                            <td>
                                                <div class="btn btn-danger betslip_close right" @click="del(item.id)"><i class="fas fa-times"></i></div>
                                            </td>
                                            <td>
                                                {{item.id}}
                                            </td>
                                            <td>
                                                <!--<upLineAdmins :user_id="item.user_id"></upLineAdmins>-->
                                                {{item.accountNames}}
                                            </td>
                                            <td>
                                                {{item.runnerName}}
                                            </td>
                                            <td>
                                                {{item.odd}}
                                            </td>
                                            <td>
                                                {{item.stake}}
                                            </td>
                                            <td>
                                                {{item.bet_type=="availableToBack"?'Back':'Lay'}}
                                            </td>
                                            <td>
                                                {{item.at_update}}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p  style="font-size: 12px;font-weight: 600" v-else>There are No UnMatched bets yet</p>
                    <div v-if="this.placedBetsOfMatched.length!==0" class="panel-group full-body" id="" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="matched_tab" style="background-color: #082a49; color: white;">
                                <span class="panel-title" style=" text-align: left; padding: 0; font-size: 16px;">
                                    <a role="button" data-toggle="collapse" href="#matched_tab_col" aria-expanded="false" aria-controls="collapseOne_21" class="collapsed" style="    padding: 0px 15px;">
                                        Matched Bets
                                        <b id="MatCount">[{{this.placedBetsOfMatched.length}}]</b>
                                    </a>
                                </span>
                            </div>
                            <div id="matched_tab_col" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="unmatched_tab_col" aria-expanded="true" >
                                <div class="panel-body" style="padding: 0">
                                    <table id="tbMatched"
                                           class="table table-bordered table-condensed dataTable no-footer"
                                           style="margin: 0;" role="grid">
                                        <thead id="1.162601258mExist">
                                        <tr style="color: #585858" role="row">
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">id</th>
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">Name</th>
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">Runner</th>
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">Odds</th>
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">Stake </th>
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">Side </th>
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">Date</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbMatBody">
                                        <tr v-for="item in this.placedBetsOfMatched" :class="item.bet_type">
                                            <!--<td valign="top" colspan="5" class="dataTables_empty">No data available
                                                in table
                                            </td>-->
                                            <td>
                                                {{item.id}}
                                            </td>
                                            <td>
                                                <!--<upLineAdmins :user_id="item.user_id"></upLineAdmins>-->
                                                {{item.accountNames}}
                                            </td>
                                            <td>
                                                {{item.runnerName}}
                                            </td>
                                            <td>
                                                {{item.odd}}
                                            </td>
                                            <td>
                                                {{item.stake}}
                                            </td>
                                            <td>
                                                {{item.bet_type=="availableToBack"?'Back':'Lay'}}
                                            </td>
                                            <td>
                                                {{item.at_update}}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p style="font-size: 12px;font-weight: 600;text-align: center" v-else>There are No Matched bets yet</p>
                    <p style="font-size: 12px;font-weight: 600;text-align: center" v-if="fancyBets.length==0">There are No Fancy bets yet</p>
                    <div v-else>
                        <div class="panel-group full-body" role="tablist" aria-multiselectable="true">
                            <div class="panel">
                                <select v-if="fancy_runners.length!==0" class="form-control show-tick" v-model="c_fancy">
                                    <option value="0">All</option>
                                    <option v-for="item in this.fancy_runners" v-bind:value="item.id">{{item.eventName}}-{{item.runnerName}}</option>
                                </select>

                                <div class="panel-heading" role="tab" id="fancy_tab" style="background-color: #082a49; color: white;">
                                <span class="panel-title" style=" text-align: left; padding: 0; font-size: 16px;">
                                    <a role="button" data-toggle="collapse" href="#fancy_tab_col" aria-expanded="false" aria-controls="collapseOne_21" class="collapsed" style="    padding: 0px 15px;">
                                        Fancy Bets
                                        <b >[{{this.fancyBets.length}}]</b>
                                    </a>
                                </span>
                                </div>
                                <div id="fancy_tab_col" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="fancy_tab_col" aria-expanded="true" >
                                    <div class="panel-body" >

                                        <table class="table table-bordered table-condensed" style="margin: 0;">
                                            <thead>
                                            <tr style="color: #585858">
                                                <th style="" class="sorting_disabled"
                                                    rowspan="1" colspan="1">id</th>
                                                <th style="">User</th>
                                                <th style="">Fancy</th>
                                                <th style="">Score</th>
                                                <th style="">Amount</th>
                                                <th style="">Rate</th>
                                                <th style="">Date</th>
                                            </tr>
                                            </thead>
                                            <tbody class="tbUMatchedB">
                                            <tr v-for="item in this.fancyBets" :class="item.bet_type"  v-if="item.runner_id==c_fancy || c_fancy==0">

                                                <td>
                                                    {{item.id}}
                                                </td>
                                                <td>
                                                    {{item.accountNames}}
                                                </td>
                                                <td>
                                                    {{item.runnerName}}
                                                </td>
                                                <td>
                                                    {{item.rate}}
                                                </td>
                                                <td>
                                                    {{item.stake}}
                                                </td>
                                                <td>
                                                    {{(item.odd*100-100).toFixed(2)}}
                                                </td>
                                                <td>
                                                    {{item.at_update}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

            <div id="scoreBook" class="tab-pane fade">
                <!-- Div score position There are No Open bets yet-->
                <p style="font-size: 12px;font-weight: 600;text-align: center" v-if="scoreBook.length==0">There are No Fancy bets yet</p>
                <div v-else>
                    <div class="panel-group full-body" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="scoreBook_tab" style="background-color: #082a49; color: white;">
                                <span class="panel-title" style=" text-align: left; padding: 0; font-size: 16px;">
                                    <a role="button" data-toggle="collapse" href="#fancy_tab_col" aria-expanded="false" aria-controls="collapseOne_21" class="collapsed" style="    padding: 0px 15px;">
                                        {{this.runnerName}}
                                    </a>
                                </span>
                            </div>
                            <div id="scoreBook_tab_col" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="fancy_tab_col" aria-expanded="true" >
                                <div class="panel-body" style="max-height: 500px; overflow: auto;">
                                    <table class="table table-bordered table-condensed" style="margin: 0;">
                                        <thead>
                                        <tr style="color: #585858">
                                            <th style="">Score</th>
                                            <th style="">Liability</th>
                                        </tr>
                                        </thead>
                                        <tbody class="tbUMatchedB">
                                        <tr v-for="item in this.scoreBook" >

                                            <td>
                                                {{item.rate}}
                                            </td>
                                            <td :class="item.profit>=0?'profit_color':'loss_color'">
                                                {{item.profit}}
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>

    </div>
</template>
<script>
    import upLineAdmins from './upLineAdmins.vue'
    export default {
        data() {
            return {
                placedBetsOfMatched: [],placedBetsOfUnMatched:[],markets:[],total_count:0,is_load:'show',nodata:'show',matchedOddMarkets:[],exposureOfAccounts:[],c_marketForPosition:0,userPosition:[],posHis:[],runners:[],event_id:this.event_import_id,c_market:0,scoreBook:[],fancyBets:[],runnerName:'',fancy_runners:[],c_fancy:0
            }
        },
        props: [
            'time_status','event_import_id'
        ],

        mounted() {
            Event.$on('setEvent',(data) => {
                this.event_id=data;
            });
            Event.$on('scoreBook',(runner_id,runnerName) => {
                this.runnerName=runnerName;
                this.readScoreBook(runner_id);
            });
            Event.$on('placedBetLoading',(data) => {
                this.is_load=data;
            });
            Event.$on('placedBets',(note) => {

                var data=note.adminOpenBet[this.$userId];
                console.log('placed new bet',data.fancy_runners,this.fancy_runners);
                this.placedBetsOfMatched=[];
                this.placedBetsOfUnMatched=[];
                if (data.matched!=undefined){
                    this.placedBetsOfMatched=data.matched;
                }
                if (data.ummatched!=undefined){
                    this.placedBetsOfUnMatched=data.ummatched;
                }
                if (data.fancyBets!=undefined){
                    this.fancyBets=data.fancyBets;
                    this.fancy_runners=data.fancy_runners;
                }
                this.markets=data.markets;

                this.total_count=data.total_count;
                this.c_market=note.market_id;
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getUserPosition/${this.$userId}`).then(({ data }) => {
                    console.log('get user position',data)
                    this.userPosition=data.data.userPosition;
                    this.runners=data.data.runners;
                });
            });
            Event.$on('matchedBet',(market_id,data) => {
                //this.read();
                this.placedBetsOfMatched=[];
                this.placedBetsOfUnMatched=[];
                if (data.matched==undefined){
                    this.placedBetsOfUnMatched=[];
                } else{
                    this.placedBetsOfMatched=data.matched;
                }
                if (data.ummatched==undefined){
                    this.placedBetsOfUnMatched=[];
                } else{
                    this.placedBetsOfUnMatched=data.ummatched;
                }


                this.markets=data.markets;
                this.total_count=data.total_count;
                this.c_market=market_id;
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getUserPosition/${this.$userId}`).then(({ data }) => {
                    console.log('get user position',data)
                    this.userPosition=data.data.userPosition;
                    this.runners=data.data.runners;
                });
            });
            Event.$on('removeEvent', (r_data) => {
                this.read();
            });
            Event.$on('delPlacedBets', (r_data) => {
                let index = this.placedBetsOfUnMatched.findIndex(item => item.id === r_data.bet_item.id);
                this.placedBetsOfUnMatched.splice(index, 1);
                Event.$emit('updateBalance', 1);
            });
            /*Event.$on('userLogged',(userId) => {
                this.$userId=userId;
                this.read();
            });*/
        },
        methods:{
            getUserPosition(user_id){
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getUserPosition/${user_id}`).then(({ data }) => {
                    console.log('get user position',data)
                    this.userPosition=data.data.userPosition;
                    this.runners=data.data.runners;
                    this.posHis.push(user_id);
                });
            },
            backPosition(){
                this.posHis.pop();
                var user_id=0;
                if (this.posHis.length==0){
                    user_id=this.$userId;
                }else{
                    user_id=this.posHis[this.posHis.length-1];
                }
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getUserPosition/${user_id}`).then(({ data }) => {
                    console.log('get user position',data)
                    this.userPosition=data.data.userPosition;
                    this.runners=data.data.runners;
                });
            },
            read() {
                //this.is_load='show';
                this.placedBetsOfMatched=[];
                this.placedBetsOfUnMatched=[];
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getPlacedBetSlipsAdmin/${this.$userId}`).then(({ data }) => {
                    console.log('getdata liveBet',data)
                    this.placedBetsOfMatched=data.matched;
                    this.placedBetsOfUnMatched=data.ummatched;
                    this.fancyBets=data.fancyBets;
                    this.markets=data.markets;
                    this.fancy_runners=data.fancy_runners;
                    this.total_count=data.total_count;
                });
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getUserPosition/${this.$userId}`).then(({ data }) => {
                    console.log('get user position',data)
                    this.userPosition=data.data.userPosition;
                    this.runners=data.data.runners;
                });

            },
            read1(market_id) {
                this.is_load='show';
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getPlacedBetSlipsAdmin/${this.$userId}/${market_id}`).then(({ data }) => {
                    //console.log('getdata liveBet',data)
                    this.placedBetsOfMatched=data.matched;
                    this.placedBetsOfUnMatched=data.ummatched;
                    this.fancyBets=data.fancyBets;
                    this.markets=data.markets;
                    this.fancy_runners=data.fancy_runners;
                    //console.log('getdata matched',this.placedBetsOfMatched)
                });
            },
            readScoreBook(runner_id){
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/getScoreBook',{runner_id:runner_id,user_id:this.$userId,user_type:'admins'}).then(({ data }) => {
                    //console.log('profit of'+this.runner_id,data);
                    this.scoreBook=data.data;
                    $('#scoreBookTab').trigger('click')
                    //Event.$emit('betSlipLoading','hide');
                    //showNotification("alert-success", data.message, "top", "right", "animated lightSpeedIn", "animated lightSpeedOut");
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            ChangeMarket(event){
                if (event.target.value=='0'){
                    console.log('selected--0',event.target.value)
                    this.read();
                } else{
                    console.log('selected001',event.target.value)
                    this.read1(event.target.value)
                }
            },
            ChangeMarketOfPosition(event){
                if (event.target.value==0)return;
                this.c_marketForPosition=event.target.value;
                /*window.axios.get(`/api/getUserPosition/${this.$userId}`).then(({ data }) => {
                    console.log('get user position',data)
                    this.userPosition=data.data.userPosition;
                    this.runners=data.data.runners;
                    this.c_marketForPosition=event.target.value;
                });*/
            },

            del(id) {
                // alert(id);
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/delPlacedBetSlip/${id}`).then((data) => {
                    if (data.data.state==0){
                        let index = this.placedBetsOfUnMatched.findIndex(item => item.id === id);
                        this.placedBetsOfUnMatched.splice(index, 1);
                        Event.$emit('updateBalance', 1);
                    }
                    else{
                        showNotification('alert-success',data.data.message,'top','right','animated fadeInRight','animated fadeOutRight');
                    }
                });

            },
        },
        components:{
            upLineAdmins
        },
        created() {
            // console.log('Create Element');
            this.read();
        },
        watch: {
        },
    }
</script>
