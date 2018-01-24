/* Libraries */
window.Vue = require('vue');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/* Vue Modal */
import VueModal from "vue2-modal";

Vue.use(VueModal);

/* Vue Gallery */
import VueGallery from "./plugins/vue2-gallery";

Vue.use(VueGallery);

/* CSRF token */
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/* Utilities */
import { redirectTo, resizeScreen } from './utilities';
self.redirectTo = redirectTo;

document.onreadystatechange = () => {
    if (document.readyState === 'complete') {
        resizeScreen();
    }
};