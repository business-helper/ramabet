<template>
    <ul class="nav navbar-nav" v-if="readFlag==1">
        <li>
            <router-link class="nav-link waves-effect waves-block" to="/" role="button" style="font-size: 20px; color: #59e721;"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="fas fa-home"></i>
            </router-link>
        </li>
        <li>
            <a v-on:click="this.read" style="" class="nav-link waves-effect waves-block" style="padding-right: 0">

                <span style="position: relative;">

                    <div v-if="is_read=='true'" class="loadingio-spinner-spin-mw88jknva3g" style="top: -94px; left: -94px;z-index: 10;position: absolute"><div class="ldio-h0vs2ccokr6">
                        <div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div>
                    </div></div>

                    <i class="fas fa-sync-alt"></i>
                </span>

            </a>
        </li>
        <li id="dropdown_menu1" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-block" href="#dropdown_menu1" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding-left: 0">
                <!--<i class="fas fa-cog"></i>-->
                {{(this.user.wallet+this.user.pAndL+this.user.cash+this.user.comAmount).toFixed(2)}}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"
            >
                <a class="dropdown-item waves-effect waves-block" href="javascript:void(0)">
                    <span style="margin-right: 10px">Wallet :</span>{{this.user.wallet-this.user.exposure}}
                </a>
                <a class="dropdown-item waves-effect waves-block" href="javascript:void(0)">
                    <span style="margin-right: 10px">Liability :</span>{{this.user.exposure.toFixed(2)}}
                </a>
                <a class="dropdown-item waves-effect waves-block" href="javascript:void(0)">
                    <span style="margin-right: 10px">P|L :</span>{{(this.user.pAndL+this.user.comAmount+this.user.cash).toFixed(2)}}
                </a>
                <a class="dropdown-item waves-effect waves-block" href="javascript:void(0)">
                    <span style="margin-right: 10px">T_P|L :</span>{{(this.user.pAndL+this.user.comAmount).toFixed(2)}}
                </a>
            </div>
        </li>
        <li id="dropdown_menu" class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle waves-effect waves-block" href="#dropdown_menu" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="fas fa-cog"></i>
                {{ this.user.email }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"
            >

                <a class="dropdown-item waves-effect waves-block" to="/changepassword" @click="showChangePassword">
                    <i class="fa fa-key" aria-hidden="true"></i> &nbsp;Change Password
                </a>
                <a class="dropdown-item waves-effect waves-block" @click="showEditStake">
                    <i class="far fa-credit-card"></i> Stake Edit
                </a>
                <a class="dropdown-item  waves-effect waves-block" href="/users/logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
        <modal name="staleEditModal" style="" draggable="true" width="300px" height="auto"
               class="back_betting_slip add_master_dlg">
            <div class="modal-content" style="height: 100%;">
                <div class="modal-header header-color-modal bg-color-1">
                    <h4 class="modal-title text-center">Stake Edit</h4>
                    <span id="type" style="display: none"></span>
                    <div class="modal-close-area modal-close-df">
                        <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close"
                                data-dismiss="modal" v-on:click="$modal.hide('staleEditModal')">&times;
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row" role="tab" style="">
                        <div class="col-xs-4" >
                            <label style="color: black">Stake Name</label>
                        </div>
                        <div class=" col-xs-8">
                            <label style="color: black">Stake Amount</label>
                        </div>

                    </div>
                    <div v-for="(item,index) in this.stake" class="row" role="tab" style="">
                        <div class="col-xs-4">
                            <input v-model="stake[index]['name']" type="text"
                                   class="form-control">
                        </div>
                        <div class=" col-xs-8">
                            <input v-model="stake[index]['amount']" type="number"
                                   class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn bg-amber waves-effect" id="add_master" v-on:click="setStake">
                        Submit
                    </button>
                    <button class="btn bg-green waves-effect" data-dismiss="modal"
                            v-on:click="$modal.hide('staleEditModal')">Cancel
                    </button>
                </div>
            </div>

        </modal>
        <modal name="changePasswordModal" style="" draggable="true" width="300px" height="260px"
               class="back_betting_slip add_master_dlg">
            <div class="modal-content" style="height: 100%;">
                <div class="modal-header header-color-modal bg-color-1">
                    <h4 class="modal-title text-center">Change Password</h4>
                    <div class="modal-close-area modal-close-df">
                        <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float close"
                                data-dismiss="modal" v-on:click="$modal.hide('changePasswordModal')">&times;
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row" style="">
                        <div class="col-xs-4" >
                            <label style="color: black">Current Password</label>
                        </div>
                        <div class=" col-xs-8">
                            <input v-model="oldPassword" type="password"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4" >
                            <label style="color: black">New Password</label>
                        </div>
                        <div class=" col-xs-8">
                            <input v-model="newPassword" type="password"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4" >
                            <label style="color: black">Confirm Password</label>
                        </div>
                        <div class=" col-xs-8">
                            <input v-model="confirmPassword" type="password"
                                   class="form-control">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn bg-amber waves-effect" v-on:click="changePassword">
                        Submit
                    </button>
                    <button class="btn bg-green waves-effect" data-dismiss="modal"
                            v-on:click="$modal.hide('changePasswordModal')">Cancel
                    </button>
                </div>
            </div>

        </modal>
    </ul>

</template>

<script>
    export default {
        data() {
            return {
                wallet: 0, liability: 0,
                name: 'guest',getUserTimer:'',matched:0,user:[],countDeclare:0,getSettlement:0,stake:[0,0,0,0,0,0],readFlag:0,newPassword:'',oldPassword:'',confirmPassword:'',is_read:'true',delPlaceBetCount:0
            }
        },
        props: [

        ],
        mounted() {
            Event.$on('getDelPlacedBet', (data) => {
                if ( data==null)return;
                if (data.bet_item.user_id==this.$userId && this.delPlaceBetCount>0){
                    Event.$emit('delPlacedBets',data);
                    showNotification('alert-success',data.msg+' by admin','bottom','right','animated fadeInRight','animated fadeOutRight');
                }
                this.delPlaceBetCount++;
            });
            Event.$on('updateBalance', (data) => {
                this.read();
            });
            Event.$on('placedBets', (data) => {
                this.read();
            });
            Event.$on('getMatchedBet', (data) => {
                if (data==null)return;
                if (this.matched==0){
                    this.matched++;
                    return;
                }

                data.forEach(matchedBet=>{
                    if (matchedBet.user==this.$userId){
                        Event.$emit('matchedBet', matchedBet.market_id,matchedBet.openBets);
                        Event.$emit('matchedBetProfit', matchedBet);
                        showNotification('alert-success',matchedBet.msg,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    }
                })

            });
            Event.$on('userLogin',(data) => {

                console.log('user from event',data);
            });
            Event.$on('getSettlement',(data) => {
                if (data==null)return;
                this.user=data.user;
            });
            Event.$on('loginCheck',(data) => {
                if (data==null)return;
                if (this.$User.login_session==data.login_session)return;
                showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');

                window.location.href=data.link;
            });
            Event.$on('getDeclare',(data) => {
                if (data==null)return;
                if (data.market.event_id==undefined)return;
                Event.$emit('removeEvent',data.market);
                this.read();
            });
            //this.getUserTimer=setInterval(this.getUser ,1000)
        },
        methods:{
            read() {
                this.is_read='true';
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/updateBalance',{user_id:this.$userId}).then(({ data }) => {
                    //this.cruds.push(new Crud(data));
                    this.user=data.data;
                    this.stake=JSON.parse(this.user.stake);
                    this.readFlag=1;
                    this.is_read='false'
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            refresh(){

            },
            showChangePassword(){
                this.$modal.show('changePasswordModal', {}, {
                    draggable: true
                })
            },
            changePassword(){
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/changePassword',{user_id:this.$userId,user_type:'users',newPassword:this.newPassword,oldPassword:this.oldPassword,confirmPassword:this.confirmPassword}).then(({ data }) => {
                    //this.cruds.push(new Crud(data));
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    if (data.state==0){
                        this.$modal.hide('changePasswordModal');
                    }

                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            showEditStake(){
                this.$modal.show('staleEditModal', {}, {
                    draggable: true
                })
            },
            setStake(){
               //console.log(this.stake);
                var data=uuidv1();

                axios.defaults.headers.common.Authtype =  'tf1-'+this.$User.id+'-'+data;
                axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+data+this.$User.login_session+'tcgtchkmk1014');
                window.axios.post('/api/setStake',{user_id:this.$userId,stake:this.stake}).then(({ data }) => {
                    //this.cruds.push(new Crud(data));
                    showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    Event.$emit('setStake',this.stake);
                    this.$modal.hide('staleEditModal');
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            create(data){

            },
            update(id,odd,stake) {

            },
            getUser(){


            }
        },
        created() {
            var starCountRef = this.$firebase.database().ref('/marketUpdate/');
            starCountRef.on('value', function (snapshot) {
                Event.$emit('marketUpdate',snapshot.val());
            });
            var starCountRef = this.$firebase.database().ref('/marketManagement/');
            starCountRef.on('value', function (snapshot) {
                Event.$emit('marketManagement',snapshot.val());
            });
            var starCountRef = this.$firebase.database().ref('/sportManagement/');
            starCountRef.on('value', function (snapshot) {
                Event.$emit('sportManagement',snapshot.val());
            });
            var starCountRef = this.$firebase.database().ref('/marketPlay');
            starCountRef.on('value', function (snapshot) {
                //this.read(id);
                //console.log(snapshot.val());
                Event.$emit('marketPlay',snapshot.val());
                //this.market.isPlay=snapshot.val();
            });
            var starCountRef = this.$firebase.database().ref('runners');
            starCountRef.on('value', function (snapshot) {
                //console.log(snapshot.val());
                if (snapshot.val().link==undefined || snapshot.val()==null)return;
                snapshot.val().link.forEach(item => {
                    Event.$emit('update_odd', item);
                });
                //this.read(id);
            });
            var starCountRef = this.$firebase.database().ref('matchedBet');
            starCountRef.on('value', function (snapshot) {
                //console.log(snapshot.val());
                Event.$emit('getMatchedBet', snapshot.val());
                Event.$emit('updateBalance', snapshot.val());
                //this.read(id);
            });
            var starCountRef = this.$firebase.database().ref('users/' + this.$userId);
            starCountRef.on('value', function (snapshot) {
                //console.log('updateBalance', snapshot.val());
                Event.$emit('updateBalance', 0);
                //showNotification('alert-success',notification.content.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                //this.read(id);
            });
            var starCountRef = this.$firebase.database().ref('Event/' + this.$userId);
            starCountRef.on('value', function (snapshot) {
                //console.log('updateEvent', snapshot.val());
                Event.$emit('updateEvent', 0);
                //showNotification('alert-success',notification.content.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                //this.read(id);
            });

            var starCountRef = this.$firebase.database().ref('Declare/');
            starCountRef.on('value', function (snapshot) {
                Event.$emit('getDeclare', snapshot.val());
            });

            var starCountRef = this.$firebase.database().ref('Settlement/users/'+ this.$userId);
            starCountRef.on('value', function (snapshot) {
                Event.$emit('getSettlement', snapshot.val());
            });
            var starCountRef = this.$firebase.database().ref('Settlement/users/'+this.$userId);
            starCountRef.on('value', function (snapshot) {
                Event.$emit('updateBalance', snapshot.val());
            });
            var starCountRef = this.$firebase.database().ref('loginCheck/users/'+ this.$userId);
            starCountRef.on('value', function (snapshot) {
                Event.$emit('loginCheck', snapshot.val());
            });
            var starCountRef = this.$firebase.database().ref('deposit/users/'+ this.$userId);
            starCountRef.on('value', function (snapshot) {
                Event.$emit('updateBalance', snapshot.val());
            });
            console.log('Create Element');
            var starCountRef = this.$firebase.database().ref('delPlacedBet/');
            starCountRef.on('value', function (snapshot) {

                let data=snapshot.val();
                console.log(data);
                Event.$emit('getDelPlacedBet', data);

            });
            this.read();

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
