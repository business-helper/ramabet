<template>
    <div class="container">
        updating Runner
    </div>
</template>

<script>
    export default {

        data() {
            return {
                user_data: [], league_list: [], market_count: 0, timer: 0
            }
        },
        props: [
            'sport_id', 'state1'
        ],
        mounted() {
            this.$nextTick(function () {
                window.setInterval(() => {
                    this.updateRunner();
                }, 1000);
            })
        },
        methods: {

            updateRunner() {

                this.timer++;

                if (this.market_count == undefined) this.market_count = 0
                if (this.timer > 100 && this.market_count == 0) {
                    window.location.href = '/updatedataRunner'
                }
                window.axios.get(`/api/betfair/v1/getOdd/${this.market_count}`,).then(({data}) => {
                    console.log('UpdateRunners-------------', this.timer, data);
                    var starCountRef = this.$firebase.database().ref('/');
                    this.market_count = data.count;
                    var fancyBets = data.fancyBets;
                    if (fancyBets != null && fancyBets != undefined) {
                        starCountRef.update({
                            fancyBets
                        }).then((data) => {
                            //success callback
                            console.log('data ', data)
                        }).catch((error) => {
                            //error callback
                            console.log('error ', error)
                        })
                    }

                    data.markets.forEach(market => {
                        var starCountRef = this.$firebase.database().ref('/Declare');
                        starCountRef.update({
                            market
                        }).then((data) => {
                            //success callback
                            console.log('data ', data)
                        }).catch((error) => {
                            //error callback
                            console.log('error ', error)
                        })
                    });
                    var index = 0;
                    data.insert_runners.forEach(market => {
                        if (JSON.stringify(market.runners) != JSON.stringify(market.runners1)) {
                            console.log(index, 'updating market', JSON.stringify(market.runners), JSON.stringify(market.runners1));
                            this.insertRunner(market);
                        }
                        index++;
                    })
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            insertRunner(data) {
                //console.log('Auto get data');
                window.axios.post('/api/betfair/v1/insertRunner', {
                    market_id: data.market_id,
                    runners: data.runners
                }).then(({data}) => {
                    console.log('inserted runners', data);
                    var starCountRef = this.$firebase.database().ref('/');
                    var runners = data.note;
                    if (runners != null && runners != undefined) {
                        starCountRef.update({
                            runners
                        }).then((data) => {
                            //success callback
                            console.log('data ', data)
                        }).catch((error) => {
                            //error callback
                            console.log('error ', error)
                        })
                    }


                    var matchedBet = data.matchedBet;
                    if (matchedBet != null) {
                        starCountRef.update({
                            matchedBet
                        }).then((data) => {
                            //success callback
                            console.log('data ', data)
                        }).catch((error) => {
                            //error callback
                            console.log('error ', error)
                        })
                    }

                });
            },


        },
        created() {
            this.updateRunner();

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