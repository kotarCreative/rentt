<template>
    <div id="login">
        <h2>Login</h2>
        <div class="form-group">
            <label for="email">Email</label>
            <input
                class="form-control"
                type="text"
                name="email"
                placeholder="ie. captainnemo@thenautilus.com"
                v-model="email"
            />
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input
                class="form-control"
                type="password"
                name="password"
                placeholder="mysteriousIsland"
                v-model="password"
            />
        </div>
        <div class="form-group">
            <v-checkbox
                name="remember"
                v-model="remember">
                <span slot="label">Remember me?</span>
            </v-checkbox>
        </div>
        <button
            class="btn"
            type="button"
            @click="login"
        >Log in</button>
    </div>
</template>

<script>
    export default {
        name: 'login-form',

        data() {
            return {
                email: null,
                password: null,
                remember: false
            }
        },

        methods: {
            login() {
                this.$store.dispatch('login', { email: this.email, password: this.password });
            }
        }
    }
</script>
