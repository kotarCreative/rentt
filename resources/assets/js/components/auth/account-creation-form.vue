<template>
    <div id="account-creation">
        <template v-if="!success">
            <div class="form-group">
                <label for="user-type">Are you a landlord or a tenant?<sup v-if="hasError('user_type')" class="form-errors">*</sup></label>
                <v-checkbox v-model="userType"
                    name="user-type"
                    :options="userTypes"
                    type="radio">
                    <span slot="label" slot-scope="{ option }">{{ option.label }}</span>
                </v-checkbox>
            </div>
            <div class="form-group">
                <label for="first-name">First Name<sup v-if="hasError('first_name')" class="form-errors">*</sup></label>
                <input
                    class="form-control full-width"
                    type="text"
                    name="first-name"
                    placeholder="ie. Jules"
                    v-model="firstName"
                    @input="removeError('first_name', $event)"
                />
            </div>
            <div class="form-group">
                <label for="email">Email<sup v-if="hasError('email')" class="form-errors">*</sup></label>
                <input
                    class="form-control full-width"
                    type="text"
                    name="email"
                    placeholder="ie. captainnemo@thenautilus.com"
                    v-model="email"
                    @input="removeError('email', $event)"
                />
            </div>
            <div class="form-group">
                <label for="password">Password<sup v-if="hasError('password')" class="form-errors">*</sup></label>
                <input
                    class="form-control full-width"
                    type="password"
                    name="password"
                    placeholder="mysteriousIsland"
                    v-model="password"
                    @input="removeError('password', $event)"
                />
            </div>
            <div class="form-group">
                <label for="password">Confirm Password<sup v-if="hasError('password')" class="form-errors">*</sup></label>
                <input
                    class="form-control full-width"
                    type="password"
                    name="confirmed"
                    placeholder="mysteriousIsland"
                    v-model="confirmed"
                    @input="removeError('password_confirmation', $event)"
                />
            </div>
            <div class="form-errors" v-if="hasErrors()">
                <sup>*</sup>{{ errorMessage }}
            </div>
            <div class="login-actions">
                <button class="btn"
                        type="button"
                        @click="save"
                        :disabled="loading">
                    Create</button>
                <loader v-if="loading" />
                <button class="link right"
                        type="button"
                        @click="$emit('login')">
                    Already have an account? Login.
                </button>
            </div>
        </template>
    <template v-else>
        <h2>Thank You!</h2>
        <h5>We've sent you a confirmation email, you know what to do next. Come on back after you've taken care of business.</h5>
        <h5>Wanna be extra awesome and complete your profile info now?</h5>
        <div class="login-actions">
            <a class="btn" href="/profile/edit">Complete Profile</a>
            <button class="link right"
                    type="button"
                    @click="$modals.hide('login')">
                Skip this step
            </button>
        </div>
    </template>
    </div>
</template>

<script>
    import ErrorMixins from '../../mixins/errorMixins';
    import Loader from '../layouts/loader';

    export default {
        name: 'account-creation-form',

        mixins: [ ErrorMixins ],

        components: {
            Loader
        },

        data: () =>  ({
            confirmed: null,
            email: null,
            errorModel: 'users',
            firstName: null,
            password: null,
            success: false,
            userType: null,
            userTypes: [
                {
                    val: 'landlord',
                    label: 'Landlord'
                },
                {
                    val: 'tenant',
                    label: 'Tenant'
                }
            ],
        }),

        computed: {
            errorMessage() {
                if (this.hasError('first_name') || this.hasError('user_type')) {
                    return 'Please fill out required fields';
                }

                if (this.hasError('email')) {
                    return this.showError('email');
                }

                if (this.hasError('password')) {
                    return 'Your password and confirm do not match';
                }


            },

            loading() {
                return this.$store.getters.hasLoading('store-user');
            }
        },

        methods: {
            save() {
                var params = {
                    email: this.email,
                    first_name: this.firstName,
                    password: this.password,
                    password_confirmation: this.confirmed,
                    user_type: this.userType
                }
                this.$store.dispatch('users/store', params)
                    .then(() => {
                        this.success = true;
                        mixpanel.track('Sign up');
                    });
            }
        }
    }
</script>
