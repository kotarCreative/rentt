<template>
    <div id="main-header">
        <div class="logo-wrapper"></div>
        <ul class="nav">
            <li class="nav-item">
                <a class="listing-btn" href="/property/create">post a listing</a>
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
    </div>
</template>

<script>

    export default {
        name: 'main-header',

        computed: {
            loggedIn() {
                return this.$store.getters['app/user'] ? true : false;
            }
        },

        methods: {
            signin() {

            },

            signout() {

            }
        }
    }
</script>
