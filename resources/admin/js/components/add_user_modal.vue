
<template>
    <div class="add_master_dlg modal modal-edu-general default-popup-PrimaryModal fade in show" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header header-color-modal bg-color-1">
                    <h4 class="modal-title text-center">Add User</h4>
                    <span id="type" style="display: none"></span>
                    <div class="modal-close-area modal-close-df">
                        <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close" data-dismiss="modal" @click="$emit('close')">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="rows">
                        <div class="form-group-inner">
                            <label>User Name</label>
                            <input id="name" type="text" v-model="name" class="form-control" placeholder="" />
                        </div>
                        <div class="form-group-inner">
                            <label>Register Date</label>
                            <input id="register_date" type="text" v-model="register_date" class="form-control" placeholder="" value="" disabled/>
                        </div>
                    </div>
                    <div class="rows">
                        <div class="form-group-inner">
                            <label>Email</label>
                            <input id="email" type="email" v-model="email" class="form-control" placeholder="" />
                        </div>
                        <div class="form-group-inner">
                            <label>Password</label>
                            <input id="password" type="password" v-model="password" class="form-control" placeholder="" />
                        </div>
                    </div>

                    <!--<div class="form-group-inner">-->
                        <!--<label>P|L Share</label>-->
                        <!--<input id="profit_loss_per" type="number" v-model="profit_loss_per" class="form-control" placeholder="" />-->
                    <!--</div>-->

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
            'masterid'
        ],
        data(){
            return {
                master_id:0,
                name: "",
                email: "",
                password: "",
                profit_loss_per:0,
                register_date:"",

            }
        },
        methods:{
            create() {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/addUser', {parent_id: this.masterid, name: this.name, email: this.email, password: this.password}).then((res) => {
                    console.log('Add user -------------', res);
                    res.data.wallet = 0;
                    res.data.profit_loss_per = 0;
                    this.$emit('addUser',res.data);
                    this.$emit('close');

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
        }
    }
</script>

<style scoped>

</style>
