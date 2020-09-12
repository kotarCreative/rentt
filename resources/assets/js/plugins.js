import VTooltip from 'v-tooltip'

Vue.use(VTooltip)

/* Google Maps */
const gKey = 'Insert Google Key Here';
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

import VueMoola from '@pderas/vue2-moola';
Vue.use(VueMoola);


/* Vue Modal */
import VueModal from "vue2-modal";

Vue.use(VueModal);

/* Vue Gallery */
import VueGallery from "./plugins/vue2-gallery";

Vue.use(VueGallery);
