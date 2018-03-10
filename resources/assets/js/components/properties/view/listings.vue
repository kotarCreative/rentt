<template>
    <div id="property-listings-wrapper">
        <sub-filters></sub-filters>
        <div class="property-scroller">
            <div class="property-listings">
                <property v-for="(property, idx) in properties" :key="idx" :property="property"></property>
            </div>
        </div>
    </div>
</template>

<script>
    import Property from './SingleProperty';
    import SubFilters from './sub-filters';

    export default {
        name: 'property-listings',

        components: {
            Property,
            SubFilters
        },

        mounted() {
            this.$store.dispatch('properties/search');
        },

        computed: {
            properties() { return this.$store.getters['properties/all'] }
        }
    }
</script>
