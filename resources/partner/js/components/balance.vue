<template>
    <ul class="nav navbar-nav" v-if="readFlag==1">
        <li>
            <router-link class="nav-link " to="/" role="button" style="font-size: 20px; color: #59e721;"
                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="fas fa-home"></i>
            </router-link>
        </li>
        <li>
            <a v-on:click="this.read" style="" class="nav-link waves-block" style="padding-right: 0">

                <span style="position: relative;">

                    <div v-if="is_read=='true'" class="loadingio-spinner-spin-mw88jknva3g" style="top: -94px; left: -94px;z-index: 10;position: absolute"><div class="ldio-h0vs2ccokr6">
                        <div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div>
                    </div></div>

                    <i class="fas fa-sync-alt"></i>
                </span>

            </a>
        </li>
        <li id="dropdown_menu1" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#dropdown_menu1" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding-left: 0">
                {{(this.user.wallet+this.user.pAndL+this.user.cash+this.user.comAmount).toFixed(2)}}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"
            >
                <a class="dropdown-item" href="javascript:void(0)">
                    <span style="margin-right: 10px">Wallet :</span>{{this.user.wallet}}
                </a>
                <!--<a class="dropdown-item" href="javascript:void(0)">
                    Liability:{{this.user.exposure}}
                </a>-->
                <a class="dropdown-item" href="javascript:void(0)">
                    <span style="margin-right: 10px">P|L :</span>{{(this.user.pAndL+this.user.comAmount+this.user.cash).toFixed(2)}}
                </a>
                <a class="dropdown-item" href="javascript:void(0)">
                    <span style="margin-right: 10px">T_P|L :</span>{{(this.user.pAndL+this.user.comAmount).toFixed(2)}}
                </a>
            </div>
        </li>
        <li id="dropdown_menu_wallet" class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#dropdown_menu_wallet" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="fas fa-cog"></i>
                {{ this.user.email }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"
            >

                <a class="dropdown-item" to="/changepassword" @click="showChangePassword">
                    <i class="fa fa-key" aria-hidden="true"></i> &nbsp;Change Password
                </a>
                <a class="dropdown-item" href="/partners/logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>

            </div>
        </li>
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
                user: [],
                liability: 0.0,
                name: 'guest',
                readFlag:0,
                placeBetCount:0,
                delPlaceBetCount:0,
                getMatchedCount:0,newPassword:'',oldPassword:'',confirmPassword:'',is_read:'true'
            }
        },
        props: [],
        mounted() {
            Event.$on('updateBalance', (data) => {
                this.read();
            });
            Event.$on('placedBets', (data) => {
                this.read();
            });
            Event.$on('getPlacedBet', (data) => {
                if ( data==null)return;
                console.log(this.placeBetCount);
                if (this.placeBetCount==0){
                    this.placeBetCount++;
                    return;
                }

                data.forEach(note=>{
                    let index = note.admins.findIndex(item => item == this.$userId);
                    if (index>-1){
                        Event.$emit('placedBets',note);

                        showNotification('alert-success',note.msg,'bottom','right','animated fadeInRight','animated fadeOutRight');
                    }
                });

            });
            Event.$on('loginCheck',(data) => {
                if (data==null)return;
                if (this.$User.login_session==data.login_session)return;
                showNotification('alert-success',data.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                window.location.href=data.link;
            });
            Event.$on('getDelPlacedBet', (data) => {
                if ( data==null)return;
                let index = data.admins.findIndex(item => item == this.$userId);
                if (index>-1 && this.delPlaceBetCount>0){
                    Event.$emit('delPlacedBets',data);
                    showNotification('alert-success',data.msg,'bottom','right','animated fadeInRight','animated fadeOutRight');
                }
                this.delPlaceBetCount++;
            });
            Event.$on('getMatchedBet', (data) => {
                if ( data==null)return;
                /*if (this.getMatchedCount==0){
                    this.getMatchedCount++;
                    return;
                }*/

                data.forEach(matchedBet=>{
                    let index = matchedBet.admins.findIndex(item => item == this.$userId);
                    if (index>=0){
                        Event.$emit('matchedBet', matchedBet.market_id,matchedBet.adminOpenBet[this.$userId]);
                        Event.$emit('placedBets', matchedBet);
                        showNotification('alert-success',matchedBet.msg,'bottom','right','animated fadeInRight','animated fadeOutRight');

                    }
                })

            });
            Event.$on('getDeclare',(data) => {
                if (data.market.event_id==undefined)return;
                Event.$emit('removeEvent',data.market.event_id);
                this.read();
            });
        },
        methods: {
            read() {
                console.log('userid', this.$userId);
                this.is_read='true'
                window.axios.post('/api/updateBalanceOfAdmin', {user_id: this.$userId}).then(({data}) => {
                    this.user=data.data;
                    this.readFlag=1;
                    this.is_read='false'
                }).catch(function (resp) {
                    console.log(resp);
                });
            },
            showChangePassword(){
                this.$modal.show('changePasswordModal', {}, {
                    draggable: true
                })
            },
            changePassword(){
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
            create(data) {
                /*this.mute = true;
                this.betslipes.push(new BetSlip(data));
                this.mute = false;*/
            },
            update(id, odd, stake) {
                //alert('updated',odd);
                /*this.mute = true;
                console.log('updated odd:',id,odd,stake)
                window.axios.post(`/api/updateBetslip/${id}`, { id:id,odd:odd,stake:stake }).then((data) => {
                    console.log(data);
                    this.betslipes.find(item => item.id === id).odd = odd;
                    this.betslipes.find(item => item.id === id).stake = stake;
                    this.mute = false;
                    this.calculate();
                });*/
            },
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
            var starCountRef = this.$firebase.database().ref('runners');
            starCountRef.on('value', function (snapshot) {
                //console.log(snapshot.val());
                if (snapshot.val().link==undefined || snapshot.val()==undefined)return;
                snapshot.val().link.forEach(item => {
                    Event.$emit('update_odd', item);
                });
                //this.read(id);
            });
            var starCountRef = this.$firebase.database().ref('matchedBet');
            starCountRef.on('value', function (snapshot) {
                //console.log(snapshot.val());
                Event.$emit('getMatchedBet', snapshot.val());

                //this.read(id);
            });
            var starCountRef = this.$firebase.database().ref('users/' + this.$userId);
            starCountRef.on('value', function (snapshot) {
                console.log('updateBalance', snapshot.val());
                Event.$emit('updateBalance', 0);
                //showNotification('alert-success',notification.content.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                //this.read(id);
            });
            var starCountRef = this.$firebase.database().ref('placedBet/');
            starCountRef.on('value', function (snapshot) {
                let data=snapshot.val();
                Event.$emit('getPlacedBet', data);

            });
            var starCountRef = this.$firebase.database().ref('delPlacedBet/');
            starCountRef.on('value', function (snapshot) {

                let data=snapshot.val();
                console.log(data);
                Event.$emit('getDelPlacedBet', data);

            });
            var starCountRef = this.$firebase.database().ref('Event/' + this.$userId);
            starCountRef.on('value', function (snapshot) {
                console.log('updateEvent', snapshot.val());
                Event.$emit('updateEvent', 0);
                //showNotification('alert-success',notification.content.message,'bottom','right','animated fadeInRight','animated fadeOutRight');
                //this.read(id);
            });

            var starCountRef = this.$firebase.database().ref('Declare/');
            starCountRef.on('value', function (snapshot) {
                Event.$emit('getDeclare', snapshot.val());
            });
            var starCountRef = this.$firebase.database().ref('Settlement/admins/'+this.$userId);
            starCountRef.on('value', function (snapshot) {
                Event.$emit('updateBalance', snapshot.val());
            });
            var starCountRef = this.$firebase.database().ref('loginCheck/admins/'+ this.$userId);
            starCountRef.on('value', function (snapshot) {
                Event.$emit('loginCheck', snapshot.val());
            });
            var starCountRef = this.$firebase.database().ref('deposit/admins/'+ this.$userId);
            starCountRef.on('value', function (snapshot) {
                Event.$emit('updateBalance', snapshot.val());
            });
            console.log('Create Element');



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
