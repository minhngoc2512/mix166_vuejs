/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//
import Vue from "vue";
import BootstrapVue from "bootstrap-vue";
// /* ...there may be other imports here */
import "bootstrap-vue/dist/bootstrap-vue.css";
import "bootstrap-vue/dist/bootstrap-vue";
import VueSweetAlert from "vue-sweetalert";
import "sweetalert2/dist/sweetalert2.css";
// import VueResource from 'vue-resource';
// import 'bootstrap/dist/css/bootstrap.css'
window.axios = require("axios");

window.axios.defaults.headers.common = {
  "X-CSRF-TOKEN": document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content"),
  "X-Requested-With": "XMLHttpRequest",
  Authorization: "Bearer " + window.cms.api_token
};

// Vue.use(VueResource)
//
Vue.use(BootstrapVue);
window.Vue = require("vue");
Vue.use(VueSweetAlert);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//File Manage
Vue.component("list_file", require("./components/file/manage.vue"));
Vue.component("create_file", require("./components/file/create.vue"));

//User Manager

Vue.component("list_user", require("./components/user/list.vue"));

//Artist
Vue.component("list_artist", require("./components/artist/list.vue"));
//Category
Vue.component("list_category", require("./components/category/list.vue"));
//Genre
Vue.component("list_genre", require("./components/genre/list.vue"));
const app = new Vue({
  el: "#app"
});
