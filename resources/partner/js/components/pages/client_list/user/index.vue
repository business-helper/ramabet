<style>

</style>
<template>
    <div class="container">

        <h1>Account List</h1>
        <h5>S:Account Statement - PL:Profit and Loss - SM:Sport Management - P:Change Password - D:Deposit W:Withdraw - LB:Lock Bet - LA:Lock Account - A:Active Account</h5>

        <ul class="nav nav-tabs">
            <li v-if="admin.is_super==0" :class="admin.is_super==0?'active':''">
                <a data-toggle="tab" href="#admin" id="admin_tab_0">Admin</a>
            </li>
            <li v-if="admin.is_super<=1" :class="admin.is_super==1?'active':''">
                <a data-toggle="tab" href="#super_master" id="admin_tab_1" >Super Master</a>
            </li>
            <li v-if="admin.is_super<=2" :class="admin.is_super==2?'active':''">
                <a data-toggle="tab" href="#master" id="admin_tab_2">Master</a>
            </li>
            <li :class="admin.is_super==3?'active':''">
                <a data-toggle="tab" href="#user" id="admin_tab_3">User</a>
            </li>
        </ul>

        <div class="tab-content">
            <div v-if="admin.is_super<=0" id="admin" class="tab-pane fade" :class="admin.is_super==0?'in active':''">
                <closeuserlist is_super="1" title="Admin" userType="admins"></closeuserlist>
            </div>
            <div v-if="admin.is_super<=1" id="super_master" class="tab-pane fade" :class="admin.is_super==1?'in active':''">
                <closeuserlist is_super="2" title="Super Master" userType="admins"></closeuserlist>
            </div>
            <div v-if="admin.is_super<=2" id="master" class="tab-pane fade" :class="admin.is_super==2?'in active':''">
                <closeuserlist is_super="3" title="Master" userType="admins"></closeuserlist>
            </div>
            <div id="user" class="tab-pane fade" :class="admin.is_super==3?'in active':''">
                <closeuserlist is_super="4" title="User" userType="users"></closeuserlist>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            $('body').removeClass('overlay-open');
            Event.$on('selectAdmin', (admin_id,is_supuer) => {
                switch (is_supuer) {
                    case 0:
                        $('#admin_tab_0').trigger('click')
                        break;
                    case 1:
                        $('#admin_tab_1').trigger('click')
                        break;
                    case 2:
                        $('#admin_tab_2').trigger('click')
                        break;
                    case 3:
                        $('#admin_tab_3').trigger('click')
                        break;

                }
            });
        },
        data() {
            return {
                admin:[]
            }
        },
        methods:{
            getAdmin(){
                window.axios.post('/api/getAdmin', {user_id:this.$userId}).then(({data}) => {
                    console.log('get admin -------------', data);
                    this.admin = data.data;

                });
            }
        },
        created(){
            this.getAdmin();

        }
    }
</script>
