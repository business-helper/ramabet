<template>
    <div class="container-fluid" style="">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#cricket_div" data-toggle="tab" aria-expanded="true">
                    <img class="cricket"> Cricket
                </a>
            </li>
            <li role="presentation" class="">
                <a href="#soccer_div" data-toggle="tab" aria-expanded="false">
                    <img class="soccer"> Soccer
                </a>
            </li>
            <li role="presentation" class="">
                <a href="#tennis_div" data-toggle="tab" aria-expanded="false">
                    <img class="tennis">Tennis
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in" id="cricket_div">
                <events page="sport" target_id="4"></events>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="soccer_div">
                <events page="sport" target_id="1"></events>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tennis_div">
                <events page="sport" target_id="2"></events>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                link_list:[],available_balance:'',winnings:''
            }
        },
        methods:{

        },
        created(){
            //this.getBaner();
            Event.$emit('leftside', '');
            //window.addEventListener('message', Anima.handleTokenResponse, false);
            console.log('user testing',usertoken);


        }
    }
</script>
