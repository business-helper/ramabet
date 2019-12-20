<style>
    .date_filter {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        padding: 0 20px;
    }

    .date_filter input {
        /*width: 200px;*/
        margin: 5px;
        flex: 2;
        min-width: 150px;
    }

    .date_filter button {
        margin: 5px;
        /*width: 100px;*/
        flex: 1;
    }

    .date_filter select {
        margin: 5px;
        /*width: 100px;*/
        flex: 2;
        min-width: 150px;
    }

    form {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
</style>
<template>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="card">
                    <div class="body">
                        <button style="padding: 0; width: 50px; float: right;"
                                class="btn btn-success waves-effect waves-circle waves-float" name="result_session"
                                @click="backPosition">Back
                        </button>
                        <table class="table table-bordered table-condensed" style="margin: 0;">
                            <thead>
                            <tr style="color: #585858">
                                <th style="">Account</th>
                                <th>P|L</th>
                            </tr>
                            </thead>
                            <tbody class="tbUMatchedB">
                            <tr v-for="item in userPosition">
                                <td>
                                    <a v-if="item.account.type=='admins'" @click="getUserPosition(item.account.id)">
                                        {{item['account']['name']}}
                                    </a>
                                    <span v-else>
                                        {{item['account']['name']}}
                                    </span>

                                </td>
                                <td>
                                    <span v-if="item.minus_account>=0" style="color: #0000ff">
                                            {{item.minus_account.toFixed(2)}}
                                        </span>
                                    <span v-else style="color: red">
                                            {{item.minus_account.toFixed(2)}}
                                        </span>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="card">
                    <div class="body">
                        <table v-if="this.is_market==1" class="table table-bordered dataTable betList_exportable" style="margin: 0;">
                            <thead>
                            <tr style="color: #585858">
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">id</th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Name</th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Runner</th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Odds</th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Stack </th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Side </th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">P|L </th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Date</th>
                            </tr>
                            </thead>
                            <tbody class="tbUMatchedB">
                            <tr v-for="item in betList" :class="item.bet_type">
                                <td>
                                    {{item.id}}
                                </td>
                                <td>
                                    {{item.userName}}
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
                                    {{item.profit=="loss"?-item.exposure:-item.profit_amount}}
                                </td>
                                <td>
                                    {{item.at_update}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-else class="table table-bordered dataTable betList_exportable" style="margin: 0;">
                            <thead>
                            <tr style="color: #585858">
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">id</th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Name</th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Fancy</th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Score</th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Stack </th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Rate </th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Side </th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">P|L </th>
                                <th style="" class="sorting_disabled"
                                    rowspan="1" colspan="1">Date</th>
                            </tr>
                            </thead>
                            <tbody class="tbUMatchedB">
                            <tr v-for="item in betList" :class="item.bet_type">
                                <td>
                                    {{item.id}}
                                </td>
                                <td>
                                    {{item.userName}}
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
                                    {{item.odd*100-100}}
                                </td>
                                <td>
                                    {{item.bet_type=="availableToBack"?'Yes':'No'}}
                                </td>
                                <td>
                                    {{item.profit=="loss"?-item.exposure:-item.profit_amount}}
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
</template>

<script>
    export default {

        data() {
            return {
                settlementList: [],
                start_date: "",
                end_date: "",
                search: "",
                mdt_betList: "",
                markets: [],
                runners: [],
                userPosition: [],
                c_marketForPosition: [],
                posHis: [],
                c_userId: 0,
                c_profit: 0,
                n_profit: this.c_profit,
                cUserType: 'admins',
                c_admin:[],
                betList:[],
                market_id:0,
                runner_id:0,
                is_market:1
            }
        },
        props: [],
        mounted() {
            //getProfit
            $('body').removeClass('overlay-open');
            Event.$on('getProfit', (market_id) => {
                this.market_id=market_id;
                this.read();
            });
            Event.$on('getSessionProfit', (runner_id) => {
                this.is_market=0;
                this.runner_id=runner_id;
                this.readSession(runner_id);
            });
            this.$nextTick(function () {

            })
        },
        methods: {
            readSession(runner_id){
                window.axios.post('/api/getProfitUPAR', {admin_id: this.$userId,runner_id:runner_id}).then(({data}) => {
                    console.log('get user position', data)
                    this.userPosition = data.data.userPosition;
                    this.c_admin = data.data.c_admin;
                });
                window.axios.post('/api/getProfitBetSlipsAdmin', {admin_id: this.$userId,runner_id:runner_id}).then((res) => {
                    this.betList = res.data;
                    if (this.mdt_betList!="") this.mdt_betList.destroy();
                    this.$nextTick(() => {
                        this.mdt_betList = $('.betList_exportable').DataTable({
                            dom: 'lBfrtip',
                            responsive: true,
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ],
                            lengthMenu: [[5, 10, 25, 50,-1],[5, 10, 25, 50,'all']],
                            order: [[ 0, "desc" ]]
                        });
                    });
                });
            },
            read() {
                window.axios.post('/api/getProfitUPAR', {admin_id: this.$userId,market_id:this.market_id}).then(({data}) => {
                    console.log('get user position', data)
                    this.userPosition = data.data.userPosition;
                    this.c_admin = data.data.c_admin;
                });
                window.axios.post('/api/getProfitBetSlipsAdmin', {admin_id: this.$userId,market_id:this.market_id}).then((res) => {
                    this.betList = res.data;
                    if (this.mdt_betList!="") this.mdt_betList.destroy();
                    this.$nextTick(() => {
                        this.mdt_betList = $('.betList_exportable').DataTable({
                            dom: 'lBfrtip',
                            responsive: true,
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ],
                            lengthMenu: [[5, 10, 25, 50,-1],[5, 10, 25, 50,'all']],
                            order: [[ 0, "desc" ]]
                        });
                    });
                });
            },

            getUserPosition(user_id) {
                if (this.market_id>0){
                    window.axios.post('/api/getProfitUPAR', {admin_id: user_id,market_id:this.market_id}).then(({data}) => {
                        console.log('get user position', data)
                        this.userPosition = data.data.userPosition;
                        this.c_admin = data.data.c_admin;
                    });
                }
                if (this.runner_id>0){
                    window.axios.post('/api/getProfitUPAR', {admin_id: user_id,runner_id:this.runner_id}).then(({data}) => {
                        console.log('get user position', data)
                        this.userPosition = data.data.userPosition;
                        this.c_admin = data.data.c_admin;
                    });
                }

            },
            backPosition() {
                this.posHis.pop();
                var user_id = 0;
                if (this.posHis.length == 0) {
                    user_id = this.$userId;
                } else {
                    user_id = this.posHis[this.posHis.length - 1];
                }
                if (this.market_id>0){
                    window.axios.post('/api/getProfitUPAR', {admin_id: user_id,market_id:this.market_id}).then(({data}) => {
                        console.log('get user position', data)
                        this.userPosition = data.data.userPosition;
                        this.c_admin = data.data.c_admin;
                    });
                }
                if (this.runner_id>0){
                    window.axios.post('/api/getProfitUPAR', {admin_id: user_id,runner_id:this.runner_id}).then(({data}) => {
                        console.log('get user position', data)
                        this.userPosition = data.data.userPosition;
                        this.c_admin = data.data.c_admin;
                    });
                }
            },

        },
        created() {
            //this.read();

            /*this.updateEvent1()*/
        },
        components: {},
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>