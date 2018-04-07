<template>
    <div id="view-profile-page">
        <div class="row">
            <div class="content">
                <div class="xs-1-5">
                    <div class="profile-picture-wrapper">
                        <img v-if="profile.profile_picture_route" :src="profile.profile_picture_route" :title="profile.first_name + ' profile picture'" :alt="profile.first_name + ' profile picture'" width="100%">
                        <img v-else src="/imgs/profile.png" title="Profile Picture" alt="Empty profile picture" width="100%">
                    </div>
                </div>
                <div class="xs-4-5">
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
                        <li class="nav-item" :class="{ selected: hasHash('reviews') }">
                            <a href="#reviews" @click="hash = '#reviews'">Reviews</a>
                        </li>
                        <li class="nav-item" :class="{ selected: hasHash('references') }">
                            <a href="#references" @click="hash = '#references'">References</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="content">
                <div class="xs-1-5"></div>
                <div class="xs-4-5">
                    <h2>Rental History</h2>
                    <rental-history v-for="history in profile.rental_history" :history="history" :key="history.id"></rental-history>
                    <div class="reviews-header">
                        <h2>{{ profile.review_count > 0 ? profile.review_count : 'No' }} Review{{ parseInt(profile.review_count) > 1 || parseInt(profile.review_count) == 0 ? 's' : '' }}</h2>
                        <button class="link" @click="$modals.show('review-profile')" v-if="user && profile.id != user.id">Leave a Review</button>
                    </div>
                    <review v-for="review in profile.reviews" :review="review" :key="review.id"></review>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import RentalHistory from './sections/rental-history';
    import ProfileInfo from '../info';

    export default {
        name: 'view-profile-page',

        components: {
            RentalHistory,
            ProfileInfo
        },

        props: {
            profile: {
                type: Object,
                required: true
            }
        },

        data: () => ({
            hash: ''
        }),

        created() {
            this.hash = window.location.hash;
        },

        computed: {
            user() { return this.$store.getters['users/active'] }
        },

        methods: {
            hasHash(hash) {
                if (this.hash === '' && hash === 'rental-history') return true;
                return this.hash === '#' + hash;
            }
        }
    }
</script>
