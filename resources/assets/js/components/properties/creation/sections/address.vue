<template>
    <div id="property-address-wrapper" class="creation-section-wrapper">
        <h2>Address</h2>
        <div class="form-group">
            <label for="address_line_1">Street Address<sup v-if="hasError('address_line_1')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                :class="{ 'has-error': hasError('address_line_1') }"
                name="address_line_1"
                type="text"
                v-model="property.address_line_1"
                placeholder="Anywhere"
                @input="removeError('address_line_1', $event)">
        </div>
        <div class="form-group">
            <label for="address_line_2">Suite #</label>
            <input
                class="form-control"
                name="address_line_2"
                type="text"
                v-model="property.address_line_2"
                placeholder="Anywhere"
                >
        </div>
        <div class="form-group">
            <label for="subdivision">Province/State</label>
            <v-select class="form-control no-indicator single"
                      name="subdivision"
                      v-model="property.subdivision"
                      :options="subdivisions"
                      label="name"
                      placeholder="Anywhere">
            </v-select>
        </div>
        <div class="form-group">
            <label for="city">City/Town<sup v-if="hasError('city_id')" class="form-errors">*</sup></label>
            <v-select class="form-control no-indicator single"
                      name="city"
                      v-model="property.city"
                      :options="cities"
                      label="name"
                      placeholder="Anywhere"
                      :disabled="property.subdivision == null">
            </v-select>
        </div>
        <div class="form-group">
            <label for="postal">Postal Code<sup v-if="hasError('postal_code')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                :class="{ 'has-error': hasError('postal') }"
                name="postal"
                type="text"
                v-model="property.postal"
                placeholder="Anywhere"
                @input="removeError('postal', $event)">
        </div>
        <div class="form-errors" v-if="hasErrors()">
            <sup>*</sup>Please Complete Required Fields
        </div>
    </div>
</template>

<script>
    import errorMixins from '../../../../mixins/errorMixins'

    export default {
        name: 'property-creation-address',

        mixins: [ errorMixins ],

        mounted() {
            this.populateSubdivisions();
        },

        data: () => ({
            country: {
                id: 1,
                name: 'Canada'
            },
            errorModel: 'properties',
            geocode: null
        }),

        computed: {
            property() {
                return this.$store.getters['properties/active'];
            },

            countries() {
                return this.$store.getters['properties/countries'];
            },

            subdivisions() {
                return this.$store.getters['properties/subdivisions'];
            },

            cities() {
                return this.$store.getters['properties/cities'];
            }
        },

        methods: {
            applyCoordinates(response) {
                if (response.results.length > 0) {
                    var address = response.results[0];
                    this.property.coordinates = address.geometry.location;
                }  else {
                    this.property.coordinates = { lat: null, lng: null }
                }
            },

            geocodeAddress() {
                if (this.geocode) {
                    clearTimeout(this.geocode);
                }

                var func = () => {
                    this.$geocoder.setDefaultMode('address');
                    var addressObj = {
                        address_line_1: this.property.address_line_1,
                        address_line_2: this.property.address_line_2,
                        city:           this.property.city ? this.property.city.name : '',
                        zip_code:       this.property.postal
                    }

                    if (this.country) {
                        addressObj.country = this.country.name;
                    }
                    if (this.property.subdivision) {
                        addressObj.state = this.property.subdivision.name;
                    }

                    this.$geocoder.send(addressObj, response => { this.applyCoordinates(response) });
                }

                this.geocode = setTimeout(func, 1000);
            },


            populateSubdivisions() {
                this.$store.dispatch('properties/getSubdivisions', this.country.id);
            },
        },

        watch: {
            'property.address_line_1'(val) {
                this.property.address_line_1 = val.toUpperCase();
                this.geocodeAddress();
            },

            'property.address_line_2'(val) {
                this.property.address_line_2 = val.toUpperCase();
                this.geocodeAddress();
            },

            'property.subdivision'(val) {
                this.geocodeAddress();
                this.$store.dispatch('properties/getCities', val.id);
            },

            'property.city'(val) {
                this.geocodeAddress();
            },

            'property.postal'(val) {
                this.property.postal = val.toUpperCase();
                this.geocodeAddress();
            }
        }
    }
</script>
