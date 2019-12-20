<style>
    .switch label .lever {
        width: 50px;
        height: 24px!important;
    }
    .switch label input[type=checkbox]:checked + .lever:after {
        left: 26px!important;
    }
    .switch label .lever:after {
        left: 2px!important;
        top: 1px!important;
    }
    .sportname{
        vertical-align: middle;
        font-size: 16px;
    }
    .switch label input[type=checkbox]:checked+.lever.switch-col-blue {
        background-color: #5bb85c!important;
    }
    .switch label .lever {
        background-color: #d9534f!important;
    }
    .switch label input[type=checkbox]:checked+.lever.switch-col-blue:after {
        background-color: white!important;
    }
</style>
<template>
    <div class="container-fluid" style="">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                       <h2> Sport Listing </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable sportlist">
                                <thead>
                                <tr>
                                    <th >So.</th>
                                    <th >Name</th>
                                    <th >Action</th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr v-for="(sport, index) in sports" v-bind="sport">
                                    <td>{{(index + 1)}}</td>
                                    <td class="sportname"><img :class="sport.icon" /> <router-link :to="'/match_list/'+sport.id">{{sport.name}}</router-link></td>
                                    <td>
                                        <div class="switch">
                                            <label>
                                                <input v-if="sport.is_active == 'true'" type="checkbox" checked @click="blockMarket(sport, index, 'false')">
                                                <input v-else type="checkbox" @click="blockMarket(sport, index, 'true')">
                                                <span class="lever switch-col-blue"></span>
                                            </label>
                                        </div>
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

</template>
<script>

    export default {

        data() {
            return {
                sports:[],
                markets: []
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
                window.axios.post('/api/getSports').then((res) => {
                    console.log('Get sport -------------', res);
                    // if(res.state == 1){
                    this.sports = res.data.data;
                    this.$nextTick(() => {
                        $('.sportlist').DataTable({
                            dom: 'Bfrtip',
                            responsive: true,
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ],
                            lengthMenu: [ 10, 25, 50],
                        });
                    });
                    // }
                });

                // window.axios.post('/api/market_list').then((res) => {
                //     console.log('Get market_list -------------', res);
                //     // if(res.state == 1){
                //     this.markets = res.data.data;
                //     // }
                // });


            },
            blockMarket(sport, index, value){
                window.axios.post('/api/activeSport', {id: sport.id, is_active: value}).then((res) => {
                    console.log('Get sport -------------', res);
                    this.sports[index].is_active = value;
                    showNotification('alert-success', "Success", 'bottom', 'right', 'animated fadeInRight', 'animated fadeOutRight');
                });

            },
            fixed(value){
                return value.toFixed(2);
            },
            clear(){
                this.start_date = "";
                this.end_date = "";
                this.search = "";
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
            // $('.js-exportable').DataTable({
            //     dom: 'Bfrtip',
            //     responsive: true,
            //     buttons: [
            //         'copy', 'csv', 'excel', 'pdf', 'print'
            //     ]
            // });
            /*this.updateEvent1()*/


        },
    }
</script>