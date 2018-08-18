<template>
    <div id="property-listings-index">
        <div class="row full-height">
            <div class="xs-1-1 sm-3-5 no-padding">
                <listings style="grid" @searchComplete="searchComplete = true"></listings>
            </div>
            <div class="xs-1-1 sm-2-5 no-padding mobile-hide">
                <listing-map :search-complete="searchComplete"></listing-map>
            </div>
        </div>
    </div>
</template>

<script>
    import Listings from './listings';
    import ListingMap from './map';

    export default {
        name: 'properties-page',

        components: {
            Listings,
            ListingMap
        },

        data: _ => ({
            searchComplete: false
        }),

        mounted() {
            document.onreadystatechange = () => {
                if (document.readyState === 'complete') {
                    let headerHeight = document.getElementById('main-header').clientHeight;
                    resizeScreen(headerHeight);
                }
            }
            this.$store.dispatch('properties/details')
        }
    }
</script>
