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
                            My Market
                        </h2>
                    </div>
                    <!--<div style="display: flex;justify-content: space-around;flex-wrap: wrap;">-->
                    <!--<input name="group5" type="radio" id="All" class="with-gap radio-col-light-blue">-->
                    <!--<label for="All">All</label>-->

                    <!--<input name="group5" type="radio" id="Free_Chips" class="with-gap radio-col-light-blue">-->
                    <!--<label for="Free_Chips">Free Chips</label>-->

                    <!--<input name="group5" type="radio" id="Settlement" class="with-gap radio-col-light-blue">-->
                    <!--<label for="Settlement">Settlement</label>-->

                    <!--<input name="group5" type="radio" id="Profit_Loss" class="with-gap radio-col-light-blue">-->
                    <!--<label for="Profit_Loss">Profit and Loss</label>-->

                    <!--<input name="group5" type="radio" id="Account_Statement" class="with-gap radio-col-light-blue">-->
                    <!--<label for="Account_Statement">Account Statement</label>-->


                    <!--</div>-->
                    <div class="date_filter header">
                        <input type="date" v-model="start_date" name="start_date" class="form-control" placeholder="Date start...">
                        <input type="date" v-model="end_date" name="end_date" class="form-control" placeholder="Date end...">
                        <input type="text" v-model="search" name="search" class="form-control" placeholder="Search">
                        <button type="button" class="btn bg-amber waves-effect" @click="read">Filter</button>
                        <button type="button" class="btn bg-light-green waves-effect" @click="clear">Clear</button>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable  markettable">
                                <thead>
                                <tr >
                                    <th>S.No. </th>
                                    <th>Match Name </th>
                                    <th>Market Id </th>
                                    <th>Sport Name</th>
                                    <th>Match Status </th>
                                    <th>Team A </th>
                                    <th>Team B </th>
                                    <th>Draw </th>

                                </tr>

                                </thead>
                                <tbody>
                                    <tr v-for="(market, index) in markets" v-bind="market">
                                        <td>{{index+1}}</td>
                                        <td>{{market.event_name}}</td>
                                        <td>{{market.id}}</td>
                                        <td>{{market.sport_name}}</td>
                                        <td>{{market.state}}</td>
                                        <td>{{market.team_a}}</td>
                                        <td>{{market.team_b}}</td>
                                        <td></td>

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
                search: "",
                start_date: "",
                end_date: "",
                markets: []
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
            read() {
                window.axios.post('/api/getadminMarket', {start_date: this.start_date, end_date: this.end_date, search: this.search}).then((res) => {
                    console.log('Get Market list -------------', res);
                    // if(res.state == 1){
                    this.markets = res.data.data.markets;
                    this.$nextTick(() => {
                        $('.markettable').DataTable({
                            dom: 'Bfrtip',
                            responsive: true,
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ],
                            lengthMenu: [ 10, 25, 50],
                        });
                    });
                    // }
                });
            },
            fixed(value){
                return value.toFixed(2);
            },
            clear(){
                this.start_date = "";
                this.end_date = "";
                this.search = "";
            },
        },
        created() {
            this.read();
        }
    }
</script>