<template>
    <div id="header">
        <div class="logo-wrapper"></div>
        <ul class="nav">
            <li class="nav-item">
                <a class="btn" href="">post a listing</a>
            </li>
            <li class="nav-item">
                <a href="">feedback</a>
            </li>
            <li v-if="!loggedIn" class="nav-item">
                <a href="">sign in / login</a>
            </li>
            <li v-else class="nav-item">
                sign out
            </li>
            <li v-if="loggedIn" class="nav-item">

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
        }
    }
</script>
