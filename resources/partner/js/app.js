
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.md5 = require('md5');
window.dateFormat = require('date-and-time');
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

Vue.component('balance', require('./components/balance.vue'));

Vue.component('leftsidebar', require('./components/user/layout/leftsidebar.vue'));

Vue.component('events', require('./components/events.vue'));
Vue.component('event', require('./components/event.vue'));



Vue.component('betslip', require('./components/betslip.vue'));
Vue.component('betslip_item', require('./components/betslip_item.vue'));
Vue.component('eventdetail', require('./components/eventdetail.vue'));

//Vue.component('addmaster', require('./components/add_master_modal.vue'));
// Vue.component('changepassword', require('./components/change_password.vue'));

//Vue.component('deposit', require('./components/deposit_modal.vue'));

Vue.component('closeuserlist', require('./components/closeuserlist.vue'));
Vue.component('betslipNew', require('./components/betslip_new.vue'));

Vue.use(VueRouter);
const routes = [

    { path: '/multi_market', component:  require('./components/pages/multiMarkets.vue')},
    { path: '/fancyMarkets', component:  require('./components/pages/fancyMarkets.vue')},
    { path: '/sport/:sport_id', component:  require('./components/pages/sport.vue')},

    { path: '/my_market', component:  require('./components/pages/my_market.vue')},
    { path: '/', component: require('./components/pages/home.vue')},
    { path: '/client/master', component: require('./components/pages/client_list/master/index.vue')},
    { path: '/client/distributor', component: require('./components/pages/client_list/distributor/index.vue')},
    { path: '/client/user', component: require('./components/pages/client_list/user/index.vue')},
    { path: '/inplay', component:  require('./components/pages/in_play')},
    { path: '/event/:event_id', component:  require('./components/pages/event.vue')},
];
const router = new VueRouter({
    routes
});
var md5 = require('md5');
var user=JSON.parse(document.querySelector("meta[name='user']").getAttribute('content'));
axios.defaults.headers.common.Authorization = user.login_session;
var rand=uuidv1();
axios.defaults.headers.common.Authtype = 'tf2-'+user.id+'-'+rand;
axios.defaults.headers.common.Authentication = md5('tf2-'+user.id+'-'+rand+user.login_session+'tcgtchkmk1014');



const app = new Vue({
    el: '#app',
    router,
    firebase
});
//var userId=document.querySelector("meta[name='user-id']").getAttribute('content');


