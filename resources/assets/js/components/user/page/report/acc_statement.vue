
<template>
    <div class="container-fluid" style="">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Account statement
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
                                <tr v-for="item in reports" :key="item.id" :value="item" >
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
            }
        },
        props: [

        ],
        mounted() {
            $('body').removeClass('overlay-open');
            Event.$on('getDeclare',(data) => {

                if (data==null)return;

                this.read();

            });

        },
        methods: {
            read() {

                if (this.dt!=="") this.dt.destroy();
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/getReport', {reportType:'total_wallet',end_date: this.end_date,start_date: this.start_date, user_id: this.$userId, user_type: 'users'}).then((res) => {
                    this.reports = res.data.data;
                    console.log('testes',this.reports);
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
            this.user_type = this.$route.params.type;
            this.user_id = this.$route.params.user_id;
            this.read();
        },
    }
</script>
