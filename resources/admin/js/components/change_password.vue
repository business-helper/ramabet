
<template>
    <div class="add_master_dlg modal modal-edu-general default-popup-PrimaryModal fade in show" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header header-color-modal bg-color-1">
                    <h4 class="modal-title text-center">Change Password</h4>
                    <span id="type" style="display: none"></span>
                    <div class="modal-close-area modal-close-df">
                        <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close" data-dismiss="modal" @click="$emit('close')">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group-inner">
                        <input id="user_id" :value="user_id" type="hidden" class="form-control" />
                        <input id="user_type" :value="user_type" type="hidden" class="form-control" />
                    </div>
                    <div class="rows">
                        <div class="form-group-inner">
                            <label>Password</label>
                            <input id="password" type="password" v-model="newPassword" class="form-control" placeholder="" />
                        </div>
                        <div class="form-group-inner">
                            <label>Confirm Password</label>
                            <input id="confirm_password" type="password" v-model="confirmPassword" class="form-control" placeholder="" />
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn bg-amber waves-effect" id="add_master" @click="update">Submit</button>
                    <a class="btn bg-green waves-effect" data-dismiss="modal" @click="$emit('close')" href="javascript:;">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'user_type', 'user_id'
        ],
        data(){
            return {
                newPassword: "",
                confirmPassword:"",

            }
        },
        methods: {
            update() {
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/changePasswordAdmin', {newPassword: this.newPassword, confirmPassword: this.confirmPassword, user_id: this.user_id, user_type: this.user_type}).then((res) => {
                    this.$emit('close');
                    showNotification('alert-success', res.data.msg, 'bottom', 'right', 'animated fadeInRight', 'animated fadeOutRight');
                });
            },
        },
        created(){
        }
    }
</script>

<style scoped>

</style>
