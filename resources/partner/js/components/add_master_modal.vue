<style>
    .add_master_dlg .close{
        opacity: 1;
        width: 30px;
        height: 30px;
        position: absolute;
        top: 10px;
        padding: 0;
        right: 10px;
        background: white!important;
        color: #0a3862;
        font-weight: 900;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        font-weight: 900;
    }
    .add_master_dlg .modal .modal-header {
        border: none;
        padding: 5px 25px 5px 25px;
    }
    .add_master_dlg .modal-title{
        padding: 10px 0 10px;
        text-align: left;
        color:white;
    }
    .add_master_dlg .modal-header{
        background:#0a3862;
        padding: 1px 26px;
    }
    .rows{
        display: flex;
        margin: 0 -5px;
        justify-content: space-between;
    }
    .rows .form-group-inner{
        margin: 0 5px;
        flex: 1;
    }
    .modal.fade.in{
        background-color: rgba(0,0,0,.5);
    }
    .modal-footer{
        text-align: left;
    }
</style>
<template>
    <div class="add_master_dlg modal modal-edu-general default-popup-PrimaryModal fade in show" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header header-color-modal bg-color-1">
                    <h4 class="modal-title text-center">Add&nbsp;Account</h4>
                    <span id="type" style="display: none"></span>
                    <div class="modal-close-area modal-close-df">
                        <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close" data-dismiss="modal" @click="$emit('close')">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="rows">
                        <div class="form-group-inner">
                            <label>Full Name</label>
                            <input type="text" v-model="name" class="form-control" placeholder="" />
                        </div>
                        <div class="form-group-inner">
                            <label>UserName</label>
                            <input type="text" v-model="email" class="form-control" placeholder="" />
                        </div>
                    </div>
                    <div class="rows">
                        <div class="form-group-inner">
                            <label>Password</label>
                            <input type="password" v-model="confirmPassword" class="form-control" placeholder="" />
                        </div>
                        <div class="form-group-inner">
                            <label>Confirm Password</label>
                            <input type="password" v-model="password" class="form-control" placeholder="" />
                        </div>
                    </div>

                    <div class="rows">
                        <div class="form-group-inner">
                            <label>UserType</label>
                            <select v-model="userType" class="form-control">
                                <option v-if="this.is_super<=0" value="1">Admin</option>
                                <option v-if="this.is_super<=1" value="2">Super Master</option>
                                <option v-if="this.is_super<=2" value="3">Master</option>
                                <option value="4">User</option>
                            </select>
                        </div>
                        <div class="form-group-inner">
                            <label>Register Date</label>
                            <input id="register_date" type="text" v-model="register_date" class="form-control" placeholder="" value="" disabled/>
                        </div>
                        <!--<div class="form-group-inner">
                            <label>Commission</label>
                            <input type="number" v-model="commission" class="form-control" placeholder="1" />
                        </div>-->
                    </div>
                    <div class="rows">
                        <div v-if="userType!=='4'" class="form-group-inner">
                            <label>P/L Share %</label>
                            <input type="number" v-model="partnerShip" class="form-control" placeholder="0"  />

                        </div>
                        <!--<div class="form-group-inner">
                            <label>Delay In Second</label>
                            <input type="number" v-model="delaySec" class="form-control" placeholder="4" />
                        </div>-->
                    </div>
                    <div class="rows">
                        <!--<div class="form-group-inner">
                            <label>Fancy Delay In Second</label>
                            <input type="number" v-model="delayOfFancy" class="form-control" placeholder="2" />
                        </div>-->

                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn bg-amber waves-effect" id="add_master" @click="create">Submit</button>
                    <a class="btn bg-green waves-effect" data-dismiss="modal" @click="$emit('close')" href="javascript:;">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "add_user_modal",
        props: [
            'masterid', 'is_super','modal_title'
        ],
        data(){
            return {
                master_id:0,
                name: "",
                email: "",
                password: "",
                confirmPassword: "",
                profit_loss_per:0,
                register_date:"",
                userType:5,delayOfFancy:1,delaySec:2,partnerShip:0,commission:0

            }
        },
        methods:{
            create() {
                window.axios.post('/api/addAdmin', {
                    parent_id: this.$userId,
                    name: this.name,
                    email: this.email,
                    partnerShip: this.partnerShip,
                    is_super:this.userType,
                    password: this.password,
                    confirmPassword:this.confirmPassword,
                    comm:this.commission,
                    delayOfFancy:this.delayOfFancy,
                    delaySec:this.delaySec
                }).then(({data}) => {
                    console.log('Add super master -------------', data);
                    /*res.data.wallet = 0;
                    res.data.profit_loss_per = 0;*/
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    if (data.state!==0){
                        Event.$emit('addUser',this.userType,data.data);
                        this.$emit('close');
                    }
                });
            },
        },

        created(){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!

            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            var today = dd + '/' + mm + '/' + yyyy;
            this.register_date = today;
            this.master_id = this.masterid;
            $('body').removeClass('overlay-open');
            //console.log('is_super',this.is_super);
        }
    }
</script>

<style scoped>

</style>