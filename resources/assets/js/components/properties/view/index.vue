<template>
    <div id="property-listings-wrapper">
        <div class="row full-height">
            <div class="xs-1-1 sm-2-3">
                <listings style="grid"></listings>
            </div>
            <div class="xs-1-1 sm-1-3">
                <map></map>
            </div>
        </div>
    </div>
</template>

<script>
    import Listings from './listings';
    import Map from './map';

    export default {
        name: 'properties-page',

        components: {
            Listings,
            Map
        },

        mounted() {
            document.onreadystatechange = () => {
                if (document.readyState === 'complete') {
                    let headerHeight = document.getElementById('main-header').clientHeight;
                    resizeScreen(headerHeight);
                }
            }
        },
    }
</script>
