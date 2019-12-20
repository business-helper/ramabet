<template>
    <div class="list-group">
        <a v-for="item in this.local_notification_list" :key="item.id" :v-bind="item" href="javascript:void(0);" class="list-group-item" style="height: unset;">
            <!--<div class="icon-circle bg-light-green">
                <i class="material-icons">person_add</i>
            </div>-->
            <div class="menu-info" >
                <h4 class="list-group-item-heading">{{item.data.content.message}}</h4>
                <p class="list-group-item-text">
                    <i class="material-icons">access_time</i> {{item.data.repliedTime.date}}
                </p>
                <p class="list-group-item-text" style="text-align: right;padding-right: 30px">
                    From {{item.data.sender.name}}
                </p>
            </div>
        </a>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                local_notification_list:[]
            }
        },
        props: [
            'notification_list'
        ],
        mounted() {
            this.$nextTick(function () {

            })
        },
        methods:{
            read() {
                //console.log('Auto get data');

            },


        },
        created() {
            this.local_notification_list=JSON.parse(this.notification_list);
            console.log(JSON.parse(this.notification_list));
        },
        components: {

        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>