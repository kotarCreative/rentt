<template>
    <div id="account-creation">
        <template v-if="!success">
            <h2>Create Account</h2>
            <div class="form-group">
                <label for="user-type">Are you a landlord or a tenant?</label>
                <v-checkbox v-model="userType"
                    name="user-type"
                    :options="userTypes"
                    type="radio">
                    <span slot="label" slot-scope="{ option }">{{ option.label }}</span>
                </v-checkbox>
            </div>
            <div class="form-group">
                <label for="email">Email<sup v-if="hasError('email')" class="form-errors">*</sup></label>
                <input
                    class="form-control"
                    type="text"
                    name="email"
                    placeholder="ie. captainnemo@thenautilus.com"
                    v-model="email"
                />
            </div>
            <div class="form-group">
                <label for="password">Password<sup v-if="hasError('password')" class="form-errors">*</sup></label>
                <input
                    class="form-control"
                    type="password"
                    name="password"
                    placeholder="mysteriousIsland"
                    v-model="password"
                />
            </div>
            <div class="form-group">
                <label for="password">Confirm Password<sup v-if="hasError('password')" class="form-errors">*</sup></label>
                <input
                    class="form-control"
                    type="password"
                    name="confirmed"
                    placeholder="mysteriousIsland"
                    v-model="confirmed"
                />
            </div>
            <div class="form-errors" v-if="hasErrors()">
                <sup>*</sup>{{ errorMessage }}
            </div>
            <div class="login-actions">
                <button
                    class="btn"
                    type="button"
                    @click="save"
                >Create</button>
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

    export default {
        name: 'account-creation-form',

        mixins: [ ErrorMixins ],

        data: () =>  ({
            confirmed: null,
            email: null,
            errorModel: 'users',
            password: null,
            success: false,
            userType: 'tenant',
            userTypes: [
                {
                    val: 'landlord',
                    label: 'Landlord'
                },
                {
                    val: 'tenant',
                    label: 'Tentant'
                }
            ],
        }),

        computed: {
            errorMessage() {
                if (this.hasError('email')) {
                    return this.showError('email');
                }

                if (this.hasError('password')) {
                    return 'Your password and confirm do not match';
                }
            }
        },

        methods: {
            save() {
                var params = {
                    password_confirmation: this.confirmed,
                    email: this.email,
                    password: this.password,
                    user_type: this.userType
                }
                this.$store.dispatch('users/store', params)
                    .then(() => {
                        this.success = true;
                    });
            }
        }
    }
</script>