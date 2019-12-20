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
    .action_button{
        margin:0px!important;
    }

</style>
<template>
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <div  v-if="this.$isSuper<3" class="right">
                        <button class="action_button btn bg-green btn-block btn-sm waves-effect" @click="this.getMyAccount" style="width: auto">
                            My Accounts
                        </button>
                        <button class="action_button btn bg-green btn-block btn-sm waves-effect" @click="this.getSuperMaster" style="width: auto">
                            All Accounts
                        </button>
                    </div>

                    <h2>
                        {{this.current_name}}
                    </h2>
                    <!--<ul class="header-dropdown m-r&#45;&#45;5">-->
                        <!--<li class="dropdown">-->
                            <!--<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"-->
                               <!--aria-haspopup="true" aria-expanded="false">-->
                                <!--<i class="material-icons">more_vert</i>-->
                            <!--</a>-->
                            <!--<ul class="dropdown-menu pull-right">-->
                                <!--<li><a href="javascript:void(0);" class="add_master" @click="showAdduserModal">Add Supper Master</a></li>-->
                            <!--</ul>-->
                        <!--</li>-->
                    <!--</ul>-->
                </div>

                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable " :class="'masterexportable'+this.is_super">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th style="white-space: nowrap;">User ID</th>
                                <th style="white-space: nowrap;" v-if="is_super>=2">Admin</th>
                                <th style="white-space: nowrap;" v-if="is_super>=3">Super Master</th>
                                <th style="white-space: nowrap;" v-if="is_super>=4">Master</th>
                                <th style="white-space: nowrap;">Credit Limit</th>

                                <!--<th>Balance Up</th>
                                <th>Balance Down</th>-->
                                <th style="white-space: nowrap;">Balance</th>
                                <th>T_P|L</th>


                                <th style="white-space: nowrap;">Partnership</th>
                                <th v-if="is_super!=4" style="white-space: nowrap;">Loss Limit</th>
                                <th style="white-space: nowrap;">State</th>
                                <!--<th style="white-space: nowrap;">Action</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(smaster, index) in supermasters" v-bind="smaster">
                                <td> {{smaster.id}}</td>
                                <td> <div @click="selectAdmin(smaster.id,smaster.is_super)">{{smaster.email}}</div></td>
                                <td v-if="is_super>=2">{{smaster.admin}}</td>
                                <td v-if="is_super>=3">{{smaster.super_master}}</td>
                                <td v-if="is_super>=4">{{smaster.master}}</td>
                                <td>{{smaster.credit_limit}}</td>
                                <td>{{(smaster.wallet+smaster.pAndL+smaster.cash+smaster.comAmount).toFixed(2)}}<!--{{smaster.wallet}}--></td>
                                <!--profit and loss-->
                                <td :class="smaster.bUp1+smaster.comUp1>0?'loss_color':'profit_color'">{{-(smaster.bUp1+smaster.comUp1/*+smaster.bDown1+smaster.comDown1*/).toFixed(2)}}</td>
                                <!--<td>{{smaster.bUp+smaster.comUp}}</td>
                                <td>{{smaster.bDown+smaster.comDown}}</td>-->


                                <td>{{smaster.partnerShip}}%</td>
                                <td v-if="is_super!=4">{{smaster.credit_limit*smaster.partnerShip/100}}</td>
                                <td>{{smaster.state}}</td>
                                <!--<td class="datatable-ct master-actions">
                                    <router-link :to="{path:'/report/acc_statement',query:{userId:smaster.id,userType:is_super,userName:smaster.email}}">
                                        <button title="Statement" class="pd-setting-ed action_button btn bg-green btn-block btn-sm waves-effect">
                                            S
                                        </button>
                                    </router-link>
                                    <router-link :to="{path:'/report/profitAndLoss',query:{userId:smaster.id,userType:is_super,userName:smaster.email}}">
                                        <button title="Profit and Loss" class="pd-setting-ed action_button btn bg-primary btn-block btn-sm waves-effect">
                                            PL
                                        </button>
                                    </router-link>
                                    <router-link :to="'/management/sport/'+is_super+'/'+smaster.id">
                                        <button  title="Sport Management" class="pd-setting-ed btn action_button btn bg-deep-orange waves-effect">
                                            SM
                                        </button>
                                        &lt;!&ndash;<i class="fas fa-user-edit"></i>&ndash;&gt;
                                    </router-link>
                                    <button title="Change Password" class="pd-setting-ed btn action_button bg-red btn-block btn-sm waves-effect" @click="showChangepasswordModal(smaster.id, 'admins')">
                                        &lt;!&ndash;<i class="fas fa-unlock-alt"></i>&ndash;&gt;
                                        P
                                    </button>

                                    <button title="Deposit" class="pd-setting-ed action_button btn bg-orange btn-block btn-sm waves-effect" @click="deposit('deposit', smaster, 'admins', index)">
                                        D
                                    </button>
                                    <button title="WithDraw"  class="pd-setting-ed action_button btn bg-orange btn-block btn-sm waves-effect" @click="deposit('withdraw', smaster, 'admins', index)">
                                        W
                                    </button>
                                    <button title="LockBet" class="pd-setting-ed action_button btn bg-danger btn-block btn-sm waves-effect" @click="showLockBet(smaster)">
                                        LB
                                    </button>
                                    <button title="LockAccount" class="pd-setting-ed action_button btn bg-deep-orange btn-block btn-sm waves-effect" @click="showLockAccount(smaster)">
                                        LA
                                    </button>
                                    <button title="ActiveAccount" class="pd-setting-ed action_button btn bg-success btn-block btn-sm waves-effect" @click="setStateActive(smaster,'Active')">
                                        A
                                    </button>

                                </td>-->
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <changepassword v-if="changeModalShow" @close="changeModalShow = false" :user_id="this.user_id" :user_type="this.userType"></changepassword>
        <edituser v-if="editModalShow" @close="editModalShow = false" :user="this.edit_user"></edituser>
        <deposit v-if="depositModalShow" @close="depositModalShow = false" :user_type="this.userType" :type = "this.deposit_type" :to_user="this.to_user" :index="this.index" @update = "update"></deposit>
        <modal name="lockBet" style="" draggable="true" width="300px" height="260px"
               class="add_master_dlg">
            <div class="modal-content" style="height: 100%;">
                <div class="modal-header header-color-modal bg-color-1">
                    <h4 class="modal-title text-center">Lock Bet({{this.c_admin.email}})</h4>
                    <div class="modal-close-area modal-close-df">
                        <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close"
                                data-dismiss="modal" v-on:click="$modal.hide('lockBet')">&times;
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <textarea v-model="remark"
                              class="form-control" style="height: 120px"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn bg-amber waves-effect" v-on:click="setState('lockBet','LockBet')">
                        Lock Bet
                    </button>
                    <button class="btn bg-green waves-effect" data-dismiss="modal"
                            v-on:click="$modal.hide('lockBet')">Cancel
                    </button>
                </div>
            </div>

        </modal>
        <modal name="LockAccount" style="" draggable="true" width="300px" height="260px"
               class="add_master_dlg">
            <div class="modal-content" style="height: 100%;">
                <div class="modal-header header-color-modal bg-color-1">
                    <h4 class="modal-title text-center">Lock Account({{this.c_admin.email}})</h4>
                    <div class="modal-close-area modal-close-df">
                        <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close"
                                data-dismiss="modal" v-on:click="$modal.hide('LockAccount')">&times;
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <textarea v-model="remark"
                              class="form-control" style="height: 120px"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn bg-amber waves-effect" v-on:click="setState('LockAccount','LockAccount')">
                        Lock Account
                    </button>
                    <button class="btn bg-green waves-effect" data-dismiss="modal"
                            v-on:click="$modal.hide('LockAccount')">Cancel
                    </button>
                </div>
            </div>

        </modal>
    </div>
