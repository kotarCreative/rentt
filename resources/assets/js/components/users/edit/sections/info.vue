<template>
    <div id="profile-info-wrapper" class="creation-section-wrapper">
        <h2>Basic Info</h2>
        <div class="form-group">
            <label for="first-name">First Name<sup v-if="hasError('first_name')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="first-name"
                placeholder="ie. Jules"
                v-model="user.first_name"
                @input="removeError('first_name', $event)"
            />
        </div>
        <div class="form-group">
            <label for="last-name">Last Name<sup v-if="hasError('last_name')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="last-name"
                placeholder="ie. Verne"
                v-model="user.last_name"
                @input="removeError('last_name', $event)"
            />
        </div>
        <div class="form-group">
            <label for="subdivision">Province/State</label>
            <v-select class="form-control single"
                      name="subdivision"
                      v-model="subdivision"
                      :options="subdivisions"
                      label="name"
                      placeholder="Anywhere"
                      @input="fetchCities">
            </v-select>
        </div>
        <div class="form-group">
            <label for="city">City/Town<sup v-if="hasError('city_id')" class="form-errors">*</sup></label>
            <v-select class="form-control single"
                      name="city"
                      v-model="city"
                      :options="cities"
                      label="name"
                      placeholder="Anywhere">
            </v-select>
        </div>
        <!--<div class="form-group">
            <label for="password">Password<sup v-if="hasError('password')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="password"
                name="password"
                placeholder="mysteriousIsland"
                v-model="user.password"
                @input="removeError('password', $event)"
            />
        </div>
        <div class="form-group">
            <label for="password">Confirm Password<sup v-if="hasError('password')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="password"
                name="confirmed"
                placeholder="mysteriousIsland"
                v-model="user.confirmed"
                @input="removeError('password_confirmation', $event)"
            />
        </div>-->
        <div class="form-errors" v-if="hasErrors()">
            <sup>*</sup>{{ errorMessage }}
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../../../mixins/errorMixins';

    export default {
        name: 'profile-basic-info-form',

        mixins: [ ErrorMixins ],

        data: () => ({
            country: {
                id: 1,
                name: 'Canada'
            },
            errorModel: 'users'
        }),

        mounted() {
            this.populateSubdivisions();
            this.fetchCities(true);
        },

        computed: {
            city: {
                get() {
                    var option = this.cities.find(s => s.id == this.user.city_id);
                    return option;
                },
                set(val) {
                    this.$store.commit('users/updateActive', { city_id: val ? val.id : null });
                }
            },

            cities() {
                return this.$store.getters['properties/cities'];
            },

            countries() {
                return this.$store.getters['properties/countries'];
            },

            errorMessage() {
                if (this.hasError('email')) {
                    return this.showError('email');
                }

                if (this.hasError('password')) {
                    return 'Your password and confirm do not match';
                }

                if (this.hasError('first_name')) {
                    return 'Please fill out required fields';
                }
            },

            subdivision: {
                get() {
                    var option = this.subdivisions.find(s => s.id == this.user.subdivision_id);
                    return option;
                },
                set(val) {
                    this.$store.commit('users/updateActive', { subdivision_id: val ? val.id : null });
                }
            },

            subdivisions() {
                return this.$store.getters['properties/subdivisions'];
            },

            user() {
                return this.$store.getters['users/active'];
            }
        },

        methods: {
            fetchCities(dontReset) {
                if (!dontReset) {
                    this.$store.commit('users/updateActive', { city_id: null });
                }
                this.$store.dispatch('properties/getCities', this.user.subdivision_id);
            },

            populateSubdivisions() {
                this.$store.dispatch('properties/getSubdivisions', this.country.id);
            }
        }
    }
</script>