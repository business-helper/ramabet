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
                            <!--<div @click="UpdateItem" style="cursor: pointer" class="right"><i class="material-icons">save</i>-->
                            <!--</div>-->
                            Account Statement
                        </h2>
                        <ul class="header-dropdown m-r--5">

                        </ul>
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
                                    <th>Date</th>
                                    <!--<th>Description</th>                                    -->
                                    <th>Before Amount</th>
                                    <th>After Amount</th>
                                    <th>Amount</th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr v-for="st in statements" v-bind="st">
                                    <td>{{st.id}}</td>
                                    <td>{{st.datetime}}</td>
                                    <!--<td>{{st.remark}}</td>-->
                                    <td>{{fixed(st.before_amount)}}</td>
                                    <td>{{fixed(st.after_amount)}}</td>
                                    <td>{{fixed(st.change_amount)}}</td>
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
                statements: [],
                user_id: "",
                user_type: "",
                dt: "",
            }
        },
        props: [

        ],
        mounted() {
            this.$nextTick(function () {

            })
        },
        methods: {
            read() {
                window.axios.post('/api/getStatement', {start_date: this.start_date, end_date: this.end_date, keyword: this.keyword, user_id: this.user_id, user_type: this.user_type}).then((res) => {
                    console.log('Get Account info profile and loss -------------', res);
                    // if(res.state == 1){
                    this.statements = res.data.result;
                    this.$nextTick(() => {
                        if ( $.fn.DataTable.isDataTable('.exportable') ) {
                            this.dt.destroy();
                        }
                        this.dt = $('.exportable').DataTable({
                            dom: 'Bfrtip',
                            responsive: true,
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ],
                            lengthMenu: [ 10, 25, 50],
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