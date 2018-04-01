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
            <select
                class="form-control"
                name="subdivision"
                v-model="user.subdivision_id"
                @change="fetchCities"
                >
                <option :value="null">Any</option>
                <option v-for="subdivision in subdivisions" :value="subdivision.id">{{ subdivision.name }}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="city">City/Town<sup v-if="hasError('city_id')" class="form-errors">*</sup></label>
            <select
                class="form-control"
                :class="{ 'has-error': hasError('city_id') }"
                name="city"
                v-model="user.city_id"
                :disabled="user.subdivision_id == null"
                @input="removeError('city_id', $event)">
                <option :value="null">Any</option>
                <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
            </select>
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
            this.fetchCities();
        },

        computed: {
            countries() {
                return this.$store.getters['properties/countries'];
            },

            subdivisions() {
                return this.$store.getters['properties/subdivisions'];
            },

            cities() {
                return this.$store.getters['properties/cities'];
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

            user() {
                return this.$store.getters['users/active'];
            }
        },

        methods: {
            fetchCities() {
                this.$store.dispatch('properties/getCities', this.user.subdivision_id);
            },

            populateSubdivisions() {
                this.$store.dispatch('properties/getSubdivisions', this.country.id);
            }
        }
    }
</script>