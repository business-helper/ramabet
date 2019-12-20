<style>

</style>
<template>
    <div class="container">
        <h1>Closed Account</h1>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#admin">Admin</a></li>
            <li><a data-toggle="tab" href="#super_master">Super Master</a></li>
            <li><a data-toggle="tab" href="#master">Master</a></li>
            <li><a data-toggle="tab" href="#user">User</a></li>
        </ul>

        <div class="tab-content">
            <div id="admin" class="tab-pane fade in active">
                <closeuserlist is_super="1" title="Admin"></closeuserlist>
            </div>
            <div id="super_master" class="tab-pane fade">
                <closeuserlist is_super="2" title="Super Master"></closeuserlist>
            </div>
            <div id="master" class="tab-pane fade">
                <closeuserlist is_super="3" title="Master"></closeuserlist>
            </div>
            <div id="user" class="tab-pane fade">
                <closeuserlist is_super="4" title="User"></closeuserlist>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            $('body').removeClass('overlay-open');
        }
    }
</script>
