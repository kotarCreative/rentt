<template>
    <div id="login">
        <div class="form-group">
            <label for="email">Email<sup v-if="hasErrors() && !email" class="form-errors">*</sup></label>
            <input
                class="form-control full-width"
                type="text"
                name="email"
                placeholder="ie. captainnemo@thenautilus.com"
                v-model="email"
                @keyup.enter="login"
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
                @keyup.enter="login"
            />
        </div>
        <div class="form-group flex">
            <v-checkbox
                name="remember"
                v-model="remember">
                <span slot="label">Remember me?</span>
            </v-checkbox>
            <button class="link right"
                    type="button"
                    @click="$emit('forgotPassword')">
                Forgot Password?
            </button>
        </div>
        <div class="form-errors" v-if="hasErrors() && hasError('email') && showError('email') == 'These credentials do not match our records.'">
            Whoops. Something was typed incorrectly.
        </div>
        <div class="form-errors" v-else-if="hasErrors()">
            <sup>*</sup>Please fill in required fields.
        </div>
        <div class="login-actions">
            <button class="btn"
                    type="button"
                    @click="login"
                    :disabled="loading">
                Log in</button>
            <loader v-if="loading" />
            <button class="link right"
                    type="button"
                    @click="$emit('createAccount')">
                Create a free account
            </button>
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../mixins/errorMixins';
    import Loader from '../layouts/loader';

    export default {
        name: 'login-form',

        mixins: [ ErrorMixins ],

        components: {
            Loader
        },

        data: () => ({
            email: null,
            password: null,
            remember: false,
            errorModel: 'app'
        }),

        computed: {
            loading() {
                return this.$store.getters.hasLoading('log-in');
            }
        },

        methods: {
            login() {
                this.$store.dispatch('login', { email: this.email, password: this.password });
            }
        }
    }
</script>
