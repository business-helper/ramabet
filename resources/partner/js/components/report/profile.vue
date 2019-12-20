<template>
    <div class="container-fluid" style="">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <div @click="UpdateItem" style="cursor: pointer" class="right"><i class="material-icons">save</i></div>
                            Account Info
                        </h2>
                        <ul class="header-dropdown m-r--5">

                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Chips</th>
                                        <th>Free Chips</th>
                                        <th>Liability</th>
                                        <th>Wallet</th>
                                        <th>Up</th>
                                        <th>Down</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr >
                                        <td>{{info.chips}}</td>
                                        <td>{{info.free_chips}}</td>
                                        <td>{{info.liability}}</td>
                                        <td>{{info.wallet}}</td>
                                        <td>{{info.up}}</td>
                                        <td>{{info.down}}</td>
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
                user:[],
                info:[],
            }
        },
        props: [
            'sport_id','state1'
        ],
        mounted() {
            $('body').removeClass('overlay-open');
            this.$nextTick(function () {

            })
            Event.$on('getDeclare',(data) => {
                this.read();
            });
        },
        methods:{
            read() {
                window.axios.post('/api/accountInfo', {user_id: this.$userId}).then((res) => {
                    console.log('Get Account info profile and loss -------------', res);
                    // if(res.state == 1){
                    this.info = res.data.data;
                    if(typeof this.info.wallet != "undefined" && this.info.wallet != null){
                        this.info.wallet = this.info.wallet.toFixed(2);
                    }
                    // }
                });
            },
            updateName(event){
                this.user.name=event.target.innerText;
                console.log('update-----',event.target.innerText);
            },
            UpdateItem(){
                var send_data={};
                send_data.type= 'update';
                send_data.table_name= 'users';
                send_data.data=[];
                send_data.data=this.user;
                send_data.condition=[];
                send_data.condition.push(['id',this.user.id]);
                window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                    console.log(data.message);
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
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
        components: {

        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>