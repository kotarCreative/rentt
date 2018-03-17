<template>
    <div id="single-property-page">
        <div class="row full-height">
            <div class="sm-1-2 no-padding">
                <div class="listing-header single-property-section">
                    <h1>{{ property.title }}</h1>
                    <h5>{{ property.location }}</h5>
                    <h5 class="secondary">Available &#8226; {{ new Date(property.available_at).toFormattedString('long', false) }}</h5>
                </div>
                <single-property-details :property="property"></single-property-details>
            </div>
            <div class="sm-1-2 no-padding"></div>
        </div>
    </div>
</template>

<script>
    import SinglePropertyDetails from './details';

    export default {
        name: 'single-property-page',

        components: {
            SinglePropertyDetails
        },

        props: {
            property: {
                type: Object,
                required: true
            }
        }
    }
</script>