
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//
import Vue from 'vue'
// import BootstrapVue from 'bootstrap-vue'
// /* ...there may be other imports here */
// import 'bootstrap-vue/dist/bootstrap-vue.css'
// import 'bootstrap/dist/css/bootstrap.css'
//
// Vue.use(BootstrapVue);
window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('list_file', require('./components/file/manage.vue'));

const app = new Vue({
    el: '#app'
});
