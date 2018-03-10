<template>
    <div id="property-listings-index">
        <div class="row full-height">
            <div class="xs-1-1 sm-2-3 no-padding">
                <listings style="grid"></listings>
            </div>
            <div class="xs-1-1 sm-1-3 no-padding">
                <listing-map :properties="properties"></listing-map>
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

        mounted() {
            document.onreadystatechange = () => {
                if (document.readyState === 'complete') {
                    let headerHeight = document.getElementById('main-header').clientHeight;
                    resizeScreen(headerHeight);
                }
            }
        },

        computed: {
            properties() { return this.$store.getters['properties/all'] }
        }
    }
</script>
