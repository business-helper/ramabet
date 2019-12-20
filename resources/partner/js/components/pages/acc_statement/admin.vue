
<template>
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Account Statement
                    </h2>
                    <ul class="header-dropdown m-r--5">

                    </ul>
                </div>
                <div class="date_filter header">
                    <form method="GET"  id="filter_form">
                        <input type="hidden" name="user_id" value="" />
                        <input type="date"  name="start_date" class="form-control" placeholder="Date start..." value="">
                        <input type="date"  name="end_date" value="" class="form-control" placeholder="Date end...">
                        <input type="text"  name="search" value="" class="form-control" placeholder="Search">
                        <button type="submit" class="btn bg-amber waves-effect" >Filter</button>
                        <button type="button" class="btn bg-light-green waves-effect" >Clear</button>
                    </form>

                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Before Amount</th>
                                <th>After Amount</th>
                            </tr>

                            </thead>
                            <tbody>
                                <tr >
                                    no records
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
</template>

<script>
    export default {
        data(){
            return {
                showModal: false,
                changeModalShow: false,
                user_type:"",
                user_id:"",
                edit_user:[],
                editModalShow:false,
                depositModalShow:false,
                to_user: [],
                deposit_type: "",
                user_type:"",
                index: 0,
                is_super: 1,
                supermasters:[],
                mdt:"",


            }
        },
        methods: {
            getSuperMaster() {
                window.axios.post('/api/getAdmins', {is_super: this.is_super, parent_id:this.$userId}).then((res) => {
                    console.log('get super master -------------', res);
                    this.supermasters = res.data;
                    this.$nextTick(() => {
                        this.mdt = $('.masterexportable').DataTable({
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
            showAdduserModal() {
                this.showModal = true;
            },
            showChangepasswordModal(user_id, user_type) {
                this.user_id = user_id;
                this.user_type = user_type;
                this.changeModalShow = true;
            },
            edituser(user){
                this.edit_user = user;
                this.editModalShow=true;
            },
            deposit(type, to_user, user_type, index){
                this.to_user = to_user;
                this.deposit_type=type;
                this.user_type = user_type;
                this.index = index;
                this.depositModalShow=true;
            },
            addSuperMaster(item){
                this.supermasters.push(item);
                this.mdt.destroy();
                this.$nextTick(() => {
                    this.mdt = $('.masterexportable').DataTable({
                        dom: 'Bfrtip',
                        responsive: true,
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        lengthMenu: [ 10, 25, 50],
                    });
                });

            },
            update(index, data){
                this.supermasters[index] = data;
            }
        },
        created(){
            // this.getSuperMaster();
        }
    }
</script>

<style scoped>

</style>