// Layouts
var layouts = './components/layouts/';
Vue.component('main-header', require(layouts + 'header.vue'));
Vue.component('v-checkbox', require(layouts + 'vue-checkbox.vue'));
Vue.component('v-slider', require(layouts + 'vue-slider.vue'));

// Forms
var forms = './components/forms/';
Vue.component('feedback-form', require(forms + 'feedback.vue'));

// Auth
var auth = './components/auth/';
Vue.component('active-user', require(auth + 'active-user.vue'));

// Property Components
var properties = './components/properties/';
Vue.component('property-search', require(properties + 'search.vue'));
Vue.component('property-creation', require(properties + 'creation/index.vue'));
Vue.component('properties-page', require(properties + 'view/index.vue'));
Vue.component('single-property-page', require(properties + 'single/index.vue'));

// Profile Components
var users = './components/users/';
Vue.component('profile-edit', require(users + 'edit/index.vue'));
Vue.component('view-profile-page', require(users + 'single/index.vue'));