</template>

<script>
    export default {
        mounted() {
            Event.$on('addUser', (userType,item) => {
                if (userType===this.is_super){
                    this.addSuperMaster(item);
                }
            });
            Event.$on('updateDeposit', (admin_id,wallet) => {
                let index = this.supermasters.findIndex(item => item.id === admin_id);
                if (index>-1){
                    this.supermasters[index].wallet=wallet;
                }

            });
            Event.$on('selectAdmin', (admin_id,is_supuer) => {
                if (is_supuer<this.is_super){
                    window.axios.post('/api/getAdmins', {is_super: this.is_super, parent_id:admin_id}).then((res) => {
                        this.mdt.destroy();
                        console.log('get super master -------------', res);
                        this.supermasters = res.data;
                        this.$nextTick(() => {
                            //this.mdt.destroy();
                            this.mdt = $('.masterexportable'+this.is_super).DataTable({
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
            });

        },
        data(){
            return {
                showModal: false,
                changeModalShow: false,
                c_admin:[],
                user_id:"",
                edit_user:[],
                editModalShow:false,
                depositModalShow:false,
                to_user: [],
                deposit_type: "",
                index: 0,
                supermasters:[],
                mdt:"",
                current_name:'',
                remark:''
            }
        },

        props:[
            'is_super', 'title','userType'
        ],
        methods: {
            showLockAccount(account){
                this.c_admin=account;
                this.$modal.show('LockAccount', {}, {
                    draggable: true
                })
            },
            setState(modalName,state){
                if (this.remark==''){
                    this.remark=this.$User.email+' have set your state.';
                }

                this.c_admin.u_remark=this.remark;
                this.c_admin.state=state;
                //console.log('test',this.c_admin,state);
                var userType='admins';
                if (this.c_admin.is_super==undefined){
                    var userType='users';
                }
                this.remark='';
                this.$modal.hide(modalName);

                window.axios.post('/api/setAccountState', {account_id: this.c_admin.id,accountType:userType, admin_id:this.$userId,u_remark:this.c_admin.u_remark,state:state}).then(({data}) => {
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                });
            },
            setStateActive(admin,state){
                if (this.remark==''){
                    this.remark=this.$User.email+' have set your state.';
                }
                this.c_admin=admin;

                //this.c_admin.state=state;
                //console.log('test',this.c_admin,state);
                var userType='admins';
                if (this.c_admin.is_super==undefined){
                    userType='users';
                }

                window.axios.post('/api/setAccountState', {account_id: this.c_admin.id,accountType:userType, admin_id:this.$userId,u_remark:this.remark,state:state}).then(({data}) => {
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    if (data.state==1){
                        this.remark='';
                        this.c_admin.state=state;
                        this.c_admin.u_remark=this.remark;
                    }
                });
            },
            showLockBet(account){
                this.c_admin=account;
                this.$modal.show('lockBet', {}, {
                    draggable: true
                })
            },

            getSuperMaster() {
                this.current_name=this.title;
                window.axios.post('/api/getAdmins', {is_super: this.is_super, parent_id:this.$userId}).then((res) => {
                    console.log('get super master -------------', res);
                    this.supermasters = res.data;
                    if (this.mdt!=="") this.mdt.destroy();
                    this.$nextTick(() => {
                        this.mdt = $('.masterexportable'+this.is_super).DataTable({
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
            getMyAccount(){
                this.current_name=this.title;
                window.axios.post('/api/getAdmins', {is_super: this.is_super, parent_id:this.$userId,getType:'MY'}).then((res) => {
                    console.log('get super master -------------', res);
                    this.supermasters = res.data;
                    if (this.mdt!=="") this.mdt.destroy();
                    this.$nextTick(() => {
                        this.mdt = $('.masterexportable'+this.is_super).DataTable({
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
            selectAdmin(admin_id,is_super){
                console.log(admin_id);
                let index = this.supermasters.findIndex(item => item.id === admin_id);
                this.mute = true;
                this.c_admin=this.supermasters[index];
                this.mute = false;
                this.current_name=this.c_admin.name;
                this.mute = false;
                Event.$emit('selectAdmin',admin_id,is_super);
            },
            ////
            showAdduserModal() {
                this.showModal = true;
            },
            showChangepasswordModal(user_id, user_type) {
                this.user_id = user_id;
                this.user_type = this.userType;
                this.changeModalShow = true;
            },
            edituser(user){
                this.edit_user = user;
                this.editModalShow=true;
            },
            deposit(type, to_user, user_type, index){
                this.to_user = to_user;
                this.deposit_type=type;
                this.user_type = this.userType;
                console.log(this.userType);
                this.index = index;
                this.depositModalShow=true;
            },
            addSuperMaster(item){
                this.supermasters.push(item);
                this.mdt.destroy();
                this.$nextTick(() => {
                    this.mdt = $('.masterexportable'+this.is_super).DataTable({
                        dom: 'Bfrtip',
                        responsive: true,
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        lengthMenu: [ 10, 25, 50],
                    });
                });

            },
            update(id,wallet,credit_limit){
                let index = this.supermasters.findIndex(item => item.id === id);
                this.supermasters[index].wallet = wallet;
                this.supermasters[index].credit_limit = credit_limit;
            },
            userclose(type, user_id, index){
                window.axios.post('/api/closeUser', {user_id:user_id, user_type: this.userType}).then((res) => {
                    if(res.data.result){
                        this.supermasters[index].is_close = 1;
                    }
                });
            },
            activeuser(type, user_id, index){
                window.axios.post('/api/activeUser', {user_id:user_id, user_type: this.userType}).then((res) => {
                    if(res.data.result){
                        this.supermasters[index].is_close = 0;
                    }
                });
            }
        },
        created(){
            // this.getSuperMaster();addUser
            this.getSuperMaster();

        }
    }
</script>

<style scoped>

</style>