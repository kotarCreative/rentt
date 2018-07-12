<template>
    <div id="forgot-password">
        <div v-if="success" class="alert success">
            Password reset email sent!
        </div>
        <div class="form-group">
            <label for="email">Email<sup v-if="hasErrors()" class="form-errors">*</sup></label>
            <input
                class="form-control full-width"
                type="text"
                name="email"
                placeholder="ie. captainnemo@thenautilus.com"
                v-model="email"
                @keyup.enter="reset"
            />
        </div>
        <div class="form-errors" v-if="hasErrors()">
            <sup>*</sup>Please fill in required fields.
        </div>
        <div class="login-actions">
            <button
                class="btn right"
                type="button"
                @click="reset"
            >Send Password Reset Link</button>
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../mixins/errorMixins';

    export default {
        name: 'forgot-password-form',

        mixins: [ ErrorMixins ],

        data: _ => ({
            email: null,
            errorModel: 'users',
            success: false
        }),

        methods: {
            reset() {
                this.$store.dispatch('users/emailResetPassword', this.email)
                    .then(response => {
                        this.success = true;
                    });
            }
        }
    }
</script>