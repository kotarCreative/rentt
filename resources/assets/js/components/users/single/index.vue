<template>
    <div id="view-profile-page">
        <div class="row">
            <div class="content">
                <div class="xs-1-1">
                    <profile-info :profile="profile" type="profile"></profile-info>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="content">
                <div class="xs-1-5"></div>
                <div class="xs-4-5">
                    <ul class="nav sub-nav">
                        <li class="nav-item" :class="{ selected: hasHash('rental-history') }">
                            <a href="#rental-history" @click="hash = '#rental-history'">Rental History</a>
                        </li>
                        <li class="nav-item" :class="{ selected: hasHash('references') }">
                            <a href="#references" @click="hash = '#references'">References</a>
                        </li>
                        <li class="nav-item" :class="{ selected: hasHash('reviews') }">
                            <a href="#reviews" @click="hash = '#reviews'">Reviews</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ProfileInfo from '../info';

    export default {
        name: 'view-profile-page',

        components: {
            ProfileInfo
        },

        data: () => ({
            hash: ''
        }),

        created() {
            this.hash = window.location.hash;
        },

        computed: {
            profile() {
                return this.$store.getters['users/active'];
            }
        },

        methods: {
            hasHash(hash) {
                if (this.hash === '' && hash === 'rental-history') return true;
                return this.hash === '#' + hash;
            }
        }
    }
</script>