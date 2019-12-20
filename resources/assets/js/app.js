
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
Vue.prototype.$User = JSON.parse(document.querySelector("meta[name='user']").getAttribute('content'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VueRouter);
const routes = [
    //{ path: '/', component: require('./components/user/page/home.vue')},
    { path: '/update', component:  require('./components/updatedata.vue')},
    //{ path: '/profile', component:  require('./components/user/page/profile')},
    { path: '/report/acc_status', component:  require('./components/user/page/report/acc_status')},
    // { path: '/report/profitLoss', component:  require('./components/user/page/report/profitLoass')},
    { path: '/report/bethistory', component:  require('./components/user/page/report/betHistory')},
    { path: '/report/result', component:  require('./components/user/page/report/results')},
    //{ path: '/balance', component:  require('./components/user/page/balance')},
    { path: '/multi_market', component:  require('./components/user/page/multiMarkets.vue')},
    { path: '/my_market', component:  require('./components/user/page/my_market.vue')},
    { path: '/fancyMarkets', component:  require('./components/user/page/fancyMarkets.vue')},
    { path: '/sport/:sport_id', component:  require('./components/user/page/sport.vue')},
    { path: '/event/:event_id', component:  require('./components/user/page/event.vue')},
    { path: '/league/:league_id', component:  require('./components/user/page/league.vue')},
    { path: '/', component:  require('./components/user/page/home')},
    { path: '/inplay', component:  require('./components/user/page/in_play')},
    { path: '/report/acc_statement', component:  require('./components/user/page/report/acc_statement')},
    { path: '/report/wallet', component:  require('./components/user/page/report/wallet')},
    { path: '/report/profitAndLoss', component:  require('./components/user/page/report/profitloss')},
    { path: '/report/commission', component:  require('./components/user/page/report/commission')},
    { path: '/report/settlement', component:  require('./components/user/page/report/settlement')},

    //{ path: '/changepassword', component:  require('./components/user/page/change_password')},
];
const router = new VueRouter({
    routes
});

Vue.component('leftsidebar', require('./components/user/layout/leftsidebar'));
//Vue.component('leftsidebar1', require('./components/user/layout/leftsidebar1'));
//Vue.component('leftsideofleague', require('./components/user/layout/leftsideofleague'));
//Vue.component('leftsideofmarkets', require('./components/user/layout/leftsideofmarkets'));
//Vue.component('leftsideofevent', require('./components/user/layout/leftsideofevent'));
//Vue.component('rightsidebar', require('./components/user/layout/rightsidebar'));

//Vue.component('markets', require('./components/user/markets.vue'));
//Vue.component('market', require('./components/user/market.vue'));
Vue.component('updatedata', require('./components/updatedata.vue'));
Vue.component('update-runner', require('./components/updateRunner.vue'));
Vue.component('balance', require('./components/user/balance.vue'));
Vue.component('events', require('./components/user/events.vue'));
Vue.component('event', require('./components/user/event.vue'));
Vue.component('betslip', require('./components/user/betslip.vue'));
Vue.component('betslipNew', require('./components/user/betslip_new.vue'));
Vue.component('betslip_item', require('./components/user/betslip_item.vue'));
//Vue.component('placedbet', require('./components/user/placedBet.vue'));
//Vue.component('placedbets', require('./components/user/placedBets.vue'));
Vue.component('eventdetail', require('./components/user/eventdetail.vue'));
//Vue.component('line_chart', require('./components/admin/line_chart.vue'));
//Vue.component('sport_item', require('./components/admin/sport_item.vue'));
//Vue.component('sport_names', require('./components/admin/sport_names.vue'));
//Vue.component('notifications', require('./components/admin/notifications.vue'));

/*
if (user!=undefined && user.id!=undefined){
    axios.defaults.headers.common.auth_key = 'tf1-'+user.id+'-'+rand;
    axios.defaults.headers.common.Authorization = user.login_session;

    axios.defaults.headers.common.Authtype = cryptobject;
    axios.defaults.headers.common.Authentication = md5('tf1-'+user.id+'-'+rand+user.login_session+'tcgtchkmk1014');
}
*/


const app = new Vue({
    el: '#app',
    router,
    firebase
});
//var userId=document.querySelector("meta[name='user-id']").getAttribute('content');


