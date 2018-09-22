<template>
    <div id="view-profile-page">
        <div class="row">
            <div class="content">
                <div class="xs-1-1 mobile-show">
                    <div class="profile-picture-wrapper">
                        <img v-if="profile.profile_picture"
                             :src="profile.profile_picture"
                             :title="profile.first_name + ' profile picture'"
                             :alt="profile.first_name + ' profile picture'"
                             width="100%"
                             class="profile-picture">
                        <img v-else src="/imgs/profile.png" title="Profile Picture" alt="Empty profile picture" width="100%">
                    </div>
                </div>
                <div class="sm-1-5 mobile-hide">
                    <div class="profile-picture-wrapper">
                        <img v-if="profile.profile_picture"
                             :src="profile.profile_picture"
                             :title="profile.first_name + ' profile picture'"
                             :alt="profile.first_name + ' profile picture'"
                             width="100%"
                             class="profile-picture">
                        <img v-else src="/imgs/profile.png" title="Profile Picture" alt="Empty profile picture" width="100%">
                    </div>
                </div>
                <div class="xs-1-1 sm-4-5">
                    <profile-info :profile="profile" type="profile"></profile-info>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="content">
                <div class="sm-1-5 mobile-hide">
                    <property v-for="(property, idx) in profile.properties"
                              :key="'property-' + idx"
                              :property="property"
                              :hover-active="false"
                              :show-settings="user.id === profile.id"></property>
                </div>
                <div class="sm-4-5 xs-1-1">
                    <div v-if="profile.role === 'tenant'" class="details-wrapper">
                      <h2>Details</h2>
                      <ul class="general-details m-none">
                        <li>Tenant is a {{ profile.is_a_smoker ? 'smoker' : 'non-smoker' }}</li>
                      </ul>
                      <div class="pets-wrapper" id="pets" v-if="profile.role === 'tenant'">
                          <h4 class="mt-0"> {{ profile.pets.length === 0 ? 'No' : '' }} Pets</h4>
                          <ul class="pet-wrapper m-none">
                              <pet v-for="pet in profile.pets" :pet="pet" :key="'pet-' + id"></pet>
                          </ul>
                      </div>
                    </div>
                    <div class="rental-histories-wrapper" id="rental-history" v-if="profile.role === 'tenant'">
                        <h2>{{ profile.rental_history.length == 0 ? 'No' : '' }} Rental History</h2>
                        <rental-history v-for="history in profile.rental_history" :history="history" :key="'his-' + history.id" @contactUser="contactUser"></rental-history>
                    </div>
                    <div class="properties-wrapper mobile-show">
                        <property v-for="(property, idx) in profile.properties"
                              :key="'property-' + idx"
                              :property="property"
                              :hover-active="false"
                              :show-settings="user.id === profile.id"></property>
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
        <single-property-destroy-modal></single-property-destroy-modal>
    </div>
</template>

<script>
    import ContactUserModal from './modals/contact-user';
    import LeaveReviewModal from './modals/leave-review';
    import Pet from './sections/pet';
    import ProfileInfo from '../info';
    import Property from '../../properties/view/single-property';
    import Reference from './sections/reference';
    import RentalHistory from './sections/rental-history';
    import Review from '../../layouts/review';
    import SinglePropertyDestroyModal from '../../properties/single/modals/destroy';
    import SinglePropertySettingsModal from '../../properties/single/modals/settings';

    export default {
        name: 'view-profile-page',

        components: {
            ContactUserModal,
            LeaveReviewModal,
            Pet,
            ProfileInfo,
            Property,
            Reference,
            RentalHistory,
            Review,
            SinglePropertyDestroyModal,
            SinglePropertySettingsModal
        },

        props: {
            profile: {
                type: Object,
                required: true
            }
        },

        data: () => ({
            id: 0,
            type: 'landlord'
        }),

        created() {
            this.$store.dispatch('properties/details');
        },

        mounted() {
            /* Make profile picture square */
            this.resizeProfilePicture();
            window.addEventListener('resize', this.resizeProfilePicture);
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

            resizeProfilePicture() {
               var i,
                    els = document.getElementsByClassName('profile-picture');

                for(i = 0; i < els.length; i++) {
                    var width = els[i].clientWidth;
                    els[i].style.height = width + 'px';
                }
            }
        }
    }
</script>
