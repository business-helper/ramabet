<template>
    <div>
        <h4>Account Name:{{m_sport_item.adminName}},Account Id:{{m_sport_item.adminEmail}}</h4>
        <h5 class="sport_title" style="">{{m_sport_item.name}}</h5>
        <div style="display: flex;flex-wrap: wrap;">
            <div class="sport_item">
                <h6>Min Stake</h6>
                <input v-model="m_sport_item.minStake" type="number" class="form-control"/>
            </div>
            <div class="sport_item">
                <h6>Max Stake</h6>
                <input v-model="m_sport_item.maxStake" type="number" class="form-control"/>
            </div>
            <div class="sport_item">
                <h6>Max Profit</h6>
                <input v-model="m_sport_item.maxProfit" type="number" class="form-control"/>
            </div>
            <div class="sport_item">
                <h6>Pre Inplay Profit</h6>
                <input v-model="m_sport_item.preInplayProfit" type="number" class="form-control"/>
            </div>
            <div class="sport_item">
                <h6>Pre Inplay Stake</h6>
                <input v-model="m_sport_item.preInplayStake" type="number" class="form-control"/>
            </div>
            <div class="sport_item">
                <h6>Delay In Second</h6>
                <input v-model="m_sport_item.delaySec" type="number" class="form-control"/>
            </div>
            <div class="sport_item">
                <h6>Commission</h6>
                <input v-if="this.$route.params.user_id==2" v-model="m_sport_item.commission" type="number" class="form-control" />
                <input v-else v-model="m_sport_item.commission" type="number" class="form-control" disabled/>
            </div>
            <div class="sport_item">
                <input v-model="m_sport_item.unMatched" type="checkbox" :id="'unmatchedBet'+m_sport_item.id" class="filled-in">
                <label :for="'unmatchedBet'+m_sport_item.id">UnMatched Bet</label>
            </div>
            <div class="sport_item">
                <input v-model="m_sport_item.lockBet" type="checkbox" :id="'lockBet'+m_sport_item.id" class="filled-in">
                <label :for="'lockBet'+m_sport_item.id">Lock Bet</label>
            </div>
        </div>
        <div v-if="m_sport_item.sport_id==4" style="margin-top: 10px;background: lightgrey">{{m_sport_item.name}} fancy</div>
        <div v-if="m_sport_item.sport_id==4" style="display: flex;flex-wrap: wrap;">
            <div class="sport_item">
                <h6>Min Stake</h6>
                <input v-model="m_sport_item.f_minStake" type="number" class="form-control"/>
            </div>
            <div class="sport_item">
                <h6>Max Stake</h6>
                <input v-model="m_sport_item.f_maxStake" type="number" class="form-control"/>
            </div>
            <div class="sport_item">
                <h6>Max Profit</h6>
                <input v-model="m_sport_item.f_profit" type="number" class="form-control"/>
            </div>

            <div class="sport_item">
                <h6>Delay In Second</h6>
                <input v-model="m_sport_item.f_delaySec" type="number" class="form-control"/>
            </div>
            <div class="sport_item">
                <h6>Commission</h6>
                <input v-if="this.$route.params.user_id==2" v-model="m_sport_item.f_commission" type="number" class="form-control" />
                <input v-else v-model="m_sport_item.f_commission" type="number" class="form-control" disabled/>
            </div>
            <div class="sport_item">
                <input v-model="m_sport_item.f_unMatched" type="checkbox" :id="'unmatchedBetf'+m_sport_item.id" class="filled-in">
                <label :for="'unmatchedBetf'+m_sport_item.id">UnMatched Bet</label>
            </div>
            <div class="sport_item">
                <input v-model="m_sport_item.f_lockBet" type="checkbox" :id="'lockBetf'+m_sport_item.id" class="filled-in">
                <label :for="'lockBetf'+m_sport_item.id">Lock Bet</label>
            </div>
        </div>
        <button class="btn bg-green waves-effect" @click="update">Update</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                m_sport_item:this.sport_item
            }
        },
        props: [
            'sport_item'
        ],
        mounted() {

        },
        methods: {
            update(){
                window.axios.post('/api/setSport', {isSuper:this.$isSuper,item:this.m_sport_item}).then(({data}) => {
                    console.log('-----GetSport-----', data);
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    var starCountRef = this.$firebase.database().ref('/');
                    var sportManagement=this.m_sport_item;
                    starCountRef.update({
                        sportManagement
                    }).then((data)=>{
                        //success callback
                        console.log('data ' , data)
                    }).catch((error)=>{
                        //error callback
                        console.log('error ' , error)
                    })
                    //this.$emit('update',data.data);
                });
            }
        },
        created() {

        },
        components: {},
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>