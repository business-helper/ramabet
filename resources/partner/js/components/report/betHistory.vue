<style>
    .date_filter {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        padding: 0 20px;
    }

    .date_filter input {
        /*width: 200px;*/
        margin: 5px;
        flex: 2;
        min-width: 150px;
    }
    .date_filter button{
        margin: 5px;
        /*width: 100px;*/
        flex: 1;
    }
    .date_filter select{
        margin: 5px;
        /*width: 100px;*/
        flex: 2;
        min-width: 150px;
    }

    form {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
</style>
<template>
    <div class="container-fluid" style="padding-bottom: 100px;padding-top: 50px">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Bet History
                        </h2>
                    </div>
                    <div class="date_filter header">
                        <input type="date" v-model="start_date" name="start_date" class="form-control" placeholder="Date start...">
                        <input type="date" v-model="end_date" name="end_date" class="form-control" placeholder="Date end...">
                        <input type="text" v-model="search" name="search_by" class="form-control" placeholder="Search By">

                        <select class="form-control" v-model="bet_type" name="type">
                            <option value="">Bet Type</option>
                            <option value="availableToLay">Khai</option>
                            <option value="availableToBack">Lagai</option>
                        </select>
                        <input type="text" name="odds" v-model="odd" class="form-control" placeholder="Odds">
                        <input type="text" name="stack" v-model="stake" class="form-control" placeholder="Stack">
                        <input type="text" v-model="ip" name="ip" class="form-control" placeholder="IP">
                        <select class="form-control" v-model="state" name="betStatus">
                            <option value="">Status</option>
                            <option value="1">Live</option>
                            <option value="2">End</option>
                        </select>
                        <button type="button" class="btn bg-amber waves-effect" @click="read">Filter</button>
                        <button type="button" class="btn bg-light-green waves-effect" @click="clear">Clear</button>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="">S.No. </th>
                                    <th class="">Selection </th>
                                    <th class="">Odds </th>
                                    <th class="">Stack </th>
                                    <th class="">Date </th>
                                    <th class="">P_L </th>
                                    <th class="">Profit </th>
                                    <th class="">Liability </th>
                                    <th class="">Bet type</th>
                                    <th class="">Status </th>
                                    <th class="">IP </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="bh in betHistory" v-bind="bh" :class="bh.bet_type">
                                        <td>{{bh.id}}</td>
                                        <td>{{bh.runnerName}}</td>
                                        <td>{{bh.odd}}</td>
                                        <td>{{bh.stake}}</td>
                                        <td>{{bh.at_update}}</td>
                                        <td>{{bh.profit_amount}}</td>
                                        <td>{{bh.profit}}</td>
                                        <td>{{Liability(bh.bet_type, bh.stake, bh.odd)}}</td>
                                        <td>{{bh.bet_type}}</td>
                                        <td>{{bh.state}}</td>
                                        <td>{{bh.ip}}</td>

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
                betHistory: [],
                start_date:"",
                end_date:"",
                bet_type:"",
                odd:"",
                state:"",
                ip:"",
                stake:"",
                search:""

            }
        },
        props: [
            'sport_id', 'state1'
        ],
        mounted() {
            $('body').removeClass('overlay-open');
            this.$nextTick(function () {

            })
            Event.$on('getDeclare',(data) => {
                this.read();
            });
        },
        methods: {
            clear(){
                this.start_date="";
                this.end_date = "";
                this.bet_type = "";
                this.odd = "";
                this.stack = "";
                this.ip = "";
                this.stake = "";
                this.search = "";
            },
            read() {

                window.axios.post('/api/bethistory', {start_date: this.start_date, search: this.search, odd: this.odd, bet_type: this.bet_type, end_date: this.end_date, stake: this.stake, state: this.state, ip: this.ip, user_id: this.$userId}).then((res) => {
                    console.log('-----BETHISTORY-----', res);
                    // if(res.state == 1){
                    this.betHistory = res.data.data;
                    // }
                });
            },
            Liability(bet_type, stake, odd) {
                if(bet_type == "availableToLay"){
                    return (odd * stake).toFixed(2);
                }else{
                    return stake;
                }
            }

        },
        created() {
            this.read();

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