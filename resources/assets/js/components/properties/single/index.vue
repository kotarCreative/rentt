<template>
    <div id="single-property-page">
        <div class="row full-height">
            <div class="sm-1-2 no-padding">
                <div class="listing-header single-property-section">
                    <h1>{{ property.title }}</h1>
                    <h5>{{ property.location }}</h5>
                    <h5 class="secondary">Available &#8226; {{ new Date(property.available_at).toFormattedString('long', false) }}</h5>
                </div>
                <single-property-details></single-property-details>
            </div>
            <div class="sm-1-2 no-padding">
                <single-property-overview></single-property-overview>
            </div>
        </div>
        <contact-owner-modal></contact-owner-modal>
    </div>
</template>

<script>
    import ContactOwnerModal from './modals/contact-owner';
    import SinglePropertyDetails from './details';
    import SinglePropertyOverview from './overview';
    export default {
        name: 'single-property-page',

        components: {
            ContactOwnerModal,
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
        }
    }
</script>