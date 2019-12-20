

<template>
    <div class="sticky-tabs">
        <!-- tabs -->
        <ul class="nav nav-tabs match-tabs">
            <!--<li v-if="is_mobile!=1"><a id="betSlipTab" data-toggle="tab" href="#betSlip">BetSlip</a></li>-->
            <li class="active"><a id="openBetTab" data-toggle="tab" href="#scorePos" aria-expanded="true">Open
                Bets</a></li>

            <!--<li class=""><a id="scoreBookTab" data-toggle="tab" href="#scoreBook" aria-expanded="false">Score Books</a></li>-->
            <li id="tvStreamTab"><a data-toggle="tab" href="#tvStream">TV Streaming</a></li>

            <li><a data-toggle="tab" href="#liveStatus">Live Status</a></li>
        </ul>
        <!-- tab contents -->
        <div class="tab-content match-tabs-content">
            <!--<div v-if="is_mobile!=1" id="betSlip" class="tab-pane fade">
                <betslip :market_id="-2"></betslip>
            </div>-->
            <div id="tvStream" class="tab-pane fade">
                <div class="box box-primary Dcursor" tabindex="1">
                    <!--<div class="box-header bgblack" style="color: white;">-->
                        <!--Live TV Streaming-->
                        <!--<div style="height: auto; width: 40px; float: right; padding-top: 0px;">-->
                            <!--&lt;!&ndash; <button class="btn btn-box-tool" style="padding: 0px; padding-right: 2px; color: black;"-->
                                     <!--data-widget="collapse"><i class="fa fa-plus"></i></button>&ndash;&gt;-->
                        <!--</div>-->
                    <!--</div>-->
                    <div class="box-body" style="text-align: center;">
                        <!--allowfullscreen-->
                        <iframe frameborder="0" width="358" height="250"
                                scrolling="no" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"
                                src="https://365livestreaming.in/channel_list.php"></iframe>

                    </div>
                </div>
            </div>
            <div id="liveStatus" class="tab-pane fade">
                <div class="box box-primary Dcursor" tabindex="1">
                    <!--<div class="box-header bgblack" style="color: white;">-->
                        <!--Live Match Status-->
                        <!--<div style="height: auto; width: 40px; float: right; padding-top: 0px;">-->
                            <!--&lt;!&ndash;<button class="btn btn-box-tool" style="padding: 0px; padding-right: 2px; color: white;"-->
                                     <!--data-widget="collapse"><i class="fa fa-plus"></i></button>&ndash;&gt;-->
                        <!--</div>-->
                    <!--</div>-->
                    <div class="box-body" style="text-align: center">
                        <iframe id="BFVideoFrame" class="player" frameborder="0" width="358" height="250"
                                scrolling="no" :key="this.event_id"
                                :src="'https://videoplayer.betfair.com/GetPlayer.do?eID='+this.event_id+'&width=358&height=250&contentType=viz&contentOnly=false'"></iframe>
                    </div>

                </div>

            </div>
            <!-- Fancy Tab Content -->


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
                                <div class="panel-body" style="padding: 0;position: relative">
                                    <div :class="deleting" style="position: absolute;width: 100%;height: 100%;background-color: #777a;z-index: 1;display: flex;">

                                    </div>

                                    <table id="tbUnMatched" class="table table-bordered table-condensed" style="margin: 0;">
                                        <thead>
                                        <tr style="color: #585858">
                                            <th style="">del</th>
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">id</th>
                                            <th style="">Runner</th>
                                            <th style="">Odds</th>
                                            <th style="">Stake</th>
                                            <th style="">Profit</th>
                                            <th style="">Loss</th>
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
                                                {{item.runnerName}}
                                            </td>
                                            <td>
                                                {{item.odd}}
                                            </td>
                                            <td>
                                                {{item.stake}}
                                            </td>
                                            <td>
                                                {{item.profit_amount}}
                                            </td>
                                            <td>
                                                {{item.exposure}}
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
                    <p  style="font-size: 12px;font-weight: 600;text-align: center" v-else>There are No UnMatched bets yet</p>
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
                                <div class="panel-body" >
                                    <table id="tbMatched"
                                           class="table table-bordered table-condensed dataTable no-footer"
                                           style="margin: 0;" role="grid">
                                        <thead id="1.162601258mExist">
                                        <tr style="color: #585858" role="row">
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">id</th>
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">Runner</th>
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">Odds</th>
                                            <th style="" class="sorting_disabled"
                                                rowspan="1" colspan="1">Stake </th>
                                            <th style="">Profit</th>
                                            <th style="">Loss</th>
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
                                                {{item.runnerName}}
                                            </td>
                                            <td>
                                                {{item.odd}}
                                            </td>
                                            <td>
                                                {{item.stake}}
                                            </td>
                                            <td>
                                                {{item.profit_amount}}
                                            </td>
                                            <td>
                                                {{item.exposure}}
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
                                    <div class="panel-body" style="padding: 0">
                                        <table class="table table-bordered table-condensed" style="margin: 0;">
                                            <thead>
                                            <tr style="color: #585858">
                                                <th style="" class="sorting_disabled"
                                                    rowspan="1" colspan="1">id</th>
                                                <th style="">Fancy</th>
                                                <th style="">Score</th>
                                                <th style="">Amount</th>
                                                <th style="">Rate</th>
                                                <th style="">Date</th>
                                            </tr>
                                            </thead>
                                            <tbody class="tbUMatchedB">
                                            <tr v-for="item in this.fancyBets" :class="item.bet_type" v-if="item.runner_id==c_fancy || c_fancy==0">

                                                <td>
                                                    {{item.id}}
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
    export default {
        data() {
            return {
                placedBetsOfMatched: [],placedBetsOfUnMatched:[],markets:[],scoreBook:[],fancyBets:[],total_count:0,is_load:'show',nodata:'show',c_market:0,event_id:this.event_import_id,deleting:'hide',runnerName:'',fancy_runners:[],c_fancy:0
            }
        },
        props: [
            'time_status','is_mobile','event_import_id'
        ],

        mounted() {
            Event.$on('placedBetLoading',(data) => {
                this.is_load=data;
            });
            Event.$on('scoreBook',(runner_id,runnerName) => {
                this.runnerName=runnerName;
                this.readScoreBook(runner_id);
            });
            Event.$on('setEvent',(data) => {
                this.event_id=data;
            });
            Event.$on('createBetSlip',(data) => {
                $('#betSlipTab').trigger('click')
            });
            Event.$on('placedBets',(res) => {
                /*if (this.c_market=='0'){
                    this.read();
                } else{
                    this.read1(this.c_market)
                }

                */
                console.log('placedBets-----',res);
                var data=res.openBets;
                if (data.matched==undefined || data.matched.length==0){
                    //this.placedBetsOfMatched=[];
                }else{
                    this.placedBetsOfMatched=data.matched;
                }
                if (data.ummatched==undefined || data.ummatched.length==0){
                    //this.placedBetsOfUnMatched=[];
                }else{
                    this.placedBetsOfUnMatched=data.ummatched;
                }
                this.markets=data.markets;
                this.total_count=data.total_count;
                this.c_market=0;
                if (this.fancyBets!=undefined){
                    this.fancyBets=data.fancyBets;
                    this.fancy_runners=data.fancy_runners;
                }

                //openBet
                $('#openBetTab').trigger('click')
            });
            Event.$on('matchedBet',(market_id,data) => {
                console.log(data.ummatched);
                if (data.matched==undefined){
                    this.placedBetsOfMatched=[];
                }else{
                    this.placedBetsOfMatched=data.matched;
                }
                if (data.ummatched==undefined){
                    this.placedBetsOfUnMatched=[];
                }else{
                    this.placedBetsOfUnMatched=data.ummatched;
                }
                /*if (data.fancyBets==undefined){
                    this.fancyBets=[];
                }else{
                    this.fancyBets=data.fancyBets;
                    this.fancy_runners=data.fancy_runners;
                }*/
                this.markets=data.markets;
                this.total_count=data.total_count;
                this.c_market=0;


                /*if (this.c_market=='0'){
                    this.read();
                } else{
                    this.read1(this.c_market)
                }*/
            });
            /*Event.$on('userLogged',(userId) => {
                this.$userId=userId;
                this.read();
            });*/
            Event.$on('removeEvent',(data) => {
                this.read();
            });
        },
        methods:{
            read() {
                this.is_load='show';
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getPlacedBetSlips/${this.$userId}`).then(({ data }) => {
                    console.log('getdata liveBet',data)
                    this.placedBetsOfMatched=data.matched;
                    this.placedBetsOfUnMatched=data.ummatched;
                    this.fancyBets=data.fancyBets;
                    this.markets=data.markets;
                    this.fancy_runners=data.fancy_runners;
                    this.total_count=data.total_count;
                });
            },
            read1(market_id) {
                this.is_load='show';
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getPlacedBetSlips/${this.$userId}/${market_id}`).then(({ data }) => {
                    //console.log('getdata liveBet',data)
                    this.placedBetsOfMatched=data.matched;
                    this.placedBetsOfUnMatched=data.ummatched;
                    this.fancyBets=data.fancyBets;
                    this.fancy_runners=data.fancy_runners;
                    this.markets=data.markets;
                    //console.log('getdata matched',this.placedBetsOfMatched)
                });
            },
            readScoreBook(runner_id){
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/getScoreBook',{runner_id:runner_id,user_id:this.$userId,user_type:'users'}).then(({ data }) => {
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
                this.c_market=event.target.value;
                if (this.c_market=='0'){
                    console.log('selected--0',event.target.value)
                    this.read();
                } else{
                    console.log('selected001',event.target.value)
                    this.read1(event.target.value)
                }
            },
            del(id) {
                this.deleting='';
                // alert(id);
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/delPlacedBetSlip/${id}`).then((data) => {
                    console.log('del-unmathced',data.data);
                    this.deleting='hide';
                    if (data.data.state==0){
                        let index = this.placedBetsOfUnMatched.findIndex(item => item.id === id);
                        this.placedBetsOfUnMatched.splice(index, 1);
                        Event.$emit('updateBalance', 1);
                        Event.$emit('deletedBetSlip', data.data.data.note);
                        var starCountRef = this.$firebase.database().ref('/');
                        var delPlacedBet=data.data.data.delItem;
                        starCountRef.update({
                            delPlacedBet
                        }).then((data)=>{
                            //success callback
                            console.log('data ' , data)
                        }).catch((error)=>{
                            //error callback
                            console.log('error ' , error)
                        })
                    }
                    else if (data.data.state==2){
                        let index = this.placedBetsOfUnMatched.findIndex(item => item.id === id);
                        this.placedBetsOfUnMatched.splice(index, 1);
                        Event.$emit('updateBalance', 1);
                    }
                        showNotification('alert-success',data.data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                });

            },
        },
        created() {
            // console.log('Create Element');
            this.read();
        },
        watch: {
        },
    }
</script>
