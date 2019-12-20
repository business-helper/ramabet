
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.md5 = require('md5');
window.dateFormat = require('date-and-time');
window.uuidv1 = require('uuid/v1');
import VueRouter from 'vue-router';

//import store from './store';
import VModal from 'vue-js-modal'
import firebase from 'firebase';
let firebaseConfig = {
    apiKey: "AIzaSyATsj4xJ0Vu9bl_Pd3FKzCLJO_f9-4qPrI",
    authDomain: "ramabet-dbb7f.firebaseapp.com",
    databaseURL: "https://ramabet-dbb7f.firebaseio.com",
    projectId: "ramabet-dbb7f",
    storageBucket: "ramabet-dbb7f.appspot.com",
    messagingSenderId: "740094412056",
    appId: "1:740094412056:web:c83301795c1f942cd40a6d"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
Vue.prototype.$firebase = firebase;


//export const db = firebase.database();




Vue.use(VModal);

window.Event = new Vue();
Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
Vue.prototype.$isSuper = document.querySelector("meta[name='is_super']").getAttribute('content');
Vue.prototype.$User = JSON.parse(document.querySelector("meta[name='user']").getAttribute('content'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Vue.component('home', require('./components/pages/home.vue'));
// Vue.component('line_chart', require('./components/admin/line_chart.vue'));
// Vue.component('sport_item', require('./components/admin/sport_item.vue'));
// Vue.component('sport_names', require('./components/admin/sport_names.vue'));
// Vue.component('notifications', require('./components/admin/notifications.vue'));
Vue.component('balance', require('./components/balance.vue'));

Vue.component('leftsidebar', require('./layout/leftsidebar.vue'));

Vue.component('events', require('./components/events.vue'));
Vue.component('event', require('./components/event.vue'));




// Vue.component('markets', require('./components/markets.vue'));
// Vue.component('market', require('./components/market.vue'));
Vue.component('betslip', require('./components/betslip.vue'));
Vue.component('betslip_item', require('./components/betslip_item.vue'));
Vue.component('eventdetail', require('./components/eventdetail.vue'));
// Vue.component('homeplaylist', require('./components/home_playlist.vue'));
 Vue.component('addmaster', require('./components/add_master_modal.vue'));
Vue.component('changepassword', require('./components/change_password.vue'));
// Vue.component('edituser', require('./components/edit_user_modal.vue'));
Vue.component('deposit', require('./components/deposit_modal.vue'));
// Vue.component('adduser', require('./components/add_user_modal.vue'));
Vue.component('closeuserlist', require('./components/closeuserlist.vue'));
Vue.component('betslipNew', require('./components/betslip_new.vue'));

Vue.use(VueRouter);
const routes = [
    // { path: '/', component: require('./components/user/page/home.vue')},
    // { path: '/update', component:  require('./components/updatedata.vue')},
    //{ path: '/profile', component:  require('./components/user/page/profile')},
    // { path: '/profitLoss', component:  require('./components/user/page/profitLoass')},
    // { path: '/bethistory', component:  require('./components/user/page/betHistory')},
    //{ path: '/balance', component:  require('./components/user/page/balance')},
    { path: '/multi_market', component:  require('./components/pages/multiMarkets.vue')},
    { path: '/fancyMarkets', component:  require('./components/pages/fancyMarkets.vue')},
    { path: '/sport/:sport_id', component:  require('./components/pages/sport.vue')},
    // { path: '/event/:event_id', component:  require('./components/user/page/event.vue')},
    // { path: '/league/:league_id', component:  require('./components/user/page/league.vue')},
    // { path: '/inplay', component:  require('./components/user/page/in_play')},
    // { path: '/acc_statement', component:  require('./components/user/page/acc_statement')},
    // { path: '/chip_history', component:  require('./components/user/page/chip_history')},
    //{ path: '/changepassword', component:  require('./components/user/page/change_password')},
    { path: '/my_market', component:  require('./components/pages/my_market.vue')},
    { path: '/', component: require('./components/pages/home.vue')},
    // { path: '/client/master', component: require('./components/pages/client_list/master/index.vue')},
    // { path: '/client/distributor', component: require('./components/pages/client_list/distributor/index.vue')},
    { path: '/client/user', component: require('./components/pages/client_list/user/index.vue')},
    { path: '/inplay', component:  require('./components/pages/in_play')},
    { path: '/event/:event_id', component:  require('./components/pages/event.vue')},

    // { path: '/running_market', component:  require('./components/pages/running_market')},
    // { path: '/block_market', component:  require('./components/pages/block_market')},
    // { path: '/partnership', component:  require('./components/pages/partnership')},
    // { path: '/client/close_user', component:  require('./components/pages/close_user')},
    // { path: '/client/partnership', component:  require('./components/pages/partnership')},
    //{ path: '/acc_statement/:type/:user_id', component:  require('./components/pages/acc_statement.vue')},
    // { path: '/match_list/:sport_id', component:  require('./components/pages/block_market_list.vue')},
    // { path: '/profitLoss/:type/:user_id', component:  require('./components/pages/profitLoss')},
    { path: '/report/profitAndLoss', component:  require('./components/report/profitloss.vue')},

    { path: '/report/acc_statement', component:  require('./components/report/acc_statement')},
    { path: '/report/betLog', component:  require('./components/report/betHistory')},
    { path: '/settlement', component:  require('./components/pages/settlement')},
    { path: '/report/wallet', component:  require('./components/report/wallet')},
    { path: '/report/settlement', component:  require('./components/report/settlement')},
    { path: '/report/acc_status', component:  require('./components/report/acc_status')},
    { path: '/report/commission', component:  require('./components/report/commission')},

    { path: '/management/sport/:userType/:user_id', component:  require('./components/pages/management/sports')},
    { path: '/management/series', component:  require('./components/pages/management/series')},
    { path: '/management/series/:series_name/:seriesId', component:  require('./components/pages/management/events')},
    { path: '/management/results', component:  require('./components/pages/management/results')},

];
const router = new VueRouter({
    routes
});

// var rand=uuidv1();
//
// axios.defaults.headers.common.Authtype =  'tf2-'+this.$User.id+'-'+rand;
// axios.defaults.headers.common.Authentication = md5('tf1-'+this.$User.id+'-'+rand+this.$User.login_session+'tcgtchkmk1014');


const app = new Vue({
    el: '#app',
    router,
    firebase
});
//var userId=document.querySelector("meta[name='user-id']").getAttribute('content');


