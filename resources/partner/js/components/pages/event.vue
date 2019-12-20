<template>
    <div class="container-fluid" style="">
        <h3 v-if="this.markets.length==0">You don't have any Market yet.
        </h3>
        <div v-else style="display: flex">
            <div style="flex: 1">
                <eventdetail v-for="market in markets.slice(0,1)"  multi_market="1" :market_id="market.id" :key="market.id" ></eventdetail>
                <eventdetail v-for="market in markets.slice(1)"  multi_market="1" :market_id="market.id" :key="market.id" ></eventdetail>
                <betslipNew v-if="widthOfWindow<850" :event_import_id="event_import_id"></betslipNew>
            </div>
            <div v-if="widthOfWindow>850" style="flex: 1">
                <betslipNew  class="laptop_betslip" :event_import_id="event_import_id"></betslipNew>
            </div>

        </div>
        <button v-if="this.$isSuper==0" type="button" class="btn bg-indigo btn-circle-lg waves-effect waves-circle waves-float" title="Add Market" style="position: fixed; bottom: 20px; right: 20px;" @click="showModal('addMarket')">
            <i class="material-icons">trending_up</i>
        </button>
        <modal name="addMarket" style="" draggable="true" width="300px" height="auto" resizable="true" adaptive="true"
               class="back_betting_slip add_master_dlg">
            <div class="modal-content" style="height: 100%;">
                <div class="modal-header header-color-modal bg-color-1">
                    <h4 class="modal-title text-center">Add market</h4>
                    <div class="modal-close-area modal-close-df">
                        <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close"
                                data-dismiss="modal" v-on:click="$modal.hide('addMarket')">&times;
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row" style="">
                        <div class="col-xs-4" >
                            <label style="color: black">Market Name</label>
                        </div>
                        <div class=" col-xs-8">
                            <input v-model="marketName" type="text"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4" >
                            <label style="color: black">Runners</label>
                        </div>
                        <div class=" col-xs-8" style="text-align:center">
                            <button class="btn btn-default" v-on:click="runners.push('')"
                                    >Add
                            </button>
                            <button class="btn btn-default" v-on:click="runners.pop()"
                            >Remove
                            </button>
                        </div>
                    </div>
                    <div v-for="(item,index) in runners" class="row">
                        <div class="col-xs-4" >
                            <label style="color: black;line-height:34px">Runner{{index}}</label>
                        </div>
                        <div class=" col-xs-8" style="text-align:center">
                            <input v-model="runners[index]" type="text"
                                   class="form-control">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn bg-amber waves-effect" v-on:click="addMarket('addMarket')" >
                        Submit
                    </button>
                    <button class="btn bg-green waves-effect" data-dismiss="modal"
                            v-on:click="$modal.hide('addMarket')">Cancel
                    </button>
                </div>
            </div>

        </modal>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                runners:[],is_show:'show',event:[],market:[],markets:[],currentMarketId:'',widthOfWindow:900,marketName:'',event_import_id:0
            }
        },
        props: [
            'market_id'
        ],
        mounted() {
            $('body').removeClass('overlay-open');
            console.log('Multi market Component mounted.');

            Event.$on('marketUpdate', (market) => {
                if (this.$isSuper==0)return;
                if (market.event_id!=this.$route.params.event_id)return;
                if (market.is_active==1){
                  /*  let index = this.markets.findIndex(item => item.id === market.id);
                    if (index>=0)return;
                    this.markets.push(market);*/
                    this.read1()

                } else{
                    let index = this.markets.findIndex(item => item.id === market.id);
                    this.markets.splice(index, 1);
                }

            });
            Event.$on('delMarkets', (data) => {
                let index = this.markets.findIndex(item => item.id === data);
                if (index>-1){
                    this.markets.splice(index, 1);
                }

            });
            Event.$on('changeWidth', (data) => {
                this.widthOfWindow=data;
                //console.log(data);
            });
        },
        methods:{
            read1(){
                if (this.$isSuper==0){
                    var data=uuidv1();

                    axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                    axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                    window.axios.get(`/api/getEventDetail/${this.$route.params.event_id}/admin`).then(({data}) => {
                        console.log('my markets',this.markets);
                        this.markets=data.data.markets;
                        this.event_import_id=data.data.event.import_id;
                    });
                } else{
                    var data=uuidv1();

                    axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+data;
                    axios.defaults.headers.common.Authentication = md5('tf2-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                    window.axios.get(`/api/getEventDetail/${this.$route.params.event_id}`).then(({data}) => {
                        console.log('my markets',this.markets);
                        this.markets=data.data.markets;
                        this.event_import_id=data.data.event.import_id;
                    });
                }

            },
            create(data){
            },
            update(id,odd,stake) {

            },
            showModal(name){
                this.$modal.show(name, {}, {
                    draggable: true,
                    resizable: true
                })
            },
            addMarket(name){
                this.$modal.hide(name);
                window.axios.post('/api/createMarkets',{event_id:this.$route.params.event_id,marketName:this.marketName,runners:this.runners}).then(({ data }) => {
                    //this.cruds.push(new Crud(data));
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    this.marketName='';
                    this.runners=[];
                    this.read1();

                }).catch(function (resp) {
                    console.log(resp);
                });

            }
        },
        created() {
            //console.log('Create Element');
            //this.read();
            this.read1();
            this.widthOfWindow=window.innerWidth;
        },
        components: {
            //BetSlipItem
        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>
