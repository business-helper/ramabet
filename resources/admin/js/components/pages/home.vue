<template>
    <div class="container-fluid" style="padding-bottom: 200px;">
        <div id="accordion_20" role="tablist" aria-multiselectable="true" class="panel-group full-body">
            <div class="panel">
                <div role="tab" id="headingOne_3918" class="panel-heading market_title"
                     >
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
                        <events page="sport" target_id="4" inPlay="all"></events>
                    </div>
                </div>
            </div>
        </div>
        <div id="accordion_19" role="tablist" aria-multiselectable="true" class="panel-group full-body">
            <div class="panel">
                <div role="tab" id="headingOne_3917" class="panel-heading market_title"
                     >
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
                        <events page="sport" target_id="1" inPlay="all"></events>
                    </div>
                </div>
            </div>
        </div>
        <div id="accordion_21" role="tablist" aria-multiselectable="true" class="panel-group full-body">
            <div class="panel">
                <div role="tab" id="headingOne_3919" class="panel-heading market_title"
                     >
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
                        <events page="sport" target_id="2" inPlay="all"></events>
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
            $('body').removeClass('overlay-open');
            console.log('Component mounted.')
        },
        data() {
            return {
                link_list: [], available_balance: '', winnings: '',
            }
        },
        methods: {
            getBaner() {

            },
            next() {
                this.$refs.slick.next();
            },

            prev() {
                this.$refs.slick.prev();
            },

            reInit() {
                // Helpful if you have to deal with v-for to update dynamic lists
                this.$nextTick(() => {
                    this.$refs.slick.reSlick();
                });
            },
        },
        beforeUpdate() {
            if (this.$refs.slick) {
                this.$refs.slick.destroy();
            }
        },
        updated() {
            this.$nextTick(function () {
                if (this.$refs.slick) {
                    this.$refs.slick.create(this.slickOptions);
                }
            });
        },
        created() {
            //this.getBaner();
            Event.$emit('leftside', '');

        },

    }
</script>
