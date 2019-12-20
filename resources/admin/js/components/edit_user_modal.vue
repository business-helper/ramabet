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
                    <h4 class="modal-title text-center">Edit User</h4>
                    <span id="type" style="display: none"></span>
                    <div class="modal-close-area modal-close-df">
                        <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close" data-dismiss="modal" @click="$emit('close')">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group-inner">
                        <label>Name</label>
                        <input id="name" type="text" v-model="user.name" class="form-control" placeholder="" disabled/>
                    </div>
                    <div class="form-group-inner">
                        <label>Email</label>
                        <input id="email" type="email" v-model="user.email" class="form-control" placeholder="" disabled/>
                    </div>
                    <!--<div class="form-group-inner">-->
                        <!--<label>Password</label>-->
                        <!--<input id="password" type="password" class="form-control" placeholder="" />-->
                    <!--</div>-->
                </div>
                <div class="modal-footer">
                    <button class="btn bg-amber waves-effect" id="add_master" >Submit</button>
                    <a class="btn bg-green waves-effect" data-dismiss="modal" @click="$emit('close')" href="javascript:;">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'user'
        ],
        data(){
            return {

            }
        },
        created(){
        }
    }
</script>

<style scoped>

</style>