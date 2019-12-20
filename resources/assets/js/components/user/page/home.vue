<template>
    <div class="container-fluid" style="">
        <div class="panel-group full-body" id="accordion_19" role="tablist" aria-multiselectable="true">
            <div class="panel">
                <div class="panel-heading market_title" role="tab" id="headingOne_4" >
                    <h4 class="panel-title" style=" text-align: left; padding: 0; font-size: 16px;">
                        <a role="button" data-toggle="collapse" :href="'#collapseOne_'+4" aria-expanded="true" aria-controls="collapseOne_19" class="" style="    padding: 5px 15px;">
                            Cricket
                        </a>
                    </h4>
                </div>
                <div :id="'collapseOne_'+4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_19" aria-expanded="true" >
                    <div class="panel-body" style="padding: 0">
                        <events page="sport" target_id="4"  inPlay="all"></events>
                    </div>
                </div>
            </div>

        </div>
        <div class="panel-group full-body" id="accordion_20" role="tablist" aria-multiselectable="true">
            <div class="panel">
                <div class="panel-heading market_title" role="tab" id="headingOne_1" >
                    <h4 class="panel-title" style=" text-align: left; padding: 0; font-size: 16px;">
                        <a role="button" data-toggle="collapse" :href="'#collapseOne_'+1" aria-expanded="true" aria-controls="collapseOne_19" class="" style="    padding: 5px 15px;">
                            Soccer
                        </a>
                    </h4>
                </div>
                <div :id="'collapseOne_'+1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_20" aria-expanded="true" >
                    <div class="panel-body" style="padding: 0">
                        <events page="sport" target_id="1" inPlay="all"></events>
                    </div>
                </div>
            </div>

        </div>
        <div class="panel-group full-body" id="accordion_21" role="tablist" aria-multiselectable="true">
            <div class="panel">
                <div class="panel-heading market_title" role="tab" id="headingOne_2" >
                    <h4 class="panel-title" style=" text-align: left; padding: 0; font-size: 16px;">
                        <a role="button" data-toggle="collapse" :href="'#collapseOne_'+2" aria-expanded="true" aria-controls="collapseOne_21" class="" style="    padding: 5px 15px;">
                            Tennis
                        </a>
                    </h4>
                </div>
                <div :id="'collapseOne_'+2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_21" aria-expanded="true" >
                    <div class="panel-body" style="padding: 0">
                        <events page="sport" target_id="2" inPlay="all"></events>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            $('body').removeClass('overlay-open');
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
            //console.log('user testing',usertoken);


        }
    }
</script>
