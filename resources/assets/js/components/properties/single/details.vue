<template>
    <div>
        <div class="single-property-section property-details">
            <div class="property-detail">
                <i class="icon" :class="property.type ? property.type.icon : 'full-house'" aria-hidden="true"></i>
                <div class="detail-label">{{ property.type ? property.type.name : 'N/A' }}</div>
            </div>
            <div class="property-detail">
                <i class="icon bedrooms" aria-hidden="true"></i>
                <div class="detail-label">{{ property.bedrooms ? property.bedrooms + ' Bdrm' : 'N/A' }}</div>
            </div>
            <div class="property-detail">
                <i class="icon bathrooms" aria-hidden="true"></i>
                <div class="detail-label">{{ property.bathrooms ? property.bathrooms + ' Bthrm' : 'N/A' }}</div>
            </div>
            <div class="property-detail">
                <i class="icon size" aria-hidden="true"></i>
                <div class="detail-label">{{ property.size ? parseInt(property.size).toFixed(0) + ' sqft' : 'N/A' }}</div>
            </div>
        </div>
        <div v-if="property.description" class="single-property-section property-desc">
            <p>{{ property.description }}</p>
        </div>
        <div class="single-property-section property-amenities">
            <div class="tagline">
                <h5>Amenities</h5>
            </div>
            <div class="amenities">
                <div class="amenity" v-for="amenity in amenities" :class="{ selected: amSelected(amenity.id) }">
                    <div>
                        <i class="icon" :class="amenity.icon" aria-hidden="true"></i>
                    </div>
                    <h5 v-html="amenity.name.replace(/\s/g, '<br>')"></h5>
                </div>
            </div>
        </div>
        <div class="single-property-section">
            <profile-info type="property" :profile="property.user"></profile-info>
        </div>
        <div class="single-property-section">
            <div class="reviews-header">
                <h2>{{ property.review_count > 0 ? property.review_count : 'No' }} Review{{ parseInt(property.review_count) > 1 || parseInt(property.review_count) == 0 ? 's' : '' }}</h2>
                <button class="link" @click="reviewProperty" v-if="user && user.role != 'landlord' && property.user_id != user.id">Leave a Review</button>
            </div>
            <review v-for="review in property.reviews" :review="review" :key="review.id"></review>
        </div>
    </div>
</template>

<script>
    import ProfileInfo from '../../users/info';
    import Review from '../../layouts/review';

    export default {
        name: 'single-property-details',

        components: {
            ProfileInfo,
            Review
        },

        mounted() { this.$store.dispatch('properties/details') },

        computed: {
            amenities() { return this.$store.getters['properties/amenities'] },

            property() { return this.$store.getters['properties/active'] },

            user () { return this.$store.getters['users/active'] }
        },

        methods: {
            amSelected(am) {
                return this.property.amenityIds.indexOf(am) > -1;
            },

            reviewProperty() {
                this.user.role !== 'guest' ? this.$modals.show('review-property') : this.$modals.show('login');
            }
        }
    }
</script>
