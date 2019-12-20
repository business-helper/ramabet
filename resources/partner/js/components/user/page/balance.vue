<template>
    <div class="container-fluid" style="">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Your Balances
                        </h2>
                        <ul class="header-dropdown m-r--5">

                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tbody>
                                <tr>
                                    <td>
                                        <h5 style="white-space: nowrap;">Your Balances</h5>
                                        <span style="font-size: 30px; line-height: 36px; font-weight: bold; color: #2789CE;">
                                            {{this.user.wallet}} <span style="    font-size: 12px; color: #7E97A7; font-weight: normal;">Rp</span></span>
                                    </td>
                                    <td style="white-space: unset;">
                                        <h5>Welcome,</h5>
                                        <span>View your account details here. You can manage funds, review and change your settings and see the performance of your betting activity.</span>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Transaction History
                        </h2>
                        <ul class="header-dropdown m-r--5">

                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Transaction №</th>
                                    <th>Date</th>
                                    <th>Balance</th>
                                    <th>From/To</th>
                                </tr>
                                </thead>
                                <tbody>

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
            'sport_id','state1'
        ],
        mounted() {
            this.$nextTick(function () {

            })
        },
        methods:{
            read() {
                //console.log('Auto get data');
                var send_data={};
                send_data.type= 'get';
                send_data.table_name= 'users';
                //send_data.data=[];
                /*send_data.data={
                    'id':$('#PrimaryModalhdbgcl #sports_id').val(),
                    'title':$('#PrimaryModalhdbgcl #sports_name').val(),
                };*/
                send_data.condition=[];
                send_data.condition.push(['id',userID]);
                window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                    console.log('Get Sport From Api-------------',data);
                    this.user=data.data[0];

                });
            },
            getPaymentHistory(){
                var send_data={};
                send_data.type= 'get';
                send_data.table_name= 'payment_history';
                //send_data.data=[];
                /*send_data.data={
                    'id':$('#PrimaryModalhdbgcl #sports_id').val(),
                    'title':$('#PrimaryModalhdbgcl #sports_name').val(),
                };*/
                send_data.condition=[];
                send_data.condition.push(['user_id',userID]);
                window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                    console.log('Get Sport From Api-------------',data);
                    this.user=data.data[0];

                });
            }


        },
        created() {
            this.read();
            this.getPaymentHistory();

            /*this.updateEvent1()*/
        },
        components: {

        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>