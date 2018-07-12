<template>
    <div id="reset-password">
        <h1>Reset Password</h1>
        <div class="form-group">
            <label for="email">Email<sup v-if="hasErrors()" class="form-errors">*</sup></label>
            <input
                class="form-control full-width"
                type="text"
                name="email"
                placeholder="ie. captainnemo@thenautilus.com"
                v-model="email"
            />
        </div>
        <div class="form-group">
            <label for="password">Password<sup v-if="hasErrors() && !password" class="form-errors">*</sup></label>
            <input
                class="form-control full-width"
                type="password"
                name="password"
                placeholder="mysteriousIsland"
                v-model="password"
            />
        </div>
        <div class="form-group">
            <label for="password-confirmation">Confirm Password<sup v-if="hasError('password')" class="form-errors">*</sup></label>
            <input
                class="form-control full-width"
                type="password"
                name="password-confirmation"
                placeholder="mysteriousIsland"
                v-model="password_confirmation"
                @input="removeError('password_confirmation', $event)"
            />
        </div>
        <div class="form-errors" v-if="hasErrors()">
            <sup>*</sup>Please fill in required fields.
        </div>
        <div class="login-actions">
            <button
                class="btn right"
                type="button"
                @click="reset">
                Reset Password
            </button>
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../mixins/errorMixins';

    export default {
        name: 'reset-password-form',

        mixins: [ ErrorMixins ],

        props: {
            token: {
                type: String,
                required: true
            }
        },

        data: _ => ({
            email: null,
            errorModel: 'users',
            password: null,
            password_confirmation: null
        }),

        methods: {
            reset() {
                var params = {
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    token: this.token
                };

                this.$store.dispatch('users/resetPassword', params)
                    .then(response => {
                        redirectTo('');
                    });
            }
        }
    }
</script>