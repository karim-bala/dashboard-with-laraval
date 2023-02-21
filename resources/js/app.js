/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('admin-lte');


window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import moment from 'moment';

import { Form, HasError, AlertError } from 'vform'
import { values } from 'lodash';

// v-form

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
window.Form=Form

// end v-form

// vue-progressbar

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})

//end vue-progressbar

// sweet alert 2

import Swal from 'sweetalert2';

window.Swal=Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });

  window.Toast=Toast;

// end sweet alert 2

// event listener

window.Event =new Vue();

// end the event listener

// filter
Vue.filter('upText',function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('dateFormate',function(mydate) {
   return moment(mydate).format('MMMM Do YYYY');
});

// end filter


// laravel passport

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

// end laravel passport

// not found component

Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);

// end not found component

// pagination component


Vue.component('pagination', require('laravel-vue-pagination'));

// end pagination component



// auth user info

import Gate from './Gate.js';

Vue.prototype.$gate=new Gate (window.user);
// end auth user info

let routes=[
    {path:'/dashboard',component:require('./components/Dashboard.vue').default},
    {path:'/developer',component:require('./components/Developer.vue').default},
    {path:'/profile',component:require('./components/Profile.vue').default},
    {path:'/users',component:require('./components/Users.vue').default},
    {path:'*',component:require('./components/NotFound.vue').default}
]


const router=new VueRouter({
    mode:"history",
    routes,
  //  linkActiveClass: 'active'
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('not-found', require('./components/NotFound.vue').default);
Vue.component('developer-cmp', require('./components/Developer.vue').default);
Vue.component('dashboard-cmp', require('./components/Dashboard.vue').default);
Vue.component('profile-cmp', require('./components/Profile.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data:{
        search:''
    },
    methods:{
        searchUser:_.debounce(()=>{
            //console.log('it is yes')
            Event.$emit("searching")
        },2500)


    }
});
