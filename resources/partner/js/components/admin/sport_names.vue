<template>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Sports
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Save</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th data-field="id">ID</th>
                                <th data-field="id">Import ID</th>
                                <th data-field="name">Name</th>
                                <th data-field="name">Link</th>
                                <th data-field="name">Icon</th>
                                <th data-field="name">Color</th>
                                <th data-field="action">Is Active</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <sport_item v-for="item in this.sport_list" :key="item.id" :data="item">
                            </sport_item>
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
                sport_list:[]
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
                /*var send_data={};
                send_data.type= 'get';
                send_data.table_name= 'sport_names';
                //send_data.data=[];
                /!*send_data.data={
                    'id':$('#PrimaryModalhdbgcl #sports_id').val(),
                    'title':$('#PrimaryModalhdbgcl #sports_name').val(),
                };*!/
                send_data.condition=[];
                //send_data.condition.push(['is_active','true']);
                window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                    console.log('Get Sport From Api-------------',data);
                    this.sport_list=data.data;

                });*/
            },


        },
        created() {
            this.read();

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