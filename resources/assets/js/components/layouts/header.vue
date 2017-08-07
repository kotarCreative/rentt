<template>
    <div id="main-header">
        <div class="logo-wrapper"></div>
        <ul class="nav">
            <li class="nav-item">
                <a class="listing-btn" href="/properties/create">post a listing</a>
            </li>
            <li class="nav-item">
                <a href="/feedback">feedback</a>
            </li>
            <li v-if="!loggedIn" class="nav-item">
                <button type="button" @click="signin">sign in / login</button>
            </li>
            <li v-else class="nav-item">
                <button type="button" @click="signout">sign out</button>
            </li>
            <li v-if="loggedIn" class="nav-item">
                <button></button>
            </li>
        </ul>
        <vue-modal
            :on-close="closeLogin"
            name="login"
        >
            <h2 slot="title">Login</h2>
            <login-form></login-form>
        </vue-modal>
    </div>
</template>

<script>
    import LoginForm from "../auth/login";
    export default {
        name: 'main-header',

        components: {
            LoginForm
        },

        computed: {
            loggedIn() {
                return this.$store.getters['activeUser'] ? true : false;
            }
        },

        methods: {
            signin() {
                this.$modals.showModal('login');
            },

            signout() {
                this.$store.dispatch('logout');
            },

            closeLogin() {

            }
        }
    }
</script>
