<template>
    <div class="container-fluid" style="padding-bottom: 200px;padding-top: 40px">
        <div id="accordion_19" role="tablist" aria-multiselectable="true" class="panel-group full-body">
            <div class="panel">
                <div role="tab" id="headingOne_3917" class="panel-heading"
                     style="background-color: rgb(8, 42, 73); color: white;">
                    <h4 class="panel-title"
                        style="text-align: center; padding: 0px; font-size: 16px;">
                        <a role="button" data-toggle="collapse" href="#collapseOne_3917" aria-expanded="true"
                           aria-controls="collapseOne_19" class="" style="padding: 5px 15px;text-align: left">
                            <img class="soccer">
                            Soccer
                        </a>
                    </h4>
                </div>
                <div id="collapseOne_3917" role="tabpanel" aria-labelledby="headingOne_19" aria-expanded="true"
                     class="panel-collapse collapse in" style="">
                    <div class="panel-body" style="padding: 0px;">
                        <events page="sport" target_id="1"></events>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordion_20" role="tablist" aria-multiselectable="true" class="panel-group full-body">
            <div class="panel">
                <div role="tab" id="headingOne_3918" class="panel-heading"
                     style="background-color: rgb(8, 42, 73); color: white;">
                    <h4 class="panel-title"
                        style="text-align: center; padding: 0px; font-size: 16px;">
                        <a role="button" data-toggle="collapse" href="#collapseOne_3918" aria-expanded="true"
                           aria-controls="collapseOne_19" class="" style="padding: 5px 15px;text-align: left">
                            <img class="cricket">
                            Cricket
                        </a>
                    </h4>
                </div>
                <div id="collapseOne_3918" role="tabpanel" aria-labelledby="headingOne_19" aria-expanded="true"
                     class="panel-collapse collapse in" style="">
                    <div class="panel-body" style="padding: 0px;">
                        <events page="sport" target_id="4"></events>
                    </div>
                </div>
            </div>
        </div>

        <div id="accordion_21" role="tablist" aria-multiselectable="true" class="panel-group full-body">
            <div class="panel">
                <div role="tab" id="headingOne_3919" class="panel-heading"
                     style="background-color: rgb(8, 42, 73); color: white;">
                    <h4 class="panel-title"
                        style="text-align: center; padding: 0px; font-size: 16px;">
                        <a role="button" data-toggle="collapse" href="#collapseOne_3919" aria-expanded="true"
                           aria-controls="collapseOne_19" class="" style="padding: 5px 15px;text-align: left">
                            <img class="tennis">
                            Tennis
                        </a>
                    </h4>
                </div>
                <div id="collapseOne_3919" role="tabpanel" aria-labelledby="headingOne_19" aria-expanded="true"
                     class="panel-collapse collapse in" style="">
                    <div class="panel-body" style="padding: 0px;">
                        <events page="sport" target_id="2"></events>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<style>

</style>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                link_list: [], available_balance: '', winnings: '',
            }
        },
        methods: {

        },

        created() {
            //this.getBaner();
            Event.$emit('leftside', '');
        },

    }
</script>
