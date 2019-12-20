<style>
    .block_event{
        border-radius: 50%!important;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
    }
    .block_event i{
        font-size: 14px!important;
        top: 0px!important;
    }
</style>
<template>
    <div class="container-fluid" style="">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Match Listing</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable eventlist">
                                <thead>
                                <tr>
                                    <th >So.</th>
                                    <th >Name</th>
                                    <th >Date</th>
                                    <th >Action</th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr v-for="(event, index) in events" v-bind="event">
                                    <td>{{(index + 1)}}</td>
                                    <td>{{event.name}}</td>
                                    <td>{{event.time}}</td>
                                    <td>
                                        <button class="block_event btn bg-primary btn-block btn-sm waves-effect" v-if="event.is_active == 'true'" @click="blockEvent(event, index, 'false')"><i class="fa fa-pause"></i> </button>
                                        <button class="block_event btn bg-green btn-block btn-sm waves-effect" v-else @click="blockEvent(event, index, 'true')"><i class="fa fa-play-circle"></i> </button>

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
                events:[],
            }
        },
        methods: {
            read() {

                window.axios.post('/api/getEventsForBlock',{sport_id: this.$route.params.sport_id}).then((res) => {
                    console.log('Get sport -------------', res);
                    // if(res.state == 1){
                    this.events = res.data.data;
                    this.$nextTick(() => {
                        $('.eventlist').DataTable({
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


            },
            blockEvent(event, index, value){
                window.axios.post('/api/activeEventsForBlock', {id: event.id, is_active: value}).then((res) => {
                    console.log('Get sport -------------', res);
                    this.events[index].is_active = value;
                    showNotification('alert-success', "Success", 'bottom', 'right', 'animated fadeInRight', 'animated fadeOutRight');
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