<template>
    <div id="property-listings-wrapper">
        <sub-filters></sub-filters>
        <div class="property-scroller">
            <div v-if="properties.length > 0" class="property-listings">
                <property v-for="(property, idx) in properties" :key="idx" :property="property"></property>
            </div>
            <div v-else-if="!loading && !firstSearch" class="property-listings-warning">
                <div class="error-image">
                    <img src="/imgs/error-logo.png" alt="There was an error.">
                </div>
                <div class="error-content">
                    <h1>Too Bad!</h1>
                    <h3>There are no listings for this area yet.</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Property from './single-property';
    import SubFilters from './sub-filters';
    import UtilMixins from '../../../mixins/utilMixins';

    export default {
        name: 'property-listings',

        components: {
            Property,
            SubFilters
        },

        mixins: [ UtilMixins ],

        data: _ => ({
            firstSearch: true
        }),

        mounted() {
            let params = this.getUrlParams();
            if (params.bedrooms) {
                this.$store.commit('properties/updateSearch', { key: 'bedrooms', val: params.bedrooms });
            }
            if (params.where) {
                this.$store.commit('properties/updateSearch', { key: 'where', val: params.where });
            }
            this.$store.dispatch('properties/search').then(response => {
                this.firstSearch = false;
                this.$emit('searchComplete')
            });
        },

        computed: {
            loading() { return this.$store.getters.hasLoading('search-properties') },

            properties() { return this.$store.getters['properties/all'] }
        }
    }
</script>
