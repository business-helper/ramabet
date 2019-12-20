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
                        Master Table
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);" class="add_master" @click="showAdduserModal">Add Master</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable distexportable">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>User ID</th>
                                <th>Balance</th>
                                <th>chips P|L</th>
                                <th>Partnership</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(master, index) in masters" v-bind="master">
                                <td>{{master.id}}</td>
                                <td>{{master.email}}</td>
                                <td>{{master.wallet}}</td>
                                <td>{{master.profit_loss_amount}}</td>
                                <td>{{master.profit_loss_per}}</td>
                                <td class="datatable-ct master-actions">
                                    <router-link :to="'/acc_statement/admins/'+ master.id">
                                        <button title="Statement" class="pd-setting-ed action_button btn bg-green btn-block btn-sm waves-effect">
                                            S
                                        </button>
                                    </router-link>
                                    <router-link :to="'/profitLoss/admin/' + master.id">
                                        <button title="Profilt and Loss" class="pd-setting-ed action_button btn bg-primary btn-block btn-sm waves-effect">
                                            PL
                                        </button>
                                    </router-link>
                                    <button title="Account Info" class="pd-setting-ed btn action_button btn bg-deep-orange waves-effect" @click="edituser(master)">
                                        I
                                        <!--<i class="fas fa-user-edit"></i>-->
                                    </button>
                                    <button title="Change Password" class="pd-setting-ed btn action_button bg-red btn-block btn-sm waves-effect" @click="showChangepasswordModal(master.id, 'admins')">
                                        <!--<i class="fas fa-unlock-alt"></i>-->
                                        P
                                    </button>
                                    <button title="Deposit" class="pd-setting-ed action_button btn bg-orange btn-block btn-sm waves-effect" @click="deposit('deposit', master, 'admins', index)">
                                        D
                                    </button>
                                    <button title="WithDraw"  class="pd-setting-ed action_button btn bg-orange btn-block btn-sm waves-effect" @click="deposit('withdraw', master, 'admins', index)">
                                        W
                                    </button>

                                    <button title="Close" v-if="master.is_close === 0" class="pd-setting-ed action_button btn bg-primary btn-block btn-sm waves-effect" @click="userclose('admins', master.id, index)">
                                        C
                                    </button>
                                    <button title="Active" v-else class="pd-setting-ed action_button btn bg-green btn-block btn-sm waves-effect" @click="activeuser('admins', master.id, index)">
                                        A
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <addmaster v-if="showModal" @close="showModal = false" :masterid="this.$userId" is_super="2" @addUser="addMaster" modal_title="Master"></addmaster>
        <changepassword v-if="changeModalShow" @close="changeModalShow = false" :user_id="this.user_id" :user_type="this.user_type"></changepassword>
        <edituser v-if="editModalShow" @close="editModalShow = false" :user="this.edit_user"></edituser>
        <deposit v-if="depositModalShow" @close="depositModalShow = false" :deposit_type = "this.deposit_type" :to_user="this.to_user"></deposit>
        <deposit v-if="depositModalShow" @close="depositModalShow = false" :user_type="this.user_type" :type = "this.deposit_type" :to_user="this.to_user" :index="this.index" @update = "update"></deposit>
    </div>
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
                is_super:2,
                masters:[],
                ddt:"",
                index: 0

            }
        },
        methods: {
            getMaster() {
                window.axios.post('/api/getAdmins', {is_super: this.is_super, parent_id:this.$userId}).then((res) => {
                    console.log('get master -------------', res);
                    this.masters = res.data;
                    this.$nextTick(() => {
                        this.ddt = $('.distexportable').DataTable({
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
            addMaster(item){
                this.masters.push(item);
                this.ddt.destroy();
                this.$nextTick(() => {
                    this.ddt = $('.distexportable').DataTable({
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
                this.masters[index] = data;
            },
            userclose(type, user_id, index){
                window.axios.post('/api/closeUser', {user_id:user_id, user_type: type}).then((res) => {
                    if(res.data.result){
                        this.masters[index].is_close = 1;
                    }
                });
            },
            activeuser(type, user_id, index){
                window.axios.post('/api/activeUser', {user_id:user_id, user_type: type}).then((res) => {
                    if(res.data.result){
                        this.masters[index].is_close = 0;
                    }
                });
            }
        },
        created(){
            this.getMaster();
        }
    }
</script>

<style scoped>

</style>