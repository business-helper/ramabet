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
                        Super Master Table
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);" class="add_master" @click="showAdduserModal">Add Supper Master</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable masterexportable">
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
                            <tr v-for="(smaster, index) in supermasters" v-bind="smaster">
                                <td>{{smaster.id}}</td>
                                <td>{{smaster.email}}</td>
                                <td>{{smaster.wallet}}</td>
                                <td>{{smaster.profit_loss_amount}}</td>
                                <td>{{smaster.profit_loss_per}}</td>
                                <td class="datatable-ct master-actions">
                                    <router-link :to="'/acc_statement/admins/'+ smaster.id">
                                        <button title="Statement" class="pd-setting-ed action_button btn bg-green btn-block btn-sm waves-effect">
                                        S
                                        </button>
                                    </router-link>
                                    <router-link :to="'/profitLoss/admin/' + smaster.id">
                                        <button title="Profit and Loss" class="pd-setting-ed action_button btn bg-primary btn-block btn-sm waves-effect">
                                            PL
                                        </button>
                                    </router-link>
                                    <button title="Account Info" class="pd-setting-ed btn action_button btn bg-deep-orange waves-effect" @click="edituser(smaster)">
                                        I
                                        <!--<i class="fas fa-user-edit"></i>-->
                                    </button>
                                    <button title="Change Password" class="pd-setting-ed btn action_button bg-red btn-block btn-sm waves-effect" @click="showChangepasswordModal(smaster.id, 'admins')">
                                        <!--<i class="fas fa-unlock-alt"></i>-->
                                        P
                                    </button>
                                    <button title="Deposit" class="pd-setting-ed action_button btn bg-orange btn-block btn-sm waves-effect" @click="deposit('deposit', smaster, 'admins', index)">
                                        D
                                    </button>
                                    <button title="WithDraw"  class="pd-setting-ed action_button btn bg-orange btn-block btn-sm waves-effect" @click="deposit('withdraw', smaster, 'admins', index)">
                                        W
                                    </button>
                                    <button title="Close" v-if="smaster.is_close === 0" class="pd-setting-ed action_button btn bg-primary btn-block btn-sm waves-effect" @click="userclose('admins', smaster.id, index)">
                                        C
                                    </button>
                                    <button title="Active" v-else class="pd-setting-ed action_button btn bg-green btn-block btn-sm waves-effect" @click="activeuser('admins', smaster.id, index)">
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
        <addmaster v-if="showModal" @close="showModal = false" :masterid="this.$userId" is_super="1" @addUser="addSuperMaster" modal_title="Super Master"></addmaster>
        <changepassword v-if="changeModalShow" @close="changeModalShow = false" :user_id="this.user_id" :user_type="this.user_type"></changepassword>
        <edituser v-if="editModalShow" @close="editModalShow = false" :user="this.edit_user"></edituser>
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
                user_type:"",
                index: 0,
                is_super: 1,
                supermasters:[],
                mdt:"",


            }
        },
        methods: {
            getSuperMaster() {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
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
            },
            userclose(type, user_id, index){
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/closeUser', {user_id:user_id, user_type: type}).then((res) => {
                    if(res.data.result){
                        this.supermasters[index].is_close = 1;
                    }
                });
            },
            activeuser(type, user_id, index){
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/activeUser', {user_id:user_id, user_type: type}).then((res) => {
                    if(res.data.result){
                        this.supermasters[index].is_close = 0;
                    }
                });
            }
        },
        created(){
            this.getSuperMaster();
        }
    }
</script>

<style scoped>

</style>
