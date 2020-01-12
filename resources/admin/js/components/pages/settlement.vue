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
    <div class="container-fluid" style="padding-bottom: 100px;padding-top: 50px">
        <modal name="settlement_modal" @before-open="beforeOpen" style="" draggable="true" width="400px" height="190px"
               class="back_betting_slip add_master_dlg">
            <div class="modal-dialog" style=" margin: 0; height: 100%; width: 100%;">
                <div class="modal-content">
                    <div class="modal-header header-color-modal bg-color-1">
                        <h4 class="modal-title text-center">Settlement</h4>
                        <span id="type" style="display: none"></span>
                        <div class="modal-close-area modal-close-df">
                            <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close"
                                    data-dismiss="modal" v-on:click="$modal.hide('settlement_modal')">&times;
                            </button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="rows">
                            <div class="form-group-inner">
                                <label>Remaining amount:({{c_profit}})</label>
                                <input type="number" v-model="n_profit" class="form-control" placeholder=""/>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn bg-amber waves-effect" id="add_master" v-on:click="setSettlement(c_userId)">
                            Submit
                        </button>
                        <button class="btn bg-green waves-effect" data-dismiss="modal"
                                v-on:click="$modal.hide('settlement_modal')">Cancel
                        </button>
                    </div>
                </div>
            </div>

        </modal>
        <div style="display: flex;font-size: 19px">
            <div style="flex: 1;text-align: center">
                <span v-if="c_admin.pAndL>=0" style="color: green">Profit:{{c_admin.pAndL.toFixed(2)}}</span>
                <span v-else style="color: red">Profit:{{c_admin.pAndL.toFixed(2)}}</span>
            </div>
            <div style="flex: 1;text-align: center">
                <span  v-if="c_admin.pAndL+c_admin.comAmount>=0" style="color: green">Total Profit:{{(c_admin.pAndL+c_admin.comAmount).toFixed(2)}}</span>
                <span  v-else style="color: red">Total Profit:{{(c_admin.pAndL+c_admin.comAmount).toFixed(2)}}</span>
            </div>
            <div style="flex: 1;text-align: center">
                <span  v-if="c_admin.comAmount>=0" style="color: green">Commission:{{c_admin.comAmount.toFixed(2)}}</span>
                <span  v-else style="color: red">Commission:{{c_admin.comAmount.toFixed(2)}}</span>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Plus Account
                        </h2>
                    </div>
                    <div class="body">
                        <button style="padding: 0; width: 50px; float: right;"
                                class="btn btn-success waves-effect waves-circle waves-float" name="result_session"
                                @click="backPosition">Back
                        </button>
                        <table class="table table-bordered table-condensed" style="margin: 0;">
                            <thead>
                            <tr style="color: #585858">
                                <th style="">Account</th>
                                <th>Chips<!--{{runners[c_marketForPosition]['runnerName']}}--></th>
                               <!-- <th>P|L&lt;!&ndash;{{runners[c_marketForPosition]['runnerName']}}&ndash;&gt;</th>
                                <th>bUp</th>
                                <th>bDown</th>-->
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="boldFontTAble">
                            <tr v-for="item in userPosition" v-if="item.minus_account>=0">
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
                                <td>
                                    <button v-if="item['account']['name']!='Total' && item['account']['name'].indexOf('Own')<0 && item['account']['name'].indexOf('Parent')<0 && item['account']['name'].indexOf('Cash')<0" class="btn btn-success waves-effect"
                                            name="result_session"
                                            @click="showSettlementModal(item.account.id,item.account.type)">Settlement
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Minus Accounts
                        </h2>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-condensed" style="margin: 0;">
                            <thead>
                            <tr style="color: #585858">
                                <th style="">Account</th>
                                <th>Chips<!--{{runners[c_marketForPosition]['runnerName']}}--></th>
                                <th>Action<!--{{runners[c_marketForPosition]['runnerName']}}--></th>
                            </tr>
                            </thead>
                            <tbody class="boldFontTAble">
                            <tr v-for="item in userPosition" v-if="item.minus_account<0">
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
                                <td>
                                    <button v-if="item['account']['name']!='Total' && item['account']['name'].indexOf('Own')<0 && item['account']['name'].indexOf('Parent')<0 && item['account']['name'].indexOf('Cash')<0" class="btn btn-success waves-effect"
                                            name="result_session"
                                            @click="showSettlementModal(item.account.id,item.account.type)">Settlement
                                    </button>
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
                mdt: "",
                markets: [],
                runners: [],
                userPosition: [],
                c_marketForPosition: [],
                posHis: [],
                c_userId: 0,
                c_profit: 0,
                n_profit: this.c_profit,
                cUserType: 'admins',
                c_admin:[]

            }
        },
        props: [],
        mounted() {
            this.$nextTick(function () {

            })
        },
        methods: {
            showSettlementModal(val, userType) {
                this.c_userId = val;
                this.cUserType = userType;
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getSettlementOfAdmin/${val}/${userType}`).then(({data}) => {
                    console.log('get user position', data);
                    this.c_profit = -(data.data.bUp+data.data.comUp).toFixed(2);
                    this.n_profit = this.c_profit;
                    this.$modal.show('settlement_modal', {s_param: val}, {
                        draggable: true
                    })
                });

            },
            beforeOpen(event) {
                this.c_userId = event.params.s_param;
                console.log(event.params.s_param);
            },
            clear() {
                this.start_date = "";
                this.end_date = "";
                this.search = "";
            },
            read() {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getUPAR/${this.$userId}`).then(({data}) => {
                    console.log('get user position', data)
                    this.userPosition = data.data.userPosition;
                    this.c_admin = data.data.c_admin;
                });
                /*window.axios.post('/api/getSettlement', {user_id: this.$userId,userType:'admins',start_date:this.start_date,end_date:this.end_date}).then((res) => {
                    this.settlementList = res.data.data;
                    if (this.mdt!=="") this.mdt.destroy();
                    this.$nextTick(() => {
                        this.mdt = $('.masterexportable').DataTable({
                            dom: 'Bfrtip',
                            responsive: true,
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ],
                            lengthMenu: [ 10, 25, 50],
                        });
                    });
                });*/
            },
            setSettlement(id) {
                this.$modal.hide('settlement_modal')
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/setSettlement', {
                    child_id: id,
                    userType: this.cUserType,
                    amount: this.n_profit
                }).then((res) => {
                    //this.read();
                    showNotification('alert-success', res.data.message, 'bottom', 'right', 'animated fadeInRight', 'animated fadeOutRight');
                    if (res.data.state==0){
                        Event.$emit('updateBalance', '');
                        this.n_profit = 0;
                        var user_id = 0;
                        if (this.posHis.length == 0) {
                            user_id = this.$userId;
                        } else {
                            user_id = this.posHis[this.posHis.length - 1];
                        }
                        window.axios.get(`/api/getUPAR/${user_id}`).then(({data}) => {
                            this.userPosition = data.data.userPosition;
                            this.c_admin = data.data.c_admin;
                        });
                    }

                });
            },
            getUserPosition(user_id) {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getUPAR/${user_id}`).then(({data}) => {
                    this.userPosition = data.data.userPosition;
                    this.c_admin = data.data.c_admin;
                    this.posHis.push(user_id);
                });
            },
            backPosition() {
                this.posHis.pop();
                var user_id = 0;
                if (this.posHis.length == 0) {
                    user_id = this.$userId;
                } else {
                    user_id = this.posHis[this.posHis.length - 1];
                }
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getUPAR/${user_id}`).then(({data}) => {
                    this.userPosition = data.data.userPosition;
                    this.c_admin = data.data.c_admin;

                });
            },
            ChangeMarketOfPosition(event) {
                if (event.target.value == 0) return;
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.get(`/api/getUPAR/${this.$userId}`).then(({data}) => {
                    this.userPosition = data.data.userPosition;
                    this.c_admin = data.data.c_admin;
                    this.c_marketForPosition = event.target.value;
                });
            },
        },
        created() {
            this.read();

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
