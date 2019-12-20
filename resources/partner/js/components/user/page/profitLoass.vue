<style>
    .date_filter {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        padding: 0 20px;
    }

    .date_filter input {
        width: 200px;
        margin: 5px;
    }
    .date_filter button{
        margin: 5px;
        width: 100px;
    }
    .date_filter select{
        margin: 5px;
        width: 100px;
    }

    form {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
</style>
<template>
    <div class="container-fluid" style="">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Profit & Loss
                        </h2>
                        <ul class="header-dropdown m-r--5">

                        </ul>
                    </div>
                    <div class="date_filter" style="display: flex;justify-content: flex-start;">

                        <select v-model="sport" class="form-control" style="flex: 1;">
                            <option value="all">All</option>
                            <option value="4">Cricket</option>
                            <option value="1">Soccer</option>
                            <option value="2">Tennis</option>
                        </select>
                        <input type="date" name="start_date" v-model="start_date" class="form-control" placeholder="Date start..." style="flex: 1;">
                        <input type="date" v-model="end_date" name="end_date" class="form-control" placeholder="Date end..." style="flex: 1;">
                        <input type="test" name="event_name" v-model="event_name" class="form-control" placeholder="Via event name" style="flex: 1;">
                    </div>
                    <div class="date_filter">
                        <button type="button" class="btn bg-amber waves-effect" @click="filter">Filter</button>
                        <button type="button" class="btn bg-light-green waves-effect" @click="clear">Clear</button>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th class="">S.No.</th>
                                        <th class="">Event Name</th>
                                        <th class="">Market</th>
                                        <th class="">P | L</th>
                                        <th class="">Commission</th>
                                        <th class="">Created On</th>
                                        <th class="">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr v-for="pl in profit_loss" v-bind="pl" :class="pl.user >= 0?'profit_item':'lose_item'">
                                    <td>{{pl.market.id}}</td>
                                    <td>{{pl.market.eventName}}</td>
                                    <td>{{pl.market.marketName}}</td>
                                    <td>{{pl.user}}</td>
                                    <td>{{pl.service_fee}}</td>
                                    <td>{{pl.market.date_time}}</td>
                                    <td>{{pl.market.is_active}}</td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

        data() {
            return {
                sport_list: [],start_date: "", end_date: "", event_name: "", sport: "all",profit_loss:[]
            }
        },
        props: [
            'sport_id', 'state1'
        ],
        mounted() {
            this.$nextTick(function () {

            })
        },
        methods: {
            filter(){
                var send_data = {};
                send_data.start_date = this.start_date;
                send_data.sport = this.sport;
                send_data.end_date = this.end_date;
                send_data.event_name = this.event_name;
                send_data.user_id = userID;
                console.log(send_data);
                // window.axios.post(`/api/updateBetSlip/${id}`, { id:id,odd:odd,stake:stake}).then((data) => {
                //     this.betslips[index].odd=odd;
                //     this.betslips[index].stake=stake;
                //     this.calculate();
                // });
                window.axios.post('/api/profitOfUser', {start_date: this.start_date, sport: this.sport, end_date: this.end_date, event_name: this.event_name, user_id: userID}).then((res) => {
                    console.log('Get Account info profile and loss -------------', res);
                    // if(res.state == 1){
                        this.profit_loss = res.data.data;
                    // }
                });
            },

            clear(){
                this.start_date = "";
                this.end_date = "";
                this.event_name = "";
                this.sport = "all";
            }
        },
        created() {
            this.filter();

            /*this.updateEvent1()*/
        },
        components: {},
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>