<style>
    button.pd-setting-ed {
        height: 25px;
        width: 37px;
        padding: 0;
        margin: 0 5px !important;
    }

    .datatable-ct {
        display: flex;
        align-items: center;

    }
    .datatable-ct .btn:not(.btn-link):not(.btn-circle) i {
        top: 0px;
    }

</style>
<template>
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        PartnerShip Table
                    </h2>
                </div>

                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable masterexportable">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>User</th>
                                <th>Name</th>
                                <th>Max Part</th>
                                <th>Super</th>
                                <th>Master</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    no records
                                </tr>
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
        data(){
            return {
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
            }
        },
        created(){
            // this.getSuperMaster();
        }
    }
</script>

<style scoped>

</style>