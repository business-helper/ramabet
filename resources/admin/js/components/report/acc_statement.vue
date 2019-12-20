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
                           Account Statement
                            <span v-if="this.userName!=''">of {{this.userName}}</span>
                        </h2>

                    </div>
                    <div class="date_filter header">
                        <input type="date" v-model="start_date" name="start_date" class="form-control" placeholder="Date start...">
                        <input type="date" v-model="end_date" name="end_date" class="form-control" placeholder="Date end...">
                        <!--<input type="text" v-model="keyword" name="search" class="form-control" placeholder="Search">-->
                        <button type="button" class="btn bg-amber waves-effect" @click="read">Filter</button>
                        <button type="button" class="btn bg-light-green waves-effect" @click="clear">Clear</button>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable exportable">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Total</th>
                                    <th>Narration</th>
                                    <th>Remark</th>
                                    <th>Date&Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in reports" >
                                    <td>{{item.id}}</td>
                                    <td :class="item.amount>=0?'profit_color':'loss_color'">{{item.credit}}</td>
                                    <td :class="item.amount>=0?'profit_color':'loss_color'">{{item.debit}}</td>
                                    <td>{{item.total}}</td>
                                    <td>{{item.narration}}</td>
                                    <td>{{item.remark}}</td>
                                    <td>{{item.date}}</td>
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
                keyword: "",
                start_date: "",
                end_date: "",
                reports: [],
                user_id: "",
                user_type: "",
                dt: "",
                userName:""
            }
        },
        props: [

        ],
        mounted() {
            $('body').removeClass('overlay-open');
            this.$nextTick(function () {

            })
            Event.$on('getDeclare',(data) => {
                this.read();
            });
        },
        methods: {
            read() {

                console.log(this.$route);//this.$route.params
                var userId=this.$userId;
                var userType='admins';
                if(this.$route.query.userId!=undefined){
                    userId=this.$route.query.userId
                    this.userName=this.$route.query.userName
                    if (this.$route.query.userType==4){
                        userType='users';
                    }
                }
                this.reports=[];

                if (this.dt!=="") this.dt.destroy();
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/getReport', {reportType:'total_wallet',end_date: this.end_date, user_id: userId, user_type: userType}).then((res) => {
                    this.reports = res.data.data;
                    this.$nextTick(() => {
                        if ( $.fn.DataTable.isDataTable('.exportable') ) {
                            this.dt.destroy();
                        }
                        this.dt = $('.exportable').DataTable({
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
            fixed(value){
                return value.toFixed(2);
            },
            clear(){
                this.start_date = "";
                this.end_date = "";
                this.keyword = "";
            }

        },
        created() {
            //this.user_type = this.$route.params.type;
            //this.user_id = this.$route.params.user_id;
            this.read();
        },
    }
</script>
