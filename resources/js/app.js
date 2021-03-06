/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css'
import axios from 'axios';
import VueAxios from 'vue-axios';

Vue.use(Vuetify, axios, VueAxios);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('toolbar', require('./components/scaffold/ToolbarComponent.vue').default);
Vue.component('list-sales', require('./components/ListSales.vue').default);
Vue.component('tambah-sales', require('./components/TambahSales.vue').default);
Vue.component('job-management', require('./components/JobManagement.vue').default);
Vue.component('list-report', require('./components/ListReport.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        drawer : false,
        menu: false,
        desserts: [],
        current_url: window.location.pathname,
    },
    computed: {
        token() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content
        }
    },
    methods: {
        logout() {
            document.getElementById('logout-form').submit()
        }
    }
});
