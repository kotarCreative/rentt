<template>
    <div id="main-header">
        <div class="logo-wrapper" @click="returnHome">
            <img src="/imgs/main-logo.png" title="Rentt" alt="Return home"/>
        </div>
        <div id="main-filters">
            <property-search :where="where" :bedrooms="bedrooms" in-header="true" :redirect='false' v-if="showFilters == 'true'"></property-search>
        </div>
        <ul class="nav right">
            <li class="nav-item" v-if="activeUser.role == 'landlord'">
                <a class="listing-btn" href="/properties/create">post a listing</a>
            </li>
            <li class="nav-item">
                <a href="/feedback">feedback</a>
            </li>
            <li v-if="!loggedIn" class="nav-item">
                <button type="button" @click="signin">sign up / login</button>
            </li>
            <li v-else class="nav-item">
                <button type="button" @click="signout">sign out</button>
            </li>
        </ul>
        <div id="profile-icon" v-if="loggedIn">
            <a href="/profile">
                <img v-if="!activeUser.profile_picture_route" src="/imgs/profile.png" width="40" height="40" />
                <img v-else :src="activeUser.profile_picture_route" width="40" height="40" />
            </a>
        </div>
        <login-modal></login-modal>
    </div>
</template>

<script>
    import LoginModal from '../auth/login-modal';
    import PropertySearch from '../properties/search';
    import utilMixins from '../../mixins/utilMixins';

    export default {
        name: 'main-header',

        components: {
            LoginModal,
            PropertySearch
        },

        mixins: [ utilMixins ],

        props: {
            showFilters: {
                default: false
            }
        },

        data: () => ({
            bedrooms: null,
            where: null
        }),

        mounted() {
            var params = this.getUrlParams();

            if (typeof params.login !== 'undefined' && params.login == 'true') {
                this.$modals.show('login');
            }

            if (typeof params.bedrooms !== 'undefined') {
                this.bedrooms = params.bedrooms;
            }

            if (typeof params.where !== 'undefined') {
                this.where = params.where;
            }
        },

        computed: {
            activeUser() {
                return this.$store.getters['users/active'];
            },

            loggedIn() {
                return this.$store.getters['users/active'].role !== 'guest' ? true : false;
            }
        },

        methods: {
            signin() {
                this.$modals.show('login');
            },

            signout() {
                this.$store.dispatch('logout');
            },

            returnHome() {
                redirectTo('');
            }
        }
    }
</script>
