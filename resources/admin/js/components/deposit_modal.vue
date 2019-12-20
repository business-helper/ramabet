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
    .fade.in{
        /*background-color: rgba(0,0,0,.5);*/
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
                    <h4 class="modal-title text-center">{{this.type}} {{this.to_user.email}}</h4>

                    <div class="modal-close-area modal-close-df">
                        <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close" data-dismiss="modal" @click="$emit('close')">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    <input id="master_id" type="hidden" class="form-control" />
                    <div class="form-group-inner">
                        <label>Free Cheeps</label>
                        <input id="name" type="number" v-model="amount" v-on:keyup="changebalance" class="form-control" placeholder="" />
                    </div>
                    <div class="form-group-inner">
                        <label>Remark</label>
                        <input id="remark" type="text" v-model="remark" class="form-control" placeholder="" />
                    </div>
                    <div class="table-responsive">
                        <table class="table-bordered table-striped table-hover deposit_table">
                            <tbody>
                            <!--<tr>-->
                                <!--<td>Parant Free Chips</td>-->
                                <!--<td class="font-bold"> 0.00 </td>-->
                            <!--</tr>-->
                            <tr>
                                <td>User Free Chips </td>
                                <td class="font-bold">{{this.to_user.wallet}}</td>
                            </tr>
                            <tr>
                                <td>Balance </td>
                                <td class="font-bold">{{this.wallet}}</td>
                            </tr>

                            <tr>
                                <td>Parant New Free Chips</td>
                                <td><span id="ParantNewFreeChips">{{this.user_new_wallet}}</span> </td>
                            </tr>

                            <tr>
                                <td>{{this.to_user.email}} New Free Chips</td>
                                <td><span id="myNewFreeChips">{{this.child_new_wallet}}</span> </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn bg-amber waves-effect" id="add_master" @click="submit">Submit</button>
                    <a class="btn bg-green waves-effect" data-dismiss="modal" @click="$emit('close')" href="javascript:;">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'type', 'to_user', 'user_type', 'index','email'
        ],
        data(){
            return {
                wallet: 0,
                amount: 0,
                user_new_wallet: 0,
                child_new_wallet: 0,
                parent_new_chips: 0,
                child_new_chips:0,
                remark:''
            }
        },
        methods: {
            changebalance(){
                console.log(this.to_user);
                if(this.amount != "" ) {
                    if(this.type == "deposit"){
                        this.user_new_wallet = this.wallet - parseInt(this.amount);
                        this.child_new_wallet = parseInt(this.to_user.wallet) + parseInt(this.amount);
                    }else{
                        this.user_new_wallet = this.wallet + parseInt(this.amount);
                        this.child_new_wallet = parseInt(this.to_user.wallet) - parseInt(this.amount);
                    }
                    this.convertfortype();

                }else{
                    if(this.type == "deposit"){
                        this.user_new_wallet = this.wallet;
                        this.child_new_wallet = parseInt(this.to_user.wallet);
                    }else{
                        this.user_new_wallet = this.wallet;
                        this.child_new_wallet = parseInt(this.to_user.wallet);
                    }
                    this.convertfortype();
                }
                // }else if(this.amount == ""){
                //     this.user_new_wallet =  this.wallet;
                //     this.child_new_wallet = parseInt(this.to_user.wallet);
                // }else if(parseInt(this.amount) > this.wallet){
                //     this.amount = this.amount.substring(0, this.amount.length - 1);
                //     this.user_new_wallet =  this.wallet - parseInt(this.amount);
                //     this.child_new_wallet = parseInt(this.to_user.wallet) + parseInt(this.amount);
                // }

            },
            convertfortype(){
                if(this.type == "deposit"){
                    this.parent_new_chips = -(this.amount);
                    this.child_new_chips = this.amount;
                }else{
                    this.child_new_chips = -(this.amount);
                    this.parent_new_chips = this.amount;
                }
            },
            submit(){
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/depositToChildUser', {user_id: this.to_user.parent_id, child_id: this.to_user.id, user_type: this.user_type, amount: this.child_new_chips,remark:this.remark}).then(({data}) => {
                    console.log(data);
                    if (data.state==1){
                        this.$emit('update', data.data.id,data.data.wallet,data.data.credit_limit);
                        Event.$emit('updateBalance');
                        Event.$emit('updateDeposit',this.to_user.parent_id,this.user_new_wallet);
                        this.$emit('close');
                        var starCountRef = this.$firebase.database().ref('/');
                        var deposit=data.note;
                        starCountRef.update({
                            deposit
                        }).then((data)=>{
                            //success callback
                            console.log('data ' , data)
                        }).catch((error)=>{
                            //error callback
                            console.log('error ' , error)
                        })
                    }
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');

                }).catch(function (resp) {
                    console.log(resp);
                });
            }
        },
        created(){
            var rand=uuidv1();

            axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+rand;
            axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+rand+this.$User.login_session+'tcgtchkmk1014');
            window.axios.post('/api/updateBalanceOfAdmin', {user_id: this.to_user.parent_id}).then(({data}) => {
                this.wallet = data.data.wallet;
                this.user_new_wallet = this.wallet;
                this.child_new_wallet = this.to_user.wallet;

            }).catch(function (resp) {
                console.log(resp);
            });

        }
    }
</script>

<style scoped>
    .deposit_table{
        min-width: 100%;
    }
</style>
