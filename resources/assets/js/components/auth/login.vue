<template>
    <div id="login">
        <div class="form-group">
            <label for="email">Email</label>
            <input
                class="form-control"
                type="text"
                placeholder="ie. captainnemo@thenautilus.com"
                v-model="email"
            />
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input
                class="form-control"
                type="password"
                placeholder="mysteriousIsland"
                v-model="password"
            />
        </div>
        <div class="form-group">
            <button
                class="btn"
                type="button"
                @click="login"
            >Log in</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'login-form',

        data() {
            return {
                email: null,
                password: null
            }
        },

        methods: {
            login() {
                this.$store.dispatch('login', { email: this.email, password: this.password });
            }
        }
    }
</script>
