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
self.resizeScreen = resizeScreen;

/* Google Maps */
const gKey = 'AIzaSyBrmCssbdW86R4pfKivqGnU1MoiwVPNNHA';
import * as VueGoogleMaps from 'vue2-google-maps'
Vue.use(VueGoogleMaps, {
  load: {
    key: gKey,
    libraries: 'drawing'
  }
});

import VueGeocoder from '@pderas/vue2-geocoder';
Vue.use(VueGeocoder, {
    googleMapsApiKey: gKey
});

import VueSelect from 'vue-select';
Vue.component('v-select', VueSelect);

/**
 * Prototype Extensions
 */
Date.prototype.toFormattedString = function(format = 'M d Y') {
    var months = [
        { short: "Jan", long: "January" },
        { short: "Feb", long: "February" },
        { short: "Mar", long: "March" },
        { short: "Apr", long: "April" },
        { short: "May", long: "May" },
        { short: "Jun", long: "June" },
        { short: "Jul", long: "July" },
        { short: "Aug", long: "August" },
        { short: "Sep", long: "September" },
        { short: "Oct", long: "October" },
        { short: "Nov", long: "November" },
        { short: "Dec", long: "December" }
    ];

    // Insert Year
    var withYear = format.replace('Y', this.getFullYear());
    var withYear = format.replace('y', this.getFullYear.toString().slice(2));

    console.log(format);
    // Insert Month
    var withMonth = withYear.replace(/M/, months[0]['long']);
    var withMonth = withYear.replace(/m/, months[0]['short']);

    // Insert Date
    var withDate = withMonth.replace(/d/, this.getDate());

    // Insert Time
    var hours = this.getHours() % 12 == 0 ? 12 : this.getHours() % 12;
    var mins = this.getMinutes();
    mins = mins < 10 ? "0" + mins : mins;
    var period = this.getHours() >= 12 ? 'PM' : 'AM';

    format = format.replace(/T/, hours + ':' + mins + ' ' + period);
    format = format.replace(/H/, hours);
    format = format.replace(/i/, mins);
    format = format.replace(/s/, this.getSeconds());
    format = format.replace(/a/, period);

    return withDate;
}
