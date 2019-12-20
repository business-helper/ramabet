<style>
    .date_filter {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        padding: 0 20px;
    }

    .date_filter input {
        width: 200px;
        margin: 5px;
    }
    .date_filter button{
        margin: 5px;
        width: 100px;
    }
    .date_filter select{
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
                            <div @click="UpdateItem" style="cursor: pointer" class="right"><i class="material-icons">save</i>
                            </div>
                            Chip History
                        </h2>
                        <ul class="header-dropdown m-r--5">

                        </ul>
                    </div>

                    <div class="date_filter">
                        <input type="date" name="start_date" class="form-control" placeholder="Date start..." style="flex: 1;">
                        <input type="date" name="end_date" class="form-control" placeholder="Date end..." style="flex: 1;">
                        <select class="form-control" name="" style="flex: 1;">
                            <option value="matchentry">Match Entry</option>
                            <option value="commission">Commission</option>
                            <option value="entry">Entry</option>
                            <option value="freechip">Free Chip</option>
                            <option value="profitloss">Profile & Loss</option>
                        </select>
                    </div>
                    <div class="date_filter">
                        <button type="button" class="btn bg-amber waves-effect">Filter</button>
                        <button type="button" class="btn bg-light-green waves-effect">Clear</button>
                        <!--<button type="button" class="btn bg-light-green waves-effect">Export</button>-->
                        <button type="button" class="btn bg-light-green waves-effect">View Ledger</button>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr >
                                    <th class="">S.No. </th>
                                    <th class="">Narration </th>
                                    <th class="">Date </th>
                                    <th class="">Credit </th>
                                    <th class="">Debit </th>
                                    <th class="">Balance </th>
                                    <th class="">Id </th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
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
                user: []
            }
        },
        props: [
            'sport_id', 'state1'
        ],
        mounted() {
            this.$nextTick(function () {

            })
        },
        methods: {
            read() {
                //console.log('Auto get data');
                var send_data = {};
                send_data.type = 'get';
                send_data.table_name = 'users';
                //send_data.data=[];
                /*send_data.data={
                    'id':$('#PrimaryModalhdbgcl #sports_id').val(),
                    'title':$('#PrimaryModalhdbgcl #sports_name').val(),
                };*/
                send_data.condition = [];
                send_data.condition.push(['id', userID]);
                window.axios.post('/api/table_edit', {parameter: JSON.stringify(send_data)}).then(({data}) => {
                    console.log('User Information-------------', data);
                    this.user = data.data[0];

                });
            },
            updateName(event) {
                this.user.name = event.target.innerText;
                console.log('update-----', event.target.innerText);
            },
            UpdateItem() {
                var send_data = {};
                send_data.type = 'update';
                send_data.table_name = 'users';
                send_data.data = [];
                send_data.data = this.user;
                send_data.condition = [];
                send_data.condition.push(['id', this.user.id]);
                window.axios.post('/api/table_edit', {parameter: JSON.stringify(send_data)}).then(({data}) => {
                    console.log(data.message);
                    showNotification('alert-success', data.message, 'bottom', 'right', 'animated fadeInRight', 'animated fadeOutRight');
                });
            },

        },
        created() {


            this.read();
            //Exportable table
            $('.js-exportable').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
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