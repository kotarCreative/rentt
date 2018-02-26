<template>
    <div id="property-address-wrapper" class="creation-section-wrapper">
        <h2>Address</h2>
        <div class="form-group">
            <label for="address_line_1">Street Address</label>
            <input
                class="form-control"
                name="address_line_1"
                type="text"
                v-model="property.address_line_1"
                placeholder="Anywhere">
        </div>
        <div class="form-group">
            <label for="address_line_2">Suite #</label>
            <input
                class="form-control"
                name="address_line_2"
                type="text"
                v-model="property.address_line_2"
                placeholder="Anywhere">
        </div>
        <div class="form-group">
            <label for="subdivision">Province/State</label>
            <select
                class="form-control"
                name="subdivision"
                v-model="subdivision">
                <option :value="null" disabled>Any</option>
                <option v-for="subdivision in subdivisions" :value="subdivision">{{ subdivision.name }}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="city">City/Town</label>
            <select
                class="form-control"
                name="subdivision"
                v-model="property.city_id"
                :disabled="subdivision == null">
                <option :value="null" disabled>Any</option>
                <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="postal">Postal Code</label>
            <input
                class="form-control"
                name="postal"
                type="text"
                v-model="property.postal"
                placeholder="Anywhere">
        </div>
    </div>
</template>

<script>
    export default {
        name: 'property-creation-address',

        mounted() {
            this.populateSubdivisions();
        },

        data: () => ({
            country: {
                id: 1,
                name: 'Canada'
            },
            subdivision: null,
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
                        city:           this.property.city_id,
                        zip_code:       this.property.postal
                    }

                    if (this.country) {
                        addressObj.country = this.country.name;
                    }
                    if (this.subdivision) {
                        addressObj.state = this.subdivision.name;
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

            subdivision(val) {
                this.geocodeAddress();
                this.$store.dispatch('properties/getCities', val.id);
            },

            'property.city_id'(val) {
                this.geocodeAddress();
            },

            'property.postal'(val) {
                this.property.postal = val.toUpperCase();
                this.geocodeAddress();
            }
        }
    }
</script>
