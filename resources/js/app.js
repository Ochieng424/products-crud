/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import App from './App.vue';

import axios from 'axios';
import VueAxios from 'vue-axios';

Vue.use(VueAxios, axios);
axios.defaults.baseURL = 'http://127.0.0.1:8000/api';

// VueRouter
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//moment js
import moment from 'moment';

Vue.filter('myDate', function (created) {
    return moment(created).format('MMMM Do YYYY');
});

// VForm
import {Form, HasError, AlertError} from 'vform';

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

// sweetalert
import swal from 'sweetalert2';

window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;
window.Fire = new Vue();

//pagination
Vue.component('pagination', require('laravel-vue-pagination'));

let routes = [
    {
        path: '/', component: require('./components/Home.vue').default, meta: {
            auth: false
        }
    },
    {
        path: '/register', component: require('./components/Register.vue').default, meta: {
            auth: false
        }
    },
    {
        path: '/login', component: require('./components/Login.vue').default, meta: {
            auth: false
        }
    },
    {
        path: '/dashboard', component: require('./components/Dashboard.vue').default, meta: {
            auth: true
        }
    },

    {
        path: '/product_details/:productNo', component: require('./components/ProductDetails.vue').default, meta: {
            auth: true
        }
    },
];
const router = new VueRouter({
    // mode: 'history',
    routes // short for `routes: routes`
})

// websanova
Vue.router = router;

Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});

// VModal
import VModal from 'vue-js-modal';

Vue.use(VModal);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('Nav', require('./components/Nav/Nav.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    render: app => app(App)
});
