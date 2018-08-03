<template>
    <div id="main-header">
        <div class="logo-wrapper" @click="returnHome">
            <img src="/imgs/main-logo.png" title="Rentt" alt="Return home"/>
        </div>
        <div id="main-filters">
            <property-search :where="where" :bedrooms="bedrooms" in-header="true" :redirect='false' v-if="showFilters == 'true'"></property-search>
        </div>
        <ul class="nav right">
            <li v-if="activeUser.role != 'tenant'" class="nav-item mobile-hide">
                <button class="btn" @click="postListing">Post a listing</button>
            </li>
            <li class="nav-item mobile-hide">
                <a href="/feedback">Feedback</a>
            </li>
            <template v-if="!loggedIn">
                <li class="nav-item">
                        <button type="button" @click="signup">Sign up</button>
                </li>
                <li class="nav-item">
                        <button type="button" @click="signin">Login</button>
                </li>
            </template>
            <li v-else class="nav-item mobile-hide">
                <button type="button" @click="signout">Sign out</button>
            </li>
        </ul>
        <div id="profile-icon" v-if="loggedIn">
            <button class="btn blank" @click="profileClick">
                <img v-if="!activeUser.profile_picture_route" src="/imgs/profile.png" width="40" height="40" />
                <img v-else :src="activeUser.profile_picture_route" width="40" height="40" class="profile-picture" />
            </button>
        </div>
        <div class="mobile-menu-wrapper" :class="{ open: menuOpen }">
            <button class="mobile-menu-close-btn" @click="toggleMenu">
                &times;
            </button>
            <a v-if="activeUser.role == 'landlord'" class="mobile-menu-btn" href="/properties/create">
                Post a Listing
            </a>
            <a class="mobile-menu-btn" :href="'/profile/' + activeUser.slug">
                Profile
            </a>
            <a class="mobile-menu-btn" href="/feedback">
                Feedback
            </a>
            <button class="mobile-menu-btn" @click="signout">
                Sign Out
            </button>
        </div>
        <login-modal ref="loginModal"></login-modal>
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
            isMobile: false,
            menuOpen: false,
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

            // Check mobile sizing
            this.isMobile = window.innerWidth < 600;
            window.addEventListener('resize', _ => {
                this.isMobile = window.innerWidth < 600;
            });
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
            postListing() {
                if (!this.loggedIn) {
                    this.signin();
                } else if (this.activeUser.role == 'landlord') {
                    redirectTo('/properties/create');
                }
            },

            profileClick() {
                if (this.isMobile) {
                    this.toggleMenu();
                } else {
                    redirectTo('/profile/' + this.activeUser.slug);
                }
            },

            returnHome() {
                redirectTo('');
            },

            signin() {
                this.$refs.loginModal.$data.show = 'login';
                this.$modals.show('login');
            },

            signup() {
                this.$refs.loginModal.$data.show = 'account';
                this.$modals.show('login');
            },

            signout() {
                this.$store.dispatch('logout');
            },

            toggleMenu() {
                this.menuOpen = !this.menuOpen;
            }
        }
    }
</script>
