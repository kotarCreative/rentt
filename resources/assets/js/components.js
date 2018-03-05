// Layouts
var layouts = './components/layouts/';
Vue.component('main-header', require(layouts + 'header.vue'));
Vue.component('v-checkbox', require(layouts + 'vue-checkbox.vue'));

// Auth
var auth = './components/auth/';
Vue.component('login-form', require(auth + 'login.vue'));
Vue.component('active-user', require(auth + 'activeUser.vue'));

// Property Components
var properties = './components/properties/';
Vue.component('property-search', require(properties + 'search.vue'));
Vue.component('property-creation', require(properties + 'creation/index.vue'));
Vue.component('properties-page', require(properties + 'index.vue'));
