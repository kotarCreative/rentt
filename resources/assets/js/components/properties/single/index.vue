<template>
    <div id="single-property-page">
        <div class="row full-height">
            <div class="xs-1-1 sm-1-2 no-padding">
                <vue-gallery :images="images" :view-only="true" class="mobile-show"></vue-gallery>
                <div class="listing-header single-property-section">
                    <h1 v-html="title"></h1>
                    <h5>{{ property.location }}</h5>
                    <h5 class="secondary">Available&#58; {{ property.available_at ? new Date(property.available_at).format('M d, Y') : 'Date Flexible' }}</h5>
                </div>
                <single-property-details></single-property-details>
            </div>
            <div class="xs-1-1 sm-1-2 no-padding">
                <single-property-overview></single-property-overview>
            </div>
        </div>
        <contact-owner-modal></contact-owner-modal>
        <review-property-modal></review-property-modal>
    </div>
</template>

<script>
    import ContactOwnerModal from './modals/contact-owner';
    import ReviewPropertyModal from './modals/leave-review';
    import SinglePropertyDetails from './details';
    import SinglePropertyOverview from './overview';
    export default {
        name: 'single-property-page',

        components: {
            ContactOwnerModal,
            ReviewPropertyModal,
            SinglePropertyDetails,
            SinglePropertyOverview
        },

        props: {
            property: {
                type: Object,
                required: true
            }
        },

        mounted() {
            this.$store.commit('properties/setActive', this.property);
        },

        computed: {
            activeUser() {
                return this.$store.getters['users/active'];
            },

            images() {
                let images = [];

                if (this.property.image_routes) {
                    this.property.image_routes.forEach((image, idx) => {
                        images.push({ image: image, idx: idx });
                    });
                }
                return images;
            },

            title() {
                if (this.activeUser.id !== this.property.user_id) {
                    return this.property.title;
                } else {
                    return this.property.title + '&nbsp;<a class="link" href="/properties/' + this.property.slug + '/edit">edit</a>';
                }
            }
        }
    }
</script>
