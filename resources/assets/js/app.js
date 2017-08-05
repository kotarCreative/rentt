/* Load dependencies */
require('./bootstrap');

require('./components');

/* Vuex Store */
import store from "./store"

/* Create vue instance */
const app = new Vue({
    el: '#app',
    store
});
