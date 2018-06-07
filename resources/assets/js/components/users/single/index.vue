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
        <div class="row" v-if="profile.role == 'tenant'">
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
                <div class="xs-1-5">
                    <property v-for="(property, idx) in profile.properties"
                              :key="'property-' + idx"
                              :property="property"
                              :hover-active="false"
                              :show-settings="user.id === profile.id"></property>
                </div>
                <div class="xs-4-5">
                    <div class="rental-history-wrapper" id="rental-history" v-if="profile.role == 'tenant'">
                        <h2>{{ profile.rental_history.length == 0 ? 'No' : '' }} Rental History</h2>
                        <rental-history v-for="history in profile.rental_history" :history="history" :key="'his-' + history.id" @contactUser="contactUser"></rental-history>
                    </div>
                    <div class="reviews-wrapper" id="reviews">
                        <div class="reviews-header">
                            <h2>{{ profile.review_count > 0 ? profile.review_count : 'No' }} Review{{ parseInt(profile.review_count) > 1 || parseInt(profile.review_count) == 0 ? 's' : '' }}</h2>
                            <button class="link" @click="$modals.show('review-user')" v-if="user && profile.id != user.id">Leave a Review</button>
                        </div>
                        <review v-for="review in profile.reviews" :review="review" :key="'rev-' + review.id"></review>
                    </div>
                    <div class="references-wrapper" id="references" v-if="profile.role == 'tenant'">
                        <h2> {{ profile.references.length == 0 ? 'No' : '' }} References</h2>
                        <reference v-for="reference in profile.references" :reference="reference" :key="'ref-' + reference.id" @contactUser="contactUser"></reference>
                    </div>
                </div>
            </div>
        </div>
        <contact-user-modal :id="id" :type="type"></contact-user-modal>
        <leave-review-modal :user="profile"></leave-review-modal>
        <single-property-settings-modal></single-property-settings-modal>
    </div>
</template>

<script>
    import ContactUserModal from './modals/contact-user';
    import LeaveReviewModal from './modals/leave-review';
    import ProfileInfo from '../info';
    import Property from '../../properties/view/single-property';
    import Reference from './sections/reference';
    import RentalHistory from './sections/rental-history';
    import Review from '../../layouts/review';
    import SinglePropertySettingsModal from '../../properties/single/modals/settings';

    export default {
        name: 'view-profile-page',

        components: {
            ContactUserModal,
            LeaveReviewModal,
            ProfileInfo,
            Property,
            Reference,
            RentalHistory,
            Review,
            SinglePropertySettingsModal
        },

        props: {
            profile: {
                type: Object,
                required: true
            }
        },

        data: () => ({
            hash: '',
            id: 0,
            type: 'landlord'
        }),

        created() {
            this.hash = window.location.hash;
            this.$store.dispatch('properties/details');
        },

        computed: {
            user() { return this.$store.getters['users/active'] }
        },

        methods: {
            contactUser({ id, type }) {
                this.id = id;
                this.type = type;
                this.$modals.show('contact-user');
            },

            hasHash(hash) {
                if (this.hash === '' && hash === 'rental-history') return true;
                return this.hash === '#' + hash;
            }
        }
    }
</script>
