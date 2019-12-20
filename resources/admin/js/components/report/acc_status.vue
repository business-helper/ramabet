<style>
    .date_filter {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        padding: 10px!important;
    }

    .date_filter input {
        width: 200px;
        margin: 5px;
    }
    .date_filter button{
        margin: 5px;
        width: 100px;
    }

    form {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
</style>
<template>
    <div class="container-fluid" style="">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Account Status
                        </h2>

                    </div>

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover boldFontTAble">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Total Wallet</td>
                                    <td>
                                        <span v-if="this.user.wallet+this.user.pAndL+this.user.cash+this.user.comAmount>=0" style="color: green">
                                            {{(this.user.wallet+this.user.pAndL+this.user.cash+this.user.comAmount).toFixed(2)}}
                                        </span>
                                        <span v-else style="color:red;">
                                            {{(this.user.wallet+this.user.pAndL+this.user.cash+this.user.comAmount).toFixed(2)}}
                                        </span>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Wallet</td>
                                    <td>
                                        <span v-if="this.user.wallet>=0" style="color: green">
                                            {{(this.user.wallet).toFixed(2)}}
                                        </span>
                                        <span v-else style="color:red;">
                                            {{(this.user.wallet).toFixed(2)}}
                                        </span>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Loss Limit</td>
                                    <td>
                                        <span v-if="this.user.credit_limit*this.user.partnerShip/100>=0" style="color: green">
                                            {{(this.user.credit_limit*this.user.partnerShip/100).toFixed(2)}}
                                        </span>
                                        <span v-else style="color:red;">
                                            {{(this.user.credit_limit*this.user.partnerShip/100).toFixed(2)}}
                                        </span>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Profit and Loss</td>
                                    <td>
                                        <span v-if="this.user.pAndL+this.user.comAmount>=0" style="color: green">
                                            {{(this.user.pAndL+this.user.comAmount/*+this.user.cash*/).toFixed(2)}}
                                        </span>
                                        <span v-else style="color:red;">
                                            {{(this.user.pAndL+this.user.comAmount/*+this.user.cash*/).toFixed(2)}}
                                        </span>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Commission</td>
                                    <td>
                                        <span v-if="this.user.comAmount>=0" style="color: green">
                                            {{(this.user.comAmount).toFixed(2)}}
                                        </span>
                                        <span v-else style="color:red;">
                                            {{(this.user.comAmount).toFixed(2)}}
                                        </span>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Cash</td>
                                    <td>
                                        <span v-if="this.user.cash>=0" style="color: green">
                                            {{(this.user.cash).toFixed(2)}}
                                        </span>
                                        <span v-else style="color:red;">
                                            {{(this.user.cash).toFixed(2)}}
                                        </span>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Balance Up</td>
                                    <td>
                                        <span v-if="this.user.bUp+this.user.comUp>=0" style="color: green">
                                            {{(this.user.bUp+this.user.comUp).toFixed(2)}}
                                        </span>
                                        <span v-else style="color:red;">
                                            {{(this.user.bUp+this.user.comUp).toFixed(2)}}
                                        </span>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Balance Down</td>
                                    <td>
                                        <span v-if="this.user.bDown+this.user.comDown>=0" style="color: green">
                                            {{(this.user.bDown+this.user.comDown).toFixed(2)}}
                                        </span>
                                        <span v-else style="color:red;">
                                            {{(this.user.bDown+this.user.comDown).toFixed(2)}}
                                        </span>
                                    </td>
                                    <td></td>
                                </tr>

                                </tbody>
                            </table>
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
                user:[]
            }
        },
        props: [

        ],
        mounted() {
            $('body').removeClass('overlay-open');
            Event.$on('updateBalance', (data) => {
                this.read();
            });
            Event.$on('placedBets', (data) => {
                this.read();
            });
            Event.$on('getDeclare',(data) => {
                this.read();
            });
        },
        methods: {
            read() {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/updateBalanceOfAdmin', {user_id: this.$userId}).then(({data}) => {
                    this.user=data.data;
                }).catch(function (resp) {
                    console.log(resp);
                });
            },


        },
        created() {
            this.read();
        },
    }
</script>
